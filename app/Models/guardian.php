<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class guardian extends Model
{
    protected $table = 'guardians';

    protected $guarded = [];

    public function orphan()
    {
        return $this->belongsTo(orphans::class, 'orphan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function housing()
    {
        return $this->hasOne(Housing::class, 'guardian_id');
    }
}
