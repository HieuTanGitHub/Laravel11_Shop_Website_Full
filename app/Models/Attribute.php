<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
        'name',
        'description',
        'status'
    ];
    protected $table = 'tbl_attribute';
}
