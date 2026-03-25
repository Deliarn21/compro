<?php

namespace App\Http\Controllers;

use App\Models\DigitalizationTask;
use Illuminate\Http\Request;

class AdminTaskController extends Controller
{
    /**
     * Hanya MIST yang bisa akses - middleware ada di route
     */

    /**
     * Display all master digitalization tasks
     */
    public function index(Request $request)
    {
        $category = $request->query('category');
        
        $query = DigitalizationTask::query();
        
        if ($category) {
            $query->where('category', $category);
        }
        
        $tasks = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = DigitalizationTask::distinct('category')->pluck('category');

        return view('admin.tasks.index', [
            'tasks' => $tasks,
            'categories' => $categories,
            'selectedCategory' => $category,
        ]);
    }

    /**
     * Show form to create new task
     */
    public function create()
    {
        return view('admin.tasks.create');
    }

    /**
     * Store new task
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'estimated_duration' => 'nullable|string',
            'difficulty_level' => 'required|in:easy,medium,hard',
        ]);

        $validated['created_by_user_id'] = auth()->id();

        DigitalizationTask::create($validated);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task digitalisasi berhasil ditambahkan');
    }

    /**
     * Show edit form
     */
    public function edit(DigitalizationTask $task)
    {
        return view('admin.tasks.edit', ['task' => $task]);
    }

    /**
     * Update task
     */
    public function update(Request $request, DigitalizationTask $task)
    {
        $validated = $request->validate([
            'task_name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'estimated_duration' => 'nullable|string',
            'difficulty_level' => 'required|in:easy,medium,hard',
        ]);

        $task->update($validated);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task digitalisasi berhasil diperbarui');
    }

    /**
     * Delete task
     */
    public function destroy(DigitalizationTask $task)
    {
        $task->delete();

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task digitalisasi berhasil dihapus');
    }
}
