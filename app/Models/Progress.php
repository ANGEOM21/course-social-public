<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $table = 'tbl_progress';
    protected $primaryKey = 'id_progress';
    public $timestamps = true;

    protected $fillable = ['student_progress', 'course_progress', 'status_progress'];

    public function student() {
        return $this->belongsTo(User::class, 'student_progress', 'id_user');
    }

    public function course() {
        return $this->belongsTo(Course::class, 'course_progress', 'id_course');
    }
}
