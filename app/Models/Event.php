<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    //
    use HasFactory;
    protected $table = 'events';
    protected $guarded = [];


    public function images()
    {
        return $this->hasMany(EventImage::class,);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
