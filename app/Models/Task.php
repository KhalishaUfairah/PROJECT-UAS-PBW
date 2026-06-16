<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'description', 'priority',
        'status', 'due_date', 'due_time', 'mata_kuliah', 'dosen',
        'progress', 'is_pinned',
    ];

    protected $casts = [
        'due_date'  => 'date',
        'is_pinned' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class)->latest();
    }

    public function getPriorityBadgeAttribute(): string
    {
        return match($this->priority) {
            'urgent' => 'badge-urgent',
            'high'   => 'badge-high',
            'medium' => 'badge-medium',
            'low'    => 'badge-low',
            default  => 'badge-medium',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'todo'        => 'Belum Mulai',
            'in_progress' => 'Sedang Dikerjakan',
            'done'        => 'Selesai',
            'cancelled'   => 'Dibatalkan',
            default       => 'Tidak Diketahui',
        };
    }

    public function getPriorityLabelAttribute(): string
    {
        return match($this->priority) {
            'urgent' => 'Urgent',
            'high'   => 'Tinggi',
            'medium' => 'Sedang',
            'low'    => 'Rendah',
            default  => 'Sedang',
        };
    }

    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== 'done';
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())->where('status', '!=', 'done');
    }
}
