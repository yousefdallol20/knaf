<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orphans extends Model
{
    use HasFactory;
    protected $table = 'orphans';

    protected $guarded = [];

    // اليتيم هو الكيان الأب: كل جدول فرعي يحمل orphan_id يشير إليه.
    public function guardian()
    {
        // اليتيم ينتمي لوصي واحد عبر المفتاح الأجنبي guardian_id
        return $this->belongsTo(guardian::class, 'guardian_id');
    }

    public function parents()
    {
        return $this->hasOne(Parents::class, 'orphan_id');
    }

    public function housing()
    {
        return $this->hasOne(Housing::class, 'orphan_id');
    }

    public function financial_data()
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

    protected static function newFactory()
    {
        return \Database\Factories\OrphanFactory::new();
    }
}
