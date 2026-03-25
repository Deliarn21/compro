<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    /**
     * Display a listing of entities
     */
    public function index(Request $request)
    {
        $entities = Entity::withCount('digitalizationItems')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($entities);
    }

    /**
     * Store a newly created entity in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:entities,code',
            'type' => 'required|in:department,pt',
            'description' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        $entity = Entity::create($validated);

        return redirect()->route('entities.index')->with('success', 'Entity berhasil dibuat.');
    }

    /**
     * Update the specified entity in storage
     */
    public function update(Request $request, Entity $entity)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:entities,code,' . $entity->id,
            'type' => 'required|in:department,pt',
            'description' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        $entity->update($validated);

        return redirect()->route('entities.index')->with('success', 'Entity berhasil diperbarui.');
    }

    /**
     * Delete the specified entity
     */
    public function destroy(Entity $entity)
    {
        $entity->delete();

        return redirect()->route('entities.index')->with('success', 'Entity berhasil dihapus.');
    }

    /**
     * Restore a soft-deleted entity
     */
    public function restore($id)
    {
        $entity = Entity::onlyTrashed()->find($id);

        if ($entity) {
            $entity->restore();
            return redirect()->route('entities.index')->with('success', 'Entity berhasil dipulihkan.');
        }

        return redirect()->route('entities.index')->with('error', 'Entity tidak ditemukan.');
    }

    /**
     * Show entity details with items
     */
    public function show(Entity $entity)
    {
        $entity->load(['digitalizationItems' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        $entity->loadCount('digitalizationItems');

        return response()->json([
            'entity' => $entity,
            'items' => $entity->digitalizationItems,
        ]);
    }
}
