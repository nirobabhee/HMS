<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    use HasFactory;
    protected $casts = [
        'case_studies'           => 'object',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
