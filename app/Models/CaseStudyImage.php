<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseStudyImage extends Model
{
    use HasFactory;
    protected $table = 'case_study_images';
    protected $guarded = [];

    public function casestudy()
    {
        return $this->belongsTo(CaseStudy::class, 'casestudy_id');
    }
}
