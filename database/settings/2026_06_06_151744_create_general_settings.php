<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'مجموعة العيسري');
        $this->migrator->add('general.slogan', 'نُعدّهم لحياة طيبة');
        $this->migrator->add('general.logo_path', 'logo.svg');
        $this->migrator->add('general.email', 'info@alisary.com');
        $this->migrator->add('general.phone', null);
        $this->migrator->add('general.address', 'سلطنة عُمان');
        $this->migrator->add('general.assistant_url', 'https://assistant.alisary.com');
        $this->migrator->add('general.seo_title', 'مجموعة العيسري - نُعدّهم لحياة طيبة');
        $this->migrator->add('general.seo_description', 'مجموعة العيسري القابضة العُمانية: نخدم الأطفال ومن يخدم الأطفال، من لحظة الميلاد، وفق خماسية السكينة.');
        $this->migrator->add('general.social_links', []);
    }
};
