<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table = 'locations';
    protected $guarded = [];

    public function projects()
    {
        return $this->hasMany(Project::class, 'location_id');
    }
}
