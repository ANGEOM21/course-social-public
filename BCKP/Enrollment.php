<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $table = 'tbl_enrollment';
    protected $primaryKey = 'id_enrollment';

    protected $fillable = [
        'user_id',
        'course_id',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    // Relasi ke course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id_course');
    }
}
