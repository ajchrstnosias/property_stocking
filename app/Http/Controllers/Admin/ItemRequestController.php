<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemRequest;
use App\Models\Item;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemRequestController extends Controller
{
    /**
     * Display a listing of the item requests.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'all'); // Default to all requests
        $query = ItemRequest::with(['item', 'user', 'processedBy'])->orderBy('created_at', 'desc');

        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $itemRequests = $query->paginate(15);

        return view('admin.requests.index', compact('itemRequests', 'status'));
    }

    /**
     * Approve the specified item issuance request.
     */
    public function approve(ItemRequest $itemRequest)
    {
        if ($itemRequest->status !== 'pending') {
            return redirect()->route('admin.requests.index', ['status' => $itemRequest->status])->with('error', 'This request has already been processed or is not pending approval.');
        }

        $item = $itemRequest->item;

        if (!$item) {
            return redirect()->route('admin.requests.index', ['status' => 'pending'])->with('error', 'Associated item not found for this request.');
        }

        if ($item->quantity < $itemRequest->requested_quantity) {
            $itemRequest->status = 'denied';
            $itemRequest->processed_by_id = Auth::id();
            $itemRequest->processed_at = now();
            $itemRequest->remarks = 'Denied due to insufficient stock at time of approval. (' . $item->quantity . ' available)';
            $itemRequest->save();
            return redirect()->route('admin.requests.index', ['status' => 'pending'])->with('error', 'Request denied. Insufficient stock for item: ' . $item->name . ' (' . $item->quantity . ' available, ' . $itemRequest->requested_quantity . ' requested).');
        }

        DB::beginTransaction();
        try {
            $item->quantity -= $itemRequest->requested_quantity;
            $item->save();

            $itemRequest->status = 'approved';
            $itemRequest->processed_by_id = Auth::id();
            $itemRequest->processed_at = now();
            $itemRequest->remarks = $itemRequest->remarks ? $itemRequest->remarks . ' | Approved by ' . Auth::user()->name : 'Approved by ' . Auth::user()->name;
            $itemRequest->save();

            StockMovement::create([
                'item_id' => $item->id,
                'type' => 'out_approved', // Item issued out
                'quantity_changed' => -$itemRequest->requested_quantity,
                'reason' => 'Item request #' . $itemRequest->id . ' approved for user ' . ($itemRequest->user->name ?? 'N/A'),
                'user_id' => Auth::id(), // Admin who approved
                'movement_date' => now(),
            ]);

            DB::commit();
            return redirect()->route('admin.requests.index', ['status' => 'pending'])->with('success', 'Item request #' . $itemRequest->id . ' approved and item issued successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.requests.index', ['status' => 'pending'])->with('error', 'Failed to approve request. An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Deny the specified item issuance request.
     */
    public function deny(Request $request, ItemRequest $itemRequest)
    {
        if ($itemRequest->status !== 'pending') {
            return redirect()->route('admin.requests.index', ['status' => $itemRequest->status])->with('error', 'This request has already been processed or is not pending approval.');
        }

        $request->validate(['remarks' => 'nullable|string|max:500']);

        $itemRequest->status = 'denied';
        $itemRequest->processed_by_id = Auth::id();
        $itemRequest->processed_at = now();
        $itemRequest->remarks = $request->input('remarks', 'Request denied by administrator.');
        $itemRequest->save();

        return redirect()->route('admin.requests.index', ['status' => 'pending'])->with('success', 'Item request #' . $itemRequest->id . ' denied successfully.');
    }

    /**
     * Approve the return of a previously issued item.
     */
    public function approveReturn(ItemRequest $itemRequest)
    {
        if ($itemRequest->status !== 'pending_return_approval') {
            return redirect()->route('admin.requests.index', ['status' => $itemRequest->status])->with('error', 'This request is not pending return approval.');
        }

        $item = $itemRequest->item;
        if (!$item) {
            return redirect()->route('admin.requests.index', ['status' => 'pending_return_approval'])->with('error', 'Associated item not found for this return request.');
        }

        DB::beginTransaction();
        try {
            $item->quantity += $itemRequest->requested_quantity;
            $item->save();

            $itemRequest->status = 'returned';
            $itemRequest->processed_by_id = Auth::id();
            $itemRequest->processed_at = now();
            $itemRequest->remarks = $itemRequest->remarks ? $itemRequest->remarks . ' | Return approved by ' . Auth::user()->name : 'Return approved by ' . Auth::user()->name;
            $itemRequest->save();

            StockMovement::create([
                'item_id' => $item->id,
                'type' => 'in_returned', // Item returned to stock
                'quantity_changed' => $itemRequest->requested_quantity, // Positive quantity
                'reason' => 'Item return for request #' . $itemRequest->id . ' approved from user ' . ($itemRequest->user->name ?? 'N/A'),
                'user_id' => Auth::id(), // Admin who approved return
                'movement_date' => now(),
            ]);

            DB::commit();
            return redirect()->route('admin.requests.index', ['status' => 'pending_return_approval'])->with('success', 'Item return for request #' . $itemRequest->id . ' approved successfully. Stock updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.requests.index', ['status' => 'pending_return_approval'])->with('error', 'Failed to approve return. An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Deny the return of a previously issued item.
     */
    public function denyReturn(Request $request, ItemRequest $itemRequest)
    {
        if ($itemRequest->status !== 'pending_return_approval') {
            return redirect()->route('admin.requests.index', ['status' => $itemRequest->status])->with('error', 'This request is not pending return approval.');
        }

        $request->validate(['remarks' => 'required|string|max:500'], ['remarks.required' => 'Please provide a reason for denying the return.']);

        $itemRequest->status = 'approved'; // Revert to approved (issued) state
        $itemRequest->processed_by_id = Auth::id();
        $itemRequest->processed_at = now();
        $itemRequest->remarks = $request->input('remarks');
        $itemRequest->save();

        // No stock movement for denying a return, as the item remains with the staff

        return redirect()->route('admin.requests.index', ['status' => 'pending_return_approval'])->with('success', 'Item return for request #' . $itemRequest->id . ' denied. The item remains issued to the staff.');
    }
}
