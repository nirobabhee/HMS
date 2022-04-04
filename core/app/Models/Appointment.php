<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class)->where('status',1);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function scopeActiveAppointment(){
        return $this->where('status', 1);
    }
    public function scopePendingAppointment(){
        return $this->where('status', 0);
    }
}
