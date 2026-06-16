<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'nim', 'jurusan', 'semester',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function getTaskStatsAttribute(): array
    {
        return [
            'total'       => $this->tasks()->count(),
            'todo'        => $this->tasks()->where('status', 'todo')->count(),
            'in_progress' => $this->tasks()->where('status', 'in_progress')->count(),
            'done'        => $this->tasks()->where('status', 'done')->count(),
            'overdue'     => $this->tasks()->where('due_date', '<', now())->where('status', '!=', 'done')->count(),
        ];
    }
}
