<?php

/**
 * Created by Social Republic Tim Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TblProgress
 * 
 * @property int $id_progress
 * @property int $course_id
 * @property int $student_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TblCourse $tbl_course
 * @property TblStudent $tbl_student
 *
 * @package App\Models
 */
class TblProgress extends Model
{
	protected $table = 'tbl_progress';
	protected $primaryKey = 'id_progress';

	protected $casts = [
		'course_id' => 'int',
		'student_id' => 'int'
	];

	protected $fillable = [
		'course_id',
		'student_id'
	];

	public function tbl_course()
	{
		return $this->belongsTo(TblCourse::class, 'course_id');
	}

	public function tbl_student()
	{
		return $this->belongsTo(TblStudent::class, 'student_id');
	}
}
