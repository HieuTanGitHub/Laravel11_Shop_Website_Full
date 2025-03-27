<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Traits\HasRoles;

class Roles extends Model
{
	use HasRoles;
	public $timestamps = false; //set time to false
	protected $fillable = [
		'name'
	];
	protected $primaryKey = 'id	';
	protected $table = 'roles';
}
