<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'tbl_module';
    protected $primaryKey = 'id_module';

    protected $fillable = [
        'title_module',
        'desc_module',
        'course_module',
        'video_url',
    ];

    // Relasi ke course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_module', 'id_course');
    }

    // Relasi ke progress
    public function progresses()
    {
        return $this->hasMany(Progress::class, 'module_progress', 'id_module');
    }
}
