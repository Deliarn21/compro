<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\DigitalizationTask;
use App\Models\TaskActivityLog;
use Illuminate\Http\Request;

class EntityDetailController extends Controller
{
    /**
     * Show entity detail with selected tasks and activities
     */
    public function show(Entity $entity)
    {
        $entity->load('digitalizationTasks');
        
        $selectedTasks = $entity->digitalizationTasks()
            ->orderBy('entity_digitalization_tasks.updated_at', 'desc')
            ->paginate(10);

        // Get all available tasks for selection
        $availableTasks = DigitalizationTask::whereDoesntHave('entities', function ($query) use ($entity) {
            $query->where('entity_id', $entity->id);
        })->get();

        return view('monitoring.entities.detail', [
            'entity' => $entity,
            'selectedTasks' => $selectedTasks,
            'availableTasks' => $availableTasks,
        ]);
    }

    /**
     * Tambah task ke entity
     */
    public function attachTask(Request $request, Entity $entity)
    {
        $validated = $request->validate([
            'digitalization_task_id' => 'required|exists:digitalization_tasks,id',
        ]);

        // Check if already attached
        if ($entity->digitalizationTasks()->where('digitalization_task_id', $validated['digitalization_task_id'])->exists()) {
            return back()->with('info', 'Task sudah dipilih sebelumnya');
        }

        $entity->digitalizationTasks()->attach($validated['digitalization_task_id'], [
            'progress_actual' => 0,
            'progress_target' => 100,
            'status' => 'pending',
        ]);

        // Log activity
        TaskActivityLog::logActivity($entity->id, $validated['digitalization_task_id'], [
            'activity_type' => 'task_added',
            'notes' => 'Task baru ditambahkan ke entitas',
            'progress_after' => 0,
        ]);

        return back()->with('success', 'Task berhasil ditambahkan ke entitas');
    }

    /**
     * Update task progress dan status with proof upload
     */
    public function updateTaskProgress(Request $request, Entity $entity, DigitalizationTask $task)
    {
        $validated = $request->validate([
            'progress_actual' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:pending,in_progress,completed,delayed',
            'assigned_to' => 'nullable|string',
            'notes' => 'nullable|string',
            'proof_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120', // 5MB
        ]);

        // Get current state
        $currentData = $entity->digitalizationTasks()->find($task->id)->pivot;

        // Handle file upload
        $proofFile = null;
        $proofFileOriginal = null;
        if ($request->hasFile('proof_file')) {
            $file = $request->file('proof_file');
            $proofFileOriginal = $file->getClientOriginalName();
            $proofFile = $file->store('proofs/' . $entity->id, 'public');
        }

        // Update task data
        $updateData = [
            'progress_actual' => $validated['progress_actual'],
            'status' => $validated['status'],
            'assigned_to' => $validated['assigned_to'],
            'notes' => $validated['notes'],
            'start_date' => $validated['status'] !== 'pending' ? now() : null,
            'completion_date' => $validated['progress_actual'] >= 100 ? now() : null,
        ];

        $entity->digitalizationTasks()->updateExistingPivot($task->id, $updateData);

        // Log activity
        $logData = [
            'activity_type' => 'progress_update',
            'progress_before' => $currentData->progress_actual,
            'progress_after' => $validated['progress_actual'],
            'status_before' => $currentData->status,
            'status_after' => $validated['status'],
            'notes' => $validated['notes'],
            'proof_file' => $proofFile,
            'proof_file_original' => $proofFileOriginal,
        ];

        TaskActivityLog::logActivity($entity->id, $task->id, $logData);

        return back()->with('success', 'Progress task berhasil diperbarui');
    }

    /**
     * Get activity history untuk task
     */
    public function getTaskHistory(Entity $entity, DigitalizationTask $task)
    {
        $history = TaskActivityLog::where('entity_id', $entity->id)
            ->where('digitalization_task_id', $task->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($history);
    }

    /**
     * Hapus task dari entity
     */
    public function detachTask(Entity $entity, DigitalizationTask $task)
    {
        // Log activity
        TaskActivityLog::logActivity($entity->id, $task->id, [
            'activity_type' => 'task_removed',
            'notes' => 'Task dihapus dari entitas',
        ]);

        $entity->digitalizationTasks()->detach($task->id);

        return back()->with('success', 'Task berhasil dihapus dari entitas');
    }
}
