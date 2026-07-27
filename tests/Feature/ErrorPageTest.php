<?php

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;

it('renders branded pages for common HTTP errors', function (int $status, string $expectedText) {
    config(['app.debug' => false]);
    Route::get("/__testing/error/{$status}", fn () => abort($status));

    $this->get("/__testing/error/{$status}")
        ->assertStatus($status)
        ->assertSee('data-error-page', false)
        ->assertSee((string) $status)
        ->assertSee($expectedText);
})->with([
    'unauthorized' => [401, 'يلزم تسجيل الدخول'],
    'forbidden' => [403, 'لا تملك صلاحية الوصول'],
    'not found' => [404, 'الصفحة التي تبحث عنها غير موجودة'],
    'expired session' => [419, 'انتهت صلاحية الجلسة'],
    'too many requests' => [429, 'طلبات كثيرة خلال وقت قصير'],
    'server error' => [500, 'حدث خطأ غير متوقع'],
]);

it('renders the requested maintenance message on the 503 page', function () {
    config(['app.debug' => false]);
    Route::get('/__testing/error/503', fn () => abort(503));

    $this->get('/__testing/error/503')
        ->assertServiceUnavailable()
        ->assertSee('😍نخبئ لكم تحديثات ستبهج قلوبكم')
        ->assertSee('الموقع تحت التحديث مؤقتا');
});

it('uses a branded fallback for other client errors', function () {
    config(['app.debug' => false]);
    Route::get('/__testing/error/418', fn () => abort(418));

    $this->get('/__testing/error/418')
        ->assertStatus(418)
        ->assertSee('data-error-page', false)
        ->assertSee('تعذّر الوصول إلى الصفحة');
});

it('shows the legal notice only in the local environment', function () {
    $this->app->detectEnvironment(fn (): string => 'local');

    $localMarkup = Blade::render('<x-local-environment-alert />');

    expect($localMarkup)
        ->toContain('data-local-environment-alert')
        ->toContain('🔴 ملاحظة:')
        ->toContain('هذه الصفحة تجريبية لاكتشاف الثغرات والأخطاء فقط')
        ->toContain('وكل ما يرسل إليها ليس له صفة قانونية');
});

it('hides the legal notice outside the local environment', function () {
    $this->app->detectEnvironment(fn (): string => 'production');

    expect(trim(Blade::render('<x-local-environment-alert />')))->toBe('');
});
