<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class)->where('status', 1);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class)->where('status', 1);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function attachments()
    {
        return $this->hasMany(DocumentAttachment::class);
    }

}
