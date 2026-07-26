<x-mail::message>
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" dir="rtl" style="direction:rtl;text-align:right;margin:0 0 24px;background:#071815;border-radius:8px;overflow:hidden;">
<tr>
<td style="padding:28px 30px;border-bottom:3px solid #B88A3C;">
<div style="font-size:13px;font-weight:700;color:#D4AA61;">تنبيه — لا يمنع الإرسال</div>
<div style="margin-top:10px;font-family:Georgia,Tahoma,serif;font-size:30px;line-height:1.45;font-weight:700;color:#FFFAF2;">تقديم مكرر محتمل</div>
<div style="margin-top:12px;font-size:15px;line-height:1.9;color:#EADFCEDD;">تطابق البريد الإلكتروني أو رقم الهاتف مع طلب سابق لنفس المتقدّم: {{ $application->full_name }}.</div>
</td>
</tr>
</table>

<table role="presentation" width="100%" cellspacing="0" cellpadding="0" dir="rtl" style="direction:rtl;text-align:right;margin:0 0 22px;background:#FFFAF2;border:1px solid #EADFCE;border-radius:8px;">
<tr>
<td style="padding:22px 24px;">
<div style="margin-bottom:16px;font-size:13px;font-weight:700;color:#9C6842;">الطلب الجديد ({{ $application->reference_number }})</div>
<table role="presentation" width="100%" cellspacing="0" cellpadding="0">
<tr>
<td style="padding:10px 0;border-bottom:1px solid #EADFCE;color:#756553;width:34%;">البريد الإلكتروني</td>
<td style="padding:10px 0;border-bottom:1px solid #EADFCE;color:#201812;">{{ $application->email }}</td>
</tr>
<tr>
<td style="padding:10px 0;border-bottom:1px solid #EADFCE;color:#756553;">الهاتف</td>
<td style="padding:10px 0;border-bottom:1px solid #EADFCE;color:#201812;" dir="ltr">{{ $application->phone_country_code }} {{ $application->phone }}</td>
</tr>
<tr>
<td style="padding:10px 0;color:#756553;">وقت التقديم</td>
<td style="padding:10px 0;color:#201812;">{{ $application->created_at?->format('Y-m-d H:i') ?? now()->format('Y-m-d H:i') }}</td>
</tr>
</table>
</td>
</tr>
</table>

<table role="presentation" width="100%" cellspacing="0" cellpadding="0" dir="rtl" style="direction:rtl;text-align:right;margin:0 0 24px;background:#F8F2E8;border-right:4px solid #B88A3C;border-radius:6px;">
<tr>
<td style="padding:16px 18px;color:#756553;line-height:1.9;">الطلب الجديد لم يُحظر تلقائيًا؛ يُرجى مراجعة الطلبين يدويًا لتحديد ما إذا كانا لنفس الشخص.</td>
</tr>
</table>

<x-mail::button :url="$newApplicationUrl" color="success">
فتح الطلب الجديد
</x-mail::button>

<div style="margin-top:14px;">
<x-mail::button :url="$previousApplicationUrl" color="primary">
فتح الطلب السابق ({{ $duplicateOf->reference_number }})
</x-mail::button>
</div>

<div style="margin-top:26px;color:#756553;line-height:1.9;text-align:right;direction:rtl;">
مع التحية،<br>
{{ config('app.name') }}
</div>
</x-mail::message>
