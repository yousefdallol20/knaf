<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class families extends Model
{
    use HasFactory;
    protected $table = 'families';

    protected $guarded = [];

    public function orphans(): HasMany
    {
        return $this->hasMany(orphans::class, 'family_id');
    }
}
