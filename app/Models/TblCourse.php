<?php

/**
 * Created by Social Republic Tim Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class TblCourse
 * 
 * @property int $id_course
 * @property string $name_course
 * @property string|null $desc_course
 * @property int $mentor_id
 * @property int $category_id
 * @property string $showing
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $slug
 * 
 * @property TblCategory $tbl_category
 * @property TblAdmin $tbl_admin
 * @property Collection|TblEnrollment[] $tbl_enrollments
 * @property Collection|TblFeedback[] $tbl_feedbacks
 * @property Collection|TblModule[] $tbl_modules
 * @property Collection|TblProgress[] $tbl_progresses
 *
 * @package App\Models
 */
class TblCourse extends Model
{
	protected $table = 'tbl_courses';
	protected $primaryKey = 'id_course';

	protected $casts = [
		'mentor_id' => 'int',
		'category_id' => 'int'
	];

	protected $fillable = [
		'name_course',
		'desc_course',
		'mentor_id',
		'category_id',
		'slug',
		'showing'
	];

	protected static function booted()
	{
		static::saving(function ($m) {
			if (!$m->slug || $m->isDirty('name_course')) {
				$base = Str::slug($m->name_course);
				$slug = $base;
				$i = 2;
				while (static::where('slug', $slug)->where('id_course', '!=', $m->id_course)->exists()) {
					$slug = "{$base}-{$i}";
					$i++;
				}
				$m->slug = $slug;
			}
		});
	}

	public function getRouteKeyName()
	{
		return 'slug';
	}

	public function tbl_category()
	{
		return $this->belongsTo(TblCategory::class, 'category_id');
	}

	public function tbl_admin()
	{
		return $this->belongsTo(TblAdmin::class, 'mentor_id');
	}

	public function tbl_enrollments()
	{
		return $this->hasMany(TblEnrollment::class, 'course_id');
	}

	public function tbl_feedbacks()
	{
		return $this->hasMany(TblFeedback::class, 'course_id');
	}

	public function tbl_modules()
	{
		return $this->hasMany(TblModule::class, 'course_id');
	}

	public function tbl_progresses()
	{
		return $this->hasMany(TblProgress::class, 'course_id');
	}
}
