<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['subject_id', 'teacher_id', 'title', 'description', 'deadline'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }

    public function resources()
    {
        return $this->belongsToMany(Resource::class);
    }

    public function attachedResources()
    {
        return $this->belongsToMany(Resource::class, 'resource_task');
    }

    
}
