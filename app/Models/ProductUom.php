<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductUom extends Model
{
    protected $fillable = ['product_id', 'uom_name', 'conversion_factor', 'price'];
}