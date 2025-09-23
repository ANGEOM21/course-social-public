<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'tbl_category';
    protected $primaryKey = 'id_category';
    public $timestamps = true;

    // Hanya simpan nama kategori
    protected $fillable = ['name_category'];

    // === RELATIONS ===
    public function courses()
    {
        return $this->hasMany(Course::class, 'category_course', 'id_category');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'category_certificate', 'id_category');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'category_feedback', 'id_category');
    }
}
