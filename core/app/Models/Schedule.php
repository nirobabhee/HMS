<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function assistant()
    {
        return $this->belongsTo(Assistant::class);
    }
}
