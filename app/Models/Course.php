<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'tbl_course';
    protected $primaryKey = 'id_course';
    public $timestamps = true;

    protected $fillable = ['name_course', 'desc_course', 'mentor_course', 'category_course'];

    public function category() {
        return $this->belongsTo(Category::class, 'category_course', 'id_category');
    }

    public function mentor() {
        return $this->belongsTo(User::class, 'mentor_course', 'id_user');
    }

    public function progresses() {
        return $this->hasMany(Progress::class, 'course_progress', 'id_course');
    }
}
