<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->update('homepage.waqf', function (array|object $waqf): array {
            $waqf = (array) $waqf;
            $waqf['image_path'] ??= null;

            return $waqf;
        });
    }
};
