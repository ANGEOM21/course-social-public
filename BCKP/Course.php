<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'tbl_course';
    protected $primaryKey = 'id_course';
    public $timestamps = true;

    protected $fillable = [
        'name_course',
        'desc_course',
        'mentor_course',
        'category_course',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    // Mentor yang membuat kursus (relasi ke User)
    public function mentor()
    {
    
        return $this->belongsTo(User::class, 'mentor_course', 'id_user');
    
    }


    // Kategori kursus
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_course', 'id_category');
    }

    // Students yang mengikuti kursus
    public function students()
    {
        return $this->belongsToMany(
            User::class,
            'tbl_enrollment',
            'course_id',   // foreign key di tbl_enrollment
            'user_id',     // foreign key di tbl_enrollment
            'id_course',   // primary key di tbl_course
            'id_user'      // primary key di tbl_user
        );
    }

    // Progress
    public function progresses()
    {
        return $this->hasMany(Progress::class, 'course_progress', 'id_course');
    }

    // Feedback
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'course_feedback', 'id_course');
    }

    // Modul dalam kursus
    public function modules()
    {
        return $this->hasMany(Module::class, 'course_module', 'id_course');
    }
}
