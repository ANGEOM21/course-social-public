<?php

/**
 * Created by Social Republic Tim Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TblCertificate
 * 
 * @property int $id_certificate
 * @property int $student_id
 * @property string $title
 * @property string $file_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TblStudent $tbl_student
 *
 * @package App\Models
 */
class TblCertificate extends Model
{
	protected $table = 'tbl_certificates';
	protected $primaryKey = 'id_certificate';

	protected $casts = [
		'student_id' => 'int'
	];

	protected $fillable = [
		'student_id',
		'title',
		'file_path',
		'course_id'
	];

	public function tbl_student()
	{
		return $this->belongsTo(TblStudent::class, 'student_id');
	}

	public function tbl_course()
	{
		return $this->belongsTo(TblCourse::class, 'course_id');
	}
}
