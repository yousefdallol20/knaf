<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    protected $table = 'sponsorships';
    protected $guarded = [];

    public function orphan()
    {
        return $this->belongsTo(orphans::class, 'orphan_id');
    }

    public function sponsor()
    {
        return $this->belongsTo(sponsor::class, 'sponsor_id');
    }

}
