<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    protected $table = 'parents';

    protected $guarded = [];

    public function orphan()
    {
        return $this->belongsTo(orphans::class, 'orphan_id');
    }
}
