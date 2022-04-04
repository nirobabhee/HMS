<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assistant extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    /**
     * The doctors that belong to the Assistant.
     */
    public function doctors()
    {
        return $this->belongsToMany(Doctor::class);
    }
}
