<?php

namespace App\Http\Controllers;

use App\Models\orphans;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function orphans()
    {
        $data = orphans::all();

        return view('orphans', ['data' => $data]);
    }

    public function orphans_details(string $id)
    {
        // جلب بيانات اليتيم المطلوب بناءً على الـ id، وإذا لم يجده يعطي خطأ 404
        $orphan = orphans::findOrFail($id);

        // توجيه البيانات إلى الفيو الخاص بملف اليتيم التفصيلي
        return view('orphan-profile', ['orphan' => $orphan]);
    }
}
