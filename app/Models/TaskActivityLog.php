<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskActivityLog extends Model
{
    protected $table = 'task_activity_logs';

    protected $fillable = [
        'entity_id',
        'digitalization_task_id',
        'progress_before',
        'progress_after',
        'status_before',
        'status_after',
        'notes',
        'proof_file',
        'proof_file_original',
        'activity_type',
        'user_name',
        'user_email',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function task()
    {
        return $this->belongsTo(DigitalizationTask::class, 'digitalization_task_id');
    }

    public static function logActivity($entityId, $taskId, $data)
    {
        return self::create([
            'entity_id' => $entityId,
            'digitalization_task_id' => $taskId,
            'progress_before' => $data['progress_before'] ?? null,
            'progress_after' => $data['progress_after'] ?? null,
            'status_before' => $data['status_before'] ?? null,
            'status_after' => $data['status_after'] ?? null,
            'notes' => $data['notes'] ?? null,
            'proof_file' => $data['proof_file'] ?? null,
            'proof_file_original' => $data['proof_file_original'] ?? null,
            'activity_type' => $data['activity_type'] ?? 'progress_update',
            'user_name' => auth()->user()->name ?? 'System',
            'user_email' => auth()->user()->email ?? 'system@app.local',
        ]);
    }
}
