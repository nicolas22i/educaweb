<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'student_code',
        'date_of_birth',
        'phone_number',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }


    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function taskSubmissions()
    {
        return $this->hasMany(TaskSubmission::class, 'student_id');
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'student_id');
    }
}
