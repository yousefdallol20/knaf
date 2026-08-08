<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class guardian extends Model
{
    use HasFactory;
    protected $table = 'guardians';

    protected $guarded = [];

    // العلاقة التي كان يبحث عنها الكنترولر ولم يجدها
    public function orphan()
    {
        return $this->belongsTo(orphans::class, 'orphan_id');
    }

   public function orphans()
{
    // المفتاح الأجنبي في جدول orphans هو guardian_id والمفتاح المحلي في guardians هو id
    return $this->hasMany(orphans::class, 'guardian_id', 'id');
}
    public function user()
    {
        // الربط الصحيح عبر عمود user_id الموجود في جدول guardians
        return $this->belongsTo(User::class, 'user_id');
    }

    public function housing()
    {
        return $this->hasOne(Housing::class, 'guardian_id');
    }
}
