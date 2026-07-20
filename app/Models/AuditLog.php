<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    protected $guarded = [];
    

    // علاقة السجل بالمستخدم الذي نفذ العملية
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
