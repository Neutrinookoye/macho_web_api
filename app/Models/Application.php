<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $table = 'job_applications';
    protected $guarded = [];

    public function opening()
    {
        return $this->belongsTo(Opening::class, 'opening_id');
    }
}
