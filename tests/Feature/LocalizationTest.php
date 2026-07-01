<?php

use Illuminate\Support\Facades\App;

test('application uses arabic core translation files by default', function () {
    expect(App::getLocale())->toBe('ar')
        ->and(trans('auth.failed'))->toBe('بيانات الاعتماد هذه غير متطابقة مع سجلاتنا.')
        ->and(trans('pagination.next'))->toBe('التالي &raquo;')
        ->and(trans('passwords.sent'))->toBe('تم إرسال رابط إعادة تعيين كلمة المرور إلى بريدك الإلكتروني.')
        ->and(trans('validation.required', ['attribute' => 'البريد الإلكتروني']))->toBe('حقل البريد الإلكتروني مطلوب.');
});
