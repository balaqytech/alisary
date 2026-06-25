<x-mail::message>
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" dir="rtl" style="direction:rtl;text-align:right;margin:0 0 24px;background:#071815;border-radius:8px;overflow:hidden;">
<tr>
<td style="padding:28px 30px;border-bottom:3px solid #B88A3C;">
<div style="font-size:13px;font-weight:700;color:#D4AA61;">إشعار تقديم جديد</div>
<div style="margin-top:10px;font-family:Georgia,Tahoma,serif;font-size:30px;line-height:1.45;font-weight:700;color:#FFFAF2;">طلب تقديم على مناقصة</div>
<div style="margin-top:12px;font-size:15px;line-height:1.9;color:#EADFCEDD;">تم استلام طلب تقديم جديد على مناقصة: {{ $tenderListing->title }}.</div>
</td>
</tr>
</table>

<table role="presentation" width="100%" cellspacing="0" cellpadding="0" dir="rtl" style="direction:rtl;text-align:right;margin:0 0 22px;background:#FFFAF2;border:1px solid #EADFCE;border-radius:8px;">
<tr>
<td style="padding:22px 24px;">
<div style="margin-bottom:16px;font-size:13px;font-weight:700;color:#9C6842;">بيانات الطلب</div>
<table role="presentation" width="100%" cellspacing="0" cellpadding="0">
<tr>
<td style="padding:10px 0;border-bottom:1px solid #EADFCE;color:#756553;width:34%;">الجهة</td>
<td style="padding:10px 0;border-bottom:1px solid #EADFCE;color:#201812;font-weight:700;">{{ $tenderListing->contractor?->name ?? 'غير محدد' }}</td>
</tr>
<tr>
<td style="padding:10px 0;border-bottom:1px solid #EADFCE;color:#756553;">اسم مقدم الطلب</td>
<td style="padding:10px 0;border-bottom:1px solid #EADFCE;color:#201812;font-weight:700;">{{ $submission->full_name }}</td>
</tr>
<tr>
<td style="padding:10px 0;border-bottom:1px solid #EADFCE;color:#756553;">البريد الإلكتروني</td>
<td style="padding:10px 0;border-bottom:1px solid #EADFCE;color:#201812;">{{ $submission->email }}</td>
</tr>
<tr>
<td style="padding:10px 0;border-bottom:1px solid #EADFCE;color:#756553;">الهاتف</td>
<td style="padding:10px 0;border-bottom:1px solid #EADFCE;color:#201812;">{{ $submission->phone }}</td>
</tr>
<tr>
<td style="padding:10px 0;color:#756553;">وقت التقديم</td>
<td style="padding:10px 0;color:#201812;">{{ $submission->created_at?->format('Y-m-d H:i') ?? now()->format('Y-m-d H:i') }}</td>
</tr>
</table>
</td>
</tr>
</table>

<table role="presentation" width="100%" cellspacing="0" cellpadding="0" dir="rtl" style="direction:rtl;text-align:right;margin:0 0 24px;background:#F8F2E8;border-right:4px solid #B88A3C;border-radius:6px;">
<tr>
<td style="padding:16px 18px;color:#756553;line-height:1.9;">لا يتضمن هذا البريد الملفات المرفوعة. يمكن مراجعة سجل الطلب الكامل من لوحة التحكم.</td>
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
