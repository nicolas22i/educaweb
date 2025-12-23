<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_image'
    ];

    const DEFAULT_PROFILE_IMAGE = 'images/avatar-placeholder.png'; // Ruta relativa

    public function getProfileImageAttribute($value)
    {
        return asset($value ?: self::DEFAULT_PROFILE_IMAGE);
    }

    protected $hidden = ['password'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function student()
    {
        return $this->hasOne(Student::class);
    }


    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class, 'teacher_id');
    }

    public function teacherChats()
    {
        return $this->hasMany(Chat::class, 'teacher_id');
    }

    public function studentChats()
    {
        return $this->hasMany(Chat::class, 'student_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(ChatMessage::class, 'sender_id');
    }
}
