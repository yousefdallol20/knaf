<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class documents extends Model
{
    use HasFactory;
    protected $table = 'documents';

    protected $guarded = [];

    public function orphan()
    {
        return $this->belongsTo(orphans::class, 'orphan_id');
    }

    // 1. رابط الملف
    public function getFileUrlAttribute()
    {
        return asset($this->file_path);
    }

    // 2. اسم الملف
    public function getFileNameAttribute()
    {
        return $this->original_name ?? basename($this->file_path);
    }

    // 3. (ذكاء إضافي) جلب الامتداد حتى لو لم يكن محفوظاً في قاعدة البيانات!
    public function getFileExtensionAttribute()
    {
        if (!empty($this->extension)) {
            return $this->extension;
        }
        // قراءة الامتداد من المسار مباشرة للملفات القديمة
        return pathinfo($this->file_path, PATHINFO_EXTENSION) ?: 'file';
    }

    // 4. (ذكاء إضافي) جلب الحجم الحقيقي من السيرفر إذا كان 0 في قاعدة البيانات!
    public function getFileSizeAttribute()
    {
        if (!empty($this->size) && $this->size > 0) {
            return $this->size;
        }
        // الذهاب لمجلد السيرفر وقراءة حجم الملف الحقيقي بالبايت
        $fullPath = public_path($this->file_path);
        if (file_exists($fullPath)) {
            return filesize($fullPath);
        }
        return 0;
    }

    // 5. تحويل الحجم إلى صيغة مقروءة (MB أو KB)
    public function getReadableSizeAttribute()
    {
        $bytes = $this->file_size; // استخدمنا الدالة الذكية أعلاه
        if (!$bytes || $bytes == 0) return '0 bytes';
        if ($bytes >= 1048576) return round($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024) return round($bytes / 1024, 2) . ' KB';
        return $bytes . ' bytes';
    }

    protected static function newFactory()
    {
        return \Database\Factories\DocumentFactory::new();
    }
}
