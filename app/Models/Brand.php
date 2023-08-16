<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// New 
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
// New 

class Brand extends Model  implements HasMedia // New 
{
    use HasFactory;
    use InteractsWithMedia; // New 


    protected $table = 'brands';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',

    ];


    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }

    public function registerMediaConversions(Media $media = null): void // New 
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(200)
            ->sharpen(10);
    }
}
