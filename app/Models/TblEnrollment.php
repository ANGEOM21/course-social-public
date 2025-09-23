<?php

/**
 * Created by Social Republic Tim Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TblEnrollment
 * 
 * @property int $id_enrollment
 * @property int $student_id
 * @property int $course_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TblCourse $tbl_course
 * @property TblStudent $tbl_student
 *
 * @package App\Models
 */
class TblEnrollment extends Model
{
	protected $table = 'tbl_enrollments';
	protected $primaryKey = 'id_enrollment';

	protected $casts = [
		'student_id' => 'int',
		'course_id' => 'int'
	];

	protected $fillable = [
		'student_id',
		'course_id'
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
