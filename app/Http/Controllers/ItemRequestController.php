<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class ItemRequestController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch items that are available (quantity > 0 and status is 'available')
        // You might want to further filter items based on other criteria
        $availableItems = Item::where('quantity', '>', 0)
                              ->where('status', 'available') // Assuming 'available' is the correct status
                              ->orderBy('name')
                              ->get();

        return view('requests.create', compact('availableItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'item_id' => [
                'required',
                'exists:items,id',
                // Custom rule to check if the item is actually available and has enough quantity
                Rule::exists('items', 'id')->where(function ($query) use ($request) {
                    $query->where('quantity', '>=', $request->input('requested_quantity', 1))
                          ->where('status', 'available');
                }),
            ],
            'requested_quantity' => 'required|integer|min:1',
            'remarks' => 'nullable|string|max:1000',
        ], [
            'item_id.exists' => 'The selected item is not available or does not have enough quantity for your request.' 
        ]);

        $item = Item::findOrFail($validatedData['item_id']);

        // Double check quantity just in case (though validator should handle it)
        if ($item->quantity < $validatedData['requested_quantity'] || $item->status !== 'available') {
            return back()->with('error', 'The selected item is no longer available or stock is insufficient.')->withInput();
        }

        ItemRequest::create([
            'item_id' => $validatedData['item_id'],
            'user_id' => Auth::id(),
            'requested_quantity' => $validatedData['requested_quantity'],
            'status' => 'pending', // Default status for new requests
            'remarks' => $validatedData['remarks'],
            // 'processed_by_id' and 'processed_at' will be null initially
        ]);

        return redirect()->route('dashboard')->with('success', 'Item request submitted successfully. You will be notified once it is processed.');
    }

    /**
     * Allows a staff member to request to return an approved item.
     */
    public function initiateReturn(ItemRequest $itemRequest)
    {
        // Check if the authenticated user is the one who owns this request
        if ($itemRequest->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to modify this request.');
        }

        // Check if the request was actually approved (and not already returned or pending return)
        if ($itemRequest->status !== 'approved') {
            return redirect()->route('dashboard')->with('error', 'This item cannot be requested for return or has already been processed.');
        }

        // Update the status to indicate it's pending return approval by admin
        $itemRequest->status = 'pending_return_approval';
        // You could add a field for 'return_requested_at' = now() if needed
        $itemRequest->save();

        return redirect()->route('dashboard', ['#borrowed-items'])->with('success', 'Return requested for "' . $itemRequest->item->name . ".\nPlease wait for admin approval.");
    }

    /**
     * Display a listing of the authenticated staff user's item requests.
     */
    public function myRequestsIndex(Request $request)
    {
        $user = Auth::user();
        $status = $request->query('status', 'all'); // Default to all requests

        $query = ItemRequest::where('user_id', $user->id)
                            ->with('item', 'processedBy')
                            ->orderBy('created_at', 'desc');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $myRequests = $query->paginate(15); // Or your preferred pagination number

        return view('requests.my_index', compact('myRequests', 'status'));
    }

    /**
     * Generate and download a PDF report of the authenticated staff user's item requests.
     */
    public function downloadMyTransactionsReport()
    {
        $user = Auth::user();
        $myRequests = ItemRequest::where('user_id', $user->id)
                                 ->with('item', 'processedBy')
                                 ->orderBy('created_at', 'desc')
                                 ->get();

        $data = [
            'title' => 'My Transaction Report',
            'date' => date('m/d/Y'),
            'user' => $user,
            'requests' => $myRequests,
        ];

        // Make sure the view path is correct, e.g., resources/views/pdf/my_transactions_report.blade.php
        $pdf = Pdf::loadView('pdf.my_transactions_report', $data);
        
        $fileName = 'my_transactions_report_' . date('YmdHis') . '.pdf';
        return $pdf->download($fileName);
    }
} 