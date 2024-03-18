<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opening extends Model
{
    use HasFactory;
    protected $table = 'job_openings';
    protected $guarded = [];

    public function applications()
    {
        return $this->hasMany(Application::class, 'opening_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
