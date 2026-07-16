<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $table = 'sponsors';
    protected $guarded = [];



    public function orphans()
    {
        return $this->hasMany(Orphans::class, 'sponsor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
