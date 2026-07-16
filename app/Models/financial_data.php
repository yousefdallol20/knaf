<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class financial_data extends Model
{
    protected $table = 'financial_datas'; // صُحِّح من 'financial_data' ليطابق اسم الجدول في الـ migration

    protected $guarded = [];

    public function orphan()
    {
        return $this->belongsTo(orphans::class, 'orphan_id');
    }
}
