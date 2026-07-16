<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orphans extends Model
{
    protected $table = 'orphans';

    protected $guarded = [];

    // اليتيم هو الكيان الأب: كل جدول فرعي يحمل orphan_id يشير إليه.
    public function guardian()
    {
        return $this->hasOne(guardian::class, 'orphan_id');
    }

    public function parents()
    {
        return $this->hasOne(Parents::class, 'orphan_id');
    }

    public function housing()
    {
        return $this->hasOne(Housing::class, 'orphan_id');
    }

    public function financial()
    {
        return $this->hasOne(financial_data::class, 'orphan_id');
    }

    public function documents()
    {
        return $this->hasMany(documents::class, 'orphan_id');
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }

    public function sponsorship()
    {
        return $this->hasOne(sponsorship::class, 'orphan_id');
    }
}
