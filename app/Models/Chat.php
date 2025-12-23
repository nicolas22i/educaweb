<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'teacher_id',
        'student_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    
    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }
    
    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class)->latest();
    }
}