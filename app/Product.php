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

    public function getFeaturedImageUrlAttribute()
    {
        $featuredImage = $this->images()->where('featured',true)->first();
        if (!$featuredImage)
            $featuredImage = $this->images()->first();
        if ($featuredImage){
            return $featuredImage->url;
        }

        //Default
        return '/images/products/default.jpg';
    }
}
