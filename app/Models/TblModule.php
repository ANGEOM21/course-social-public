<?php

/**
 * Created by Social Republic Tim Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class TblModule
 * 
 * @property int $id_module
 * @property int $course_id
 * @property string $title
 * @property string|null $description
 * @property string $video_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $slug
 * 
 * @property TblCourse $tbl_course
 *
 * @package App\Models
 */
class TblModule extends Model
{
	protected $table = 'tbl_modules';
	protected $primaryKey = 'id_module';

	protected $casts = [
		'course_id' => 'int'
	];

	protected $fillable = [
		'course_id',
		'title',
		'description',
		'video_url'
	];

	protected static function booted()
	{
		static::saving(function ($m) {
			if (!$m->slug || $m->isDirty('title')) {
				$base = Str::slug($m->title);
				$slug = $base;
				$i = 2;
				while (static::where('slug', $slug)->where('id_module', '!=', $m->id_course)->exists()) {
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

	public function tbl_course()
	{
		return $this->belongsTo(TblCourse::class, 'course_id');
	}
}
