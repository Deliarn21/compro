<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DigitalizationTask extends Model
{
    use SoftDeletes;

    protected $table = 'digitalization_tasks';

    protected $fillable = [
        'task_name',
        'category',
        'description',
        'estimated_duration',
        'difficulty_level',
        'created_by_user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Entities that have selected this task
     */
    public function entities()
    {
        return $this->belongsToMany(Entity::class, 'entity_digitalization_tasks')
            ->withPivot('progress_actual', 'progress_target', 'status', 'start_date', 'target_date', 'completion_date', 'assigned_to', 'notes')
            ->withTimestamps();
    }

    /**
     * Creator user
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}
