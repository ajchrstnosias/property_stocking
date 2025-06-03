<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::with(['category', 'location'])->orderBy('created_at', 'desc')->paginate(10); // Eager load relationships and paginate
        return view('admin.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        return view('admin.items.create', compact('categories', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'serial_number' => 'nullable|string|max:255|unique:items,serial_number',
            'property_number' => 'required|string|max:255|unique:items,property_number',
            'acquisition_date' => 'nullable|date',
            'unit_cost' => 'required|numeric|min:0',
            'status' => 'required|string|in:available,in_use,under_maintenance,disposed,lost,borrowed',
            'remarks' => 'nullable|string',
        ]);

        Item::create($validatedData);

        return redirect()->route('admin.items.index')->with('success', 'Item added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $categories = Category::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        return view('admin.items.edit', compact('item', 'categories', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'serial_number' => 'nullable|string|max:255|unique:items,serial_number,' . $item->id,
            'property_number' => 'required|string|max:255|unique:items,property_number,' . $item->id,
            'acquisition_date' => 'nullable|date',
            'unit_cost' => 'required|numeric|min:0',
            'status' => 'required|string|in:available,in_use,under_maintenance,disposed,lost,borrowed',
            'remarks' => 'nullable|string',
        ]);

        $item->update($validatedData);

        return redirect()->route('admin.items.index')->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        // Consider soft deletes if you have it enabled in your model
        // Or check for related records (e.g., stock movements, item requests) before deleting
        try {
            $item->delete();
            return redirect()->route('admin.items.index')->with('success', 'Item deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle potential foreign key constraint violations
            return redirect()->route('admin.items.index')->with('error', 'Cannot delete item. It might be associated with other records.');
        }
    }
}
