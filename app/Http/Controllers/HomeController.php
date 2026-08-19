<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\orphans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{


    public function knaf()
    {
        $sponsoredCount = orphans::where('status', 'مكفول')->count();
        $citiesCount = orphans::distinct('city')->count('city');

        // جلب 3 أيتام فقط
        $orphans = orphans::whereNotIn('status', ['بانتظار القبول', 'مرفوض', 'مكفول'])
            ->latest()
            ->take(3)
            ->get();
    
        return view('index', compact('sponsoredCount', 'citiesCount', 'orphans'));
    }

    public function orphans(Request $request)
    {
        // 1. بدء الاستعلام واستثناء غير المقبولين
        $query = orphans::query()
            ->where('status', '!=', 'بانتظار القبول')
            ->where('status', '!=', 'مرفوض')
            ->where('status', '!=', 'مكفول');

        // أو إذا كانت الحالات المقبولة محددة بوضوح استخدم whereIn:
        // ->whereIn('status', ['بانتظار الكفالة']);

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
    public function contact()
    {
        return view('contact');
    }

    public function sendContactEmail(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'nullable|string|max:50',
            'type'    => 'required|string',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Mail::to('yousifdallol2021@gmail.com')->send(new ContactMail($data));

        return back()->with('success', 'تم إرسال استفسارك بنجاح، وسنقوم بالرد عليك في أقرب وقت ممكن.');
    }
}
