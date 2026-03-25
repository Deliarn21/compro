<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\DigitalizationItem;
use Illuminate\Http\Request;

class DigitalizationItemController extends Controller
{
    /**
     * Display a listing of digitalization items
     */
    public function index(Request $request)
    {
        $query = DigitalizationItem::with('entity');

        if ($request->filled('entity_id')) {
            $query->where('entity_id', $request->query('entity_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        $items = $query->orderBy('created_at', 'desc')->paginate(15);

        $entities = Entity::orderBy('name')->get();
        $categories = DigitalizationItem::distinct('category')->pluck('category');

        return response()->json([
            'items' => $items,
            'entities' => $entities,
            'categories' => $categories,
            'filters' => [
                'entity_id' => $request->query('entity_id'),
                'status' => $request->query('status'),
                'category' => $request->query('category'),
            ],
        ]);
    }

    /**
     * Store a newly created digitalization item
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'entity_id' => 'required|exists:entities,id',
            'item_name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'progress_actual' => 'required|numeric|min:0',
            'progress_target' => 'required|numeric|min:0',
            'status' => 'required|in:pending,in_progress,completed,delayed',
            'start_date' => 'nullable|date',
            'target_date' => 'nullable|date',
            'completion_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'assigned_to' => 'nullable|string|max:255',
        ]);

        DigitalizationItem::create($validated);

        return redirect()->route('items.index')->with('success', 'Item berhasil ditambahkan.');
    }

    /**
     * Update the specified item
     */
    public function update(Request $request, DigitalizationItem $item)
    {
        $validated = $request->validate([
            'entity_id' => 'required|exists:entities,id',
            'item_name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'progress_actual' => 'required|numeric|min:0',
            'progress_target' => 'required|numeric|min:0',
            'status' => 'required|in:pending,in_progress,completed,delayed',
            'start_date' => 'nullable|date',
            'target_date' => 'nullable|date',
            'completion_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'assigned_to' => 'nullable|string|max:255',
        ]);

        $item->update($validated);

        return redirect()->route('items.index')->with('success', 'Item berhasil diperbarui.');
    }

    /**
     * Delete the specified item
     */
    public function destroy(DigitalizationItem $item)
    {
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item berhasil dihapus.');
    }

    /**
     * API endpoint for quick progress update
     */
    public function updateProgress(Request $request, DigitalizationItem $item)
    {
        $validated = $request->validate([
            'progress_actual' => 'required|numeric|min:0',
            'status' => 'nullable|in:pending,in_progress,completed,delayed',
        ]);

        $item->update($validated);

        return response()->json(['success' => true, 'item' => $item]);
    }

    /**
     * Get items by entity (for AJAX/API)
     */
    public function getByEntity(Entity $entity)
    {
        $items = $entity->digitalizationItems()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($items);
    }
}
