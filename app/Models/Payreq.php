<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payreq extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function rab()
    {
        return $this->belongsTo(Rab::class, 'rab_id', 'id');
    }

    public function splits()
    {
        return $this->hasMany(Split::class, 'payreq_id', 'id');
    }
}
