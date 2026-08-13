<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // بناء الرابط الذي سينقر عليه المستخدم من داخل الإيميل
        $url = route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->email,
        ]);

        return (new MailMessage)
            ->subject('استعادة كلمة المرور - منصة كَنَفْ')
            ->greeting('مرحباً ' . $notifiable->name . ' 👋')
            ->line('لقد تلقينا طلباً لإعادة تعيين كلمة المرور الخاصة بحسابك في منصة كَنَفْ.')
            ->action('إعادة تعيين كلمة المرور', $url)
            ->line('هذا الرابط صالح لمدة 60 دقيقة فقط.')
            ->line('إذا لم تطلب إعادة تعيين كلمة المرور، يمكنك تجاهل هذه الرسالة وأمان حسابك غير متأثر.');
    }
}
