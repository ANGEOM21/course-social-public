<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'tbl_feedback';
    protected $primaryKey = 'id_feedback';

    protected $fillable = [
        'user_feedback',
        'course_feedback',
        'rating_feedback',
        'comment_feedback',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_feedback', 'id_user');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_feedback', 'id_course');
    }
}
