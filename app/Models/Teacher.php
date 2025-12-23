<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'teacher_code', 'specialization', 'phone_number', 'address'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->hasOne(Course::class);
    }
    // Solo si el admin necesita acceder a todos los cursos relacionados con un profesor
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function subjects()
{
    return $this->hasMany(Subject::class);
}

    public function resources()
{
    return $this->hasMany(Resource::class, 'teacher_id');
}
    public function chats()
    {
        return $this->hasMany(Chat::class, 'teacher_id');
    }
}
