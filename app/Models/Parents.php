<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // تأكد من الاستدعاء

class Parents extends Model
{
    use HasFactory;
    protected $table = 'parents';

    protected $guarded = [];

    public function orphan()
    {
        return $this->belongsTo(orphans::class, 'orphan_id');
    }

    protected static function newFactory()
    {
        return \Database\Factories\ParentFactory::new();
    }
}
