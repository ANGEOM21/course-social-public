<?php

/**
 * Created by Social Republic Tim Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TblCategory
 * 
 * @property int $id_category
 * @property string $name_category
 * @property string|null $img_category
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|TblCourse[] $tbl_courses
 *
 * @package App\Models
 */
class TblCategory extends Model
{
	protected $table = 'tbl_categories';
	protected $primaryKey = 'id_category';

	protected $fillable = [
		'name_category',
		'img_category'
	];

	public function tbl_courses()
	{
		return $this->hasMany(TblCourse::class, 'category_id');
	}
}
