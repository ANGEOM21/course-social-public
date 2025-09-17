<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $table = 'tbl_certificate';
    protected $primaryKey = 'id_certificate';

    protected $fillable = [
        'student_certificate',
        'course_certificate',
        'category_certificate',
        'title',
        'file_path',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_certificate', 'id_user');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_certificate', 'id_course');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_certificate', 'id_category');
    }
}
