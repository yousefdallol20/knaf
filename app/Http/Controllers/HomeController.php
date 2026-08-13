<?php

namespace App\Http\Controllers;

use App\Models\orphans;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function orphans(Request $request)
    {
        // 1. بدء الاستعلام واستثناء غير المقبولين
        $query = orphans::query()
            ->where('status', '!=', 'بانتظار القبول')
            ->where('status', '!=', 'مرفوض');

        // أو إذا كانت الحالات المقبولة محددة بوضوح استخدم whereIn:
        // ->whereIn('status', ['بانتظار الكفالة', 'مكفول']);

        // 2. البحث باسم اليتيم
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 3. فلترة الدولة
        if ($request->filled('country') && $request->country !== 'all') {
            $query->where('country', $request->country);
        }

        // 4. فلترة الجنس
        if ($request->filled('gender') && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }

        $data = $query->get(); // أو paginate(12)

        // إذا كان الطلب AJAX (عند البحث والتصفية)
        if ($request->ajax()) {
            return view('orphans-list', compact('data'))->render();
        }

        return view('orphans', compact('data'));
    }

    public function orphans_details(string $id)
    {
        $orphan = orphans::findOrFail($id);
        return view('orphan-profile', compact('orphan'));
    }
}
