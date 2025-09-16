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
    protected $fillable = ['name_user', 'email_user', 'img_user', 'role_user', 'access_token_user'];

    public function courses() {
        return $this->hasMany(Course::class, 'mentor_course', 'id_user');
    }

    public function progresses() {
        return $this->hasMany(Progress::class, 'student_progress', 'id_user');
    }

    public function certificates() {
        return $this->hasMany(Certificate::class, 'student_certificate', 'id_user');
    }

    public function feedbacks() {
        return $this->hasMany(Feedback::class, 'user_feedback', 'id_user');
    }
}
