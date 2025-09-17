<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'tbl_user';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'name_user',
        'email_user',
        'img_user',
        'role_user',
        'access_token_user',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'access_token_user',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // === RELATIONS ===

    // Kursus yang diikuti (student)
    public function courses()
    {
        return $this->belongsToMany(
            Course::class,
            'tbl_enrollment',
            'user_id',
            'course_id',
            'id_user',
            'id_course'
        );
    }

    // Kursus yang dibuat (mentor)
    public function createdCourses()
    {
        return $this->hasMany(Course::class, 'mentor_course', 'id_user');
    }

    // Progress belajar
    public function progresses()
    {
        return $this->hasMany(Progress::class, 'student_progress', 'id_user');
    }

    // Sertifikat
    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'student_certificate', 'id_user');
    }

    // Feedback
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'user_feedback', 'id_user');
    }

    // Enrollment detail
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'user_id', 'id_user');
    }
}
