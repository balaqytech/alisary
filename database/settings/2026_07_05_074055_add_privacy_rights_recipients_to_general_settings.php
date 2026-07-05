<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.privacy_rights_recipients', [
            ['email' => 'privacy@alisary.com'],
        ]);
    }
};
