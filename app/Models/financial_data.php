<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class financial_data extends Model
{
    use HasFactory;
    protected $table = 'financial_datas'; // صُحِّح من 'financial_data' ليطابق اسم الجدول في الـ migration

    protected $guarded = [];

    public function orphan()
    {
        return $this->belongsTo(orphans::class, 'orphan_id');
    }


    protected static function newFactory()
    {
        return \Database\Factories\FinancialFactory::new();
    }
}
