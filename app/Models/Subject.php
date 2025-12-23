<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'name', 'description'];


    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    
    public function teacher()
    {
        return $this->through('course')->has('teacher');
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_subject')->withPivot('id', 'grade_id', 'attendance_id');
    }
    public function resources()
    {
        return $this->hasMany(\App\Models\Resource::class);
    }
}
