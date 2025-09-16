<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'tbl_feedback';
    protected $primaryKey = 'id_feedback';
    public $timestamps = true;

    protected $fillable = ['user_feedback', 'category_feedback', 'comment_feedback'];

    public function user() {
        return $this->belongsTo(User::class, 'user_feedback', 'id_user');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_feedback', 'id_category');
    }
}
