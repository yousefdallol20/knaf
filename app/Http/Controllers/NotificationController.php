<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\BroadcastAnnouncement;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB; // تم تعديل مسار الـ DB هنا بشكل صحيح
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // عرض صفحة الإدارة وسجل الإشعارات المرسلة
    public function adminIndex()
    {
        // جلب آخر الإشعارات المرسلة المخزنة في النظام للعرض في السجل
        $broadcasts = DB::table('notifications')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($item) {
                return [
                    'data' => json_decode($item->data, true),
                    'created_at' => $item->created_at,
                    'notifiable_type' => $item->notifiable_type
                ];
            });

        return view('admin.notifications', compact('broadcasts'));
    }

    // إرسال الإشعار الجماعي من الأدمن
    public function sendBroadcast(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'user_type' => 'required|string',
            'type' => 'required|string',
            'body' => 'required|string',
        ]);

        // تحديد الفئة المستهدفة بناءً على الخيار
        $users = User::where('role', $request->user_type)->get();

        // إرسال الإشعار لجميع المستخدمين المستهدفين دفعة واحدة
        Notification::send($users, new BroadcastAnnouncement($request->title, $request->type, $request->body));

        return redirect()->back()->with('success', 'تم إطلاق التنبيه بنجاح في البوابة كافة!');
    }

    // عرض صفحة الإشعارات للكافل
    public function sponsorIndex()
    {
        /** @var User $user */
        $user = Auth::user();

        // جلب إشعارات الكافل
        $notifications = $user->notifications()->paginate(10);

        return view('sponsor.notifications', compact('user', 'notifications'));
    }
    // تحديد كل الإشعارات كمقروءة للكافل
    public function markAllRead()
    {
        /** @var User $user */
        $user = Auth::user();

        $user->unreadNotifications->markAsRead();

        return response()->json(['status' => 'success']);
    }
}
