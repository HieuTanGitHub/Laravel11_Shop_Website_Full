<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    public $timestamps = false; //set time to false
    
    protected $fillable = [
        'product_id',
        'attribute_id',
        'price',
        'quantity',
        'image',
        'name'
    ];
    protected $table = 'tbl_product_attribute';

    public function attribute()
    {
        return $this->belongsTo('App\Models\Attribute', 'product_id');
    }
}
