<x-mail::message>
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" dir="rtl" style="direction:rtl;text-align:right;margin:0 0 24px;background:#071815;border-radius:8px;overflow:hidden;">
<tr>
<td style="padding:28px 30px;border-bottom:3px solid #B88A3C;">
<div style="font-size:13px;font-weight:700;color:#D4AA61;">إشعار خصوصية جديد</div>
<div style="margin-top:10px;font-family:Georgia,Tahoma,serif;font-size:30px;line-height:1.45;font-weight:700;color:#FFFAF2;">طلب ممارسة حق بيانات شخصية</div>
<div style="margin-top:12px;font-size:15px;line-height:1.9;color:#EADFCEDD;">تم استلام طلب جديد برقم: {{ $rightsRequest->reference_number }}.</div>
</td>
</tr>
</table>

<table role="presentation" width="100%" cellspacing="0" cellpadding="0" dir="rtl" style="direction:rtl;text-align:right;margin:0 0 22px;background:#FFFAF2;border:1px solid #EADFCE;border-radius:8px;">
<tr>
<td style="padding:22px 24px;">
<div style="margin-bottom:16px;font-size:13px;font-weight:700;color:#9C6842;">بيانات الطلب</div>
<table role="presentation" width="100%" cellspacing="0" cellpadding="0">
<tr>
<td style="padding:10px 0;border-bottom:1px solid #EADFCE;color:#756553;width:34%;">نوع الطلب</td>
<td style="padding:10px 0;border-bottom:1px solid #EADFCE;color:#201812;font-weight:700;">{{ $rightsRequest->request_type }}</td>
</tr>
<tr>
<td style="padding:10px 0;border-bottom:1px solid #EADFCE;color:#756553;">البريد الإلكتروني</td>
<td style="padding:10px 0;border-bottom:1px solid #EADFCE;color:#201812;">{{ $rightsRequest->email }}</td>
</tr>
<tr>
<td style="padding:10px 0;border-bottom:1px solid #EADFCE;color:#756553;">وقت الإرسال</td>
<td style="padding:10px 0;border-bottom:1px solid #EADFCE;color:#201812;">{{ $rightsRequest->created_at?->format('Y-m-d H:i') ?? now()->format('Y-m-d H:i') }}</td>
</tr>
<tr>
<td style="padding:10px 0;color:#756553;">التفاصيل</td>
<td style="padding:10px 0;color:#201812;line-height:1.9;">{{ $rightsRequest->details ?: 'لا توجد تفاصيل إضافية.' }}</td>
</tr>
</table>
</td>
</tr>
</table>

<x-mail::button :url="$adminUrl" color="success">
فتح الطلب
</x-mail::button>

<div style="margin-top:26px;color:#756553;line-height:1.9;text-align:right;direction:rtl;">
مع التحية،<br>
{{ config('app.name') }}
</div>
</x-mail::message>
