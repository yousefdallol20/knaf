<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Housing extends Model
{
    protected $table = 'housings';

    protected $guarded = [];

    public function orphan()
    {
        return $this->belongsTo(orphans::class, 'orphan_id');
    }

    public function guardian()
    {
        return $this->belongsTo(Guardian::class, 'guardian_id');
    }
}
