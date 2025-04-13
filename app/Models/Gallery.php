<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $table = 'galleries';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function previewFile()
    {
        return $this->hasOne(GalleryImage::class)->where('is_preview', 1);
    }

    public function images()
    {
        return $this->hasMany(GalleryImage::class,);
    }
}
