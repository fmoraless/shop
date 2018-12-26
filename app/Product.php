<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //$product->category
    function category() {
        return $this->belongsTo(Category::class);
    }
    
    //$product->images
    function images() {
        return $this->hasMany(ProductImage::class);
    }
}
