<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'entities';

    protected $fillable = [
        'name',
        'code',
        'type', // 'department' or 'pt' (PT/Entitas)
        'description',
        'contact_person',
        'contact_email',
        'contact_phone',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get all digitalization items for this entity
     */
    public function digitalizationItems()
    {
        return $this->hasMany(DigitalizationItem::class);
    }

    /**
     * Get digitalization tasks selected by this entity
     */
    public function digitalizationTasks()
    {
        return $this->belongsToMany(DigitalizationTask::class, 'entity_digitalization_tasks')
            ->withPivot('progress_actual', 'progress_target', 'status', 'start_date', 'target_date', 'completion_date', 'assigned_to', 'notes')
            ->withTimestamps();
    }

    /**
     * Get average progress for this entity (only from selected tasks)
     */
    public function getAverageProgressAttribute()
    {
        $selectedTasksProgress = $this->digitalizationTasks()
            ->avg('entity_digitalization_tasks.progress_actual') ?? 0;
        
        // If no tasks selected, fall back to digitalization items
        if ($selectedTasksProgress == 0 && $this->digitalizationItems()->count() > 0) {
            return $this->digitalizationItems()->avg('progress_actual') ?? 0;
        }
        
        return $selectedTasksProgress;
    }

    /**
     * Get total items for this entity
     */
    public function getTotalItemsAttribute()
    {
        $selectedTasksCount = $this->digitalizationTasks()->count();
        
        // If no tasks selected, show digitalization items count
        if ($selectedTasksCount == 0) {
            return $this->digitalizationItems()->count();
        }
        
        return $selectedTasksCount;
    }

    /**
     * Get completed items count
     */
    public function getCompletedItemsAttribute()
    {
        $completedTasks = $this->digitalizationTasks()
            ->where('entity_digitalization_tasks.progress_actual', '>=', 100)
            ->count();
        
        // If no tasks selected, count from digitalization items
        if ($completedTasks == 0 && $this->digitalizationTasks()->count() == 0) {
            return $this->digitalizationItems()
                ->where('progress_actual', '>=', 100)
                ->count();
        }
        
        return $completedTasks;
    }
}
