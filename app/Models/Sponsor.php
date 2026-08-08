<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $table = 'sponsors';
    protected $guarded = [];


    // العلاقة المباشرة مع جدول الكفالات لحساب الكفالات النشطة بدقة
    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class, 'sponsor_id');
    }

    public function orphans()
    {
        return $this->hasMany(Orphans::class, 'sponsor_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'sponsor_id');
    }
}
