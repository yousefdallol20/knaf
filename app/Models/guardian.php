<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class guardian extends Model
{
    protected $table = 'guardians';

    protected $guarded = [];

    // العلاقة التي كان يبحث عنها الكنترولر ولم يجدها
    public function orphans()
    {
        // نربط الوصي بالطفل بناءً على العمود الموجود فعلياً بقاعدة البيانات لديك وهو 'orphan_id'
        return $this->hasMany(orphans::class, 'id', 'orphan_id');
    }

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
