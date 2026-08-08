<?php

namespace App\Http\Controllers;

use App\Models\orphans;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function orphans(Request $request)
    {
        $query = orphans::query();

        // 1. البحث باسم اليتيم
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 2. الفلترة حسب البلد / الموطن
        if ($request->filled('country') && $request->country !== 'all') {
            $query->where('country', $request->country);
        }

        // 3. الفلترة حسب الجنس
        if ($request->filled('gender') && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }

        $data = $query->latest()->get();

        // إرجاع ملف orphans-list المباشر عند طلب Ajax
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
