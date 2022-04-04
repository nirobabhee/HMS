<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $casts = [
        'date_of_birth' => 'datetime',
        'social_links' => 'object'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function document()
    {
        return $this->hasMany(Doctor::class);
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    /**
     * The assistants that belong to the Doctor.
     */
    public function assistants()
    {
        return $this->belongsToMany(Assistant::class);
    }

}
