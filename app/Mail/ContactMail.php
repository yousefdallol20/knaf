<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $phone = !empty($this->data['phone']) ? e($this->data['phone']) : 'غير محدد';
        $messageContent = nl2br(e($this->data['message']));

        $typeLabels = [
            'sponsorship_inquiry' => 'استفسار حول كفالة يتيم جديد',
            'guardian_support'    => 'حقوق ومطالبات أوصياء الأيتام',
            'partnership_request' => 'شراكة وتعاون مؤسسي أو دعم عيني',
            'technical_issue'    => 'مشكلة تقنية داخل اللوحة',
            'other'              => 'استفسار عام',
        ];
        $typeTranslated = $typeLabels[$this->data['type']] ?? e($this->data['type']);

        return $this->subject('رسالة تواصل جديدة: ' . $this->data['subject'])
            ->html("
                <!DOCTYPE html>
                <html lang='ar' dir='rtl'>
                <head>
                    <meta charset='UTF-8'>
                </head>
                <body dir='rtl' style='font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; direction: rtl; text-align: right; color: #333333;'>
                    <div class='email-container' dir='rtl' style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: 1px solid #e1e8e5; direction: rtl; text-align: right;'>

                        <!-- Header -->
                        <div class='email-header' style='background: #1a5e38; color: #ffffff; padding: 25px 30px; text-align: center;'>
                            <h2 style='margin: 0; font-size: 20px; font-weight: 700; color: #ffffff;'>منصة كَنَفْ لكفالة الأيتام</h2>
                            <p style='margin: 6px 0 0; font-size: 13px; opacity: 0.9; color: #ffffff;'>إشعار بورد واستلام رسالة تواصل جديدة</p>
                        </div>

                        <!-- Body -->
                        <div class='email-body' style='padding: 30px; direction: rtl; text-align: right;'>
                            <table class='info-table' dir='rtl' align='right' style='width: 100%; border-collapse: collapse; margin-bottom: 25px; direction: rtl; text-align: right;'>
                                <tr style='border-bottom: 1px solid #f0f4f2;'>
                                    <td style='font-weight: bold; color: #1a5e38; width: 30%; background-color: #f8faf9; border-radius: 6px; padding: 10px 12px; text-align: right; font-size: 14px;'>الاسم الكامل</td>
                                    <td style='padding: 10px 12px; text-align: right; font-size: 14px; color: #333333;'>" . e($this->data['name']) . "</td>
                                </tr>
                                <tr style='border-bottom: 1px solid #f0f4f2;'>
                                    <td style='font-weight: bold; color: #1a5e38; width: 30%; background-color: #f8faf9; border-radius: 6px; padding: 10px 12px; text-align: right; font-size: 14px;'>البريد الإلكتروني</td>
                                    <td style='padding: 10px 12px; text-align: right; font-size: 14px;'><a href='mailto:" . e($this->data['email']) . "' style='color: #1a5e38; text-decoration: none;'>" . e($this->data['email']) . "</a></td>
                                </tr>
                                <tr style='border-bottom: 1px solid #f0f4f2;'>
                                    <td style='font-weight: bold; color: #1a5e38; width: 30%; background-color: #f8faf9; border-radius: 6px; padding: 10px 12px; text-align: right; font-size: 14px;'>رقم الجوال</td>
                                    <td style='padding: 10px 12px; text-align: right; font-size: 14px; color: #333333;'><span dir='ltr'>" . $phone . "</span></td>
                                </tr>
                                <tr style='border-bottom: 1px solid #f0f4f2;'>
                                    <td style='font-weight: bold; color: #1a5e38; width: 30%; background-color: #f8faf9; border-radius: 6px; padding: 10px 12px; text-align: right; font-size: 14px;'>القسم المعني</td>
                                    <td style='padding: 10px 12px; text-align: right; font-size: 14px; color: #333333;'>" . $typeTranslated . "</td>
                                </tr>
                                <tr style='border-bottom: 1px solid #f0f4f2;'>
                                    <td style='font-weight: bold; color: #1a5e38; width: 30%; background-color: #f8faf9; border-radius: 6px; padding: 10px 12px; text-align: right; font-size: 14px;'>الموضوع</td>
                                    <td style='padding: 10px 12px; text-align: right; font-size: 14px; color: #333333;'><strong>" . e($this->data['subject']) . "</strong></td>
                                </tr>
                            </table>

                            <div style='font-weight: bold; color: #1a5e38; font-size: 14px; margin-bottom: 8px; text-align: right;'>تفاصيل الرسالة والاستفسار:</div>
                            <div style='background-color: #f8faf9; border-right: 4px solid #1a5e38; padding: 15px 18px; border-radius: 6px; font-size: 14px; line-height: 1.7; color: #2d3748; text-align: right; direction: rtl;'>
                                {$messageContent}
                            </div>
                        </div>

                        <!-- Footer -->
                        <div style='background-color: #f8faf9; text-align: center; padding: 15px; font-size: 12px; color: #718096; border-top: 1px solid #e1e8e5;'>
                            جميع الحقوق محفوظة © لمنصة كنف 2026. تم إرسال هذه الرسالة تلقائياً من نموذج اتصل بنا.
                        </div>
                    </div>
                </body>
                </html>
            ");
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
