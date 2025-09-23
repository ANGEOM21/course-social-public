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
 * Class TblAdmin
 * 
 * @property int $id_admin
 * @property string $name_admin
 * @property string $email_admin
 * @property string|null $img_admin
 * @property string|null $password_admin
 * @property string|null $access_token_admin
 * @property string $role
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|TblCourse[] $tbl_courses
 *
 * @package App\Models
 */
class TblAdmin extends Authenticatable
{
	use HasFactory, Notifiable;
	protected $table = 'tbl_admins';
	protected $primaryKey = 'id_admin';

	protected $hidden = [
		'password_admin',
		'remember_token'
	];


	protected $fillable = [
		'name_admin',
		'email_admin',
		'img_admin',
		'password_admin',
		'access_token_admin',
		'role',
		'remember_token'
	];

	public function getAuthPassword()
	{
		return $this->password_admin;
	}


	public function tbl_courses()
	{
		return $this->hasMany(TblCourse::class, 'mentor_id');
	}
}
