<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Sponsorship extends Model
{
    use Notifiable;
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
