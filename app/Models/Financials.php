<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Financials extends Model
{
    protected $table = 'financial_datas_sponsor'; // صُحِّح من 'financial_data' ليطابق اسم الجدول في الـ migration

    protected $guarded = [];

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }
}
