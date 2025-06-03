<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\ItemRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [];

        // Get recent item requests for the logged-in user
        $recentRequestsQuery = ItemRequest::with('item')->orderBy('created_at', 'desc');

        if ($user->role === 'admin') {
            $data['totalItems'] = Item::count();
            $data['inStockItems'] = Item::where('quantity', '>', 0)->sum('quantity');
            $data['categoriesCount'] = Category::count();
            // Admin sees all recent requests or filter as needed (e.g., pending)
            $data['recentRequests'] = $recentRequestsQuery->take(5)->get();
            // Admin might also see all borrowed items, or this is handled in a separate admin view
            $data['borrowedItemsByStaff'] = ItemRequest::where('status', 'approved') // Example status for borrowed
                                        ->with(['item', 'user'])
                                        ->orderBy('updated_at', 'desc') // Or movement_date if you add that
                                        ->get(); 

        } else { // Staff user
            // Staff sees their own recent requests
            $data['recentRequests'] = $recentRequestsQuery->where('user_id', $user->id)->take(5)->get();
            
            // Staff sees items they have borrowed - Main table REMOVED, but count is needed for overview
            // Assuming 'approved' or 'issued' status means item is currently borrowed.
            $borrowedItems = ItemRequest::where('user_id', $user->id)
                                       ->whereIn('status', ['approved', 'issued']) // Define statuses that mean "borrowed"
                                       // ->with('item') // Eager load the item details - Not needed if only counting
                                       // ->orderBy('updated_at', 'desc') // Show most recently updated/issued first - Not needed if only counting
                                       ->get();
            // $data['borrowedItems'] = $borrowedItems; // This was for the removed table
            $data['totalBorrowedItemsCount'] = $borrowedItems->sum('requested_quantity'); // Or just count() if 1 request = 1 item borrowed
        }

        return view('dashboard', $data);
    }
}
