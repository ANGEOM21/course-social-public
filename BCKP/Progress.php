<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $table = 'tbl_progress';
    protected $primaryKey = 'id_progress';

    protected $fillable = [
        'student_progress',
        'course_progress',
        'module_progress',
        'status_progress',
    ];

    // Relasi ke student
    public function student()
    {
        return $this->belongsTo(User::class, 'student_progress', 'id_user');
    }

    // Relasi ke course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_progress', 'id_course');
    }

    // Relasi ke module
    public function module()
    {
        return $this->belongsTo(Module::class, 'module_progress', 'id_module');
    }
}
