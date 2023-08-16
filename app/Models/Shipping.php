<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Shipping extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'shippings';

    protected $fillable = [
        'type',
        'delivery_image',

    ];

    public function registerMediaConversions(Media $media = null): void // New 
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(200)
            ->sharpen(10);
    }
}
