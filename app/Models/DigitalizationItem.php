<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DigitalizationItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'digitalization_items';

    protected $fillable = [
        'entity_id',
        'item_name',
        'category',
        'description',
        'progress_actual',
        'progress_target',
        'status', // 'pending', 'in_progress', 'completed', 'delayed'
        'start_date',
        'target_date',
        'completion_date',
        'notes',
        'assigned_to',
    ];

    protected $casts = [
        'progress_actual' => 'float',
        'progress_target' => 'float',
        'start_date' => 'datetime',
        'target_date' => 'datetime',
        'completion_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the entity that owns this digitalization item
     */
    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    /**
     * Get progress percentage (0-100)
     */
    public function getProgressPercentageAttribute()
    {
        return min(100, max(0, $this->progress_actual));
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'gray',
            'in_progress' => 'blue',
            'completed' => 'green',
            'delayed' => 'red',
        ];
        return $colors[$this->status] ?? 'gray';
    }

    /**
     * Scope to get only completed items
     */
    public function scopeCompleted($query)
    {
        return $query->where('progress_actual', '>=', 100);
    }

    /**
     * Scope to get only in progress items
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope to get delayed items
     */
    public function scopeDelayed($query)
    {
        return $query->where('status', 'delayed');
    }
}
