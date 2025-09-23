<?php

/**
 * Created by Social Republic Tim Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class TblStudent
 * 
 * @property int $id_student
 * @property string $name_student
 * @property string $email_student
 * @property string|null $img_student
 * @property string|null $password_student
 * @property string|null $access_token_student
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|TblCertificate[] $tbl_certificates
 * @property Collection|TblEnrollment[] $tbl_enrollments
 * @property Collection|TblFeedback[] $tbl_feedbacks
 * @property Collection|TblProgress[] $tbl_progresses
 *
 * @package App\Models
 */
class TblStudent extends Authenticatable
{

	use HasFactory, Notifiable;
	protected $table = 'tbl_students';
	protected $primaryKey = 'id_student';

	protected $hidden = [
		'remember_token',
		'password_student'
	];

	protected $fillable = [
		'name_student',
		'email_student',
		'img_student',
		'password_student',
		'access_token_student',
		'remember_token'
	];

	public function getAuthPassword()
	{
		return $this->password_student;
	}

	
	public function tbl_certificates()
	{
		return $this->hasMany(TblCertificate::class, 'student_id');
	}

	public function tbl_enrollments()
	{
		return $this->hasMany(TblEnrollment::class, 'student_id');
	}

	public function tbl_feedbacks()
	{
		return $this->hasMany(TblFeedback::class, 'student_id');
	}

	public function tbl_progresses()
	{
		return $this->hasMany(TblProgress::class, 'student_id');
	}
}
