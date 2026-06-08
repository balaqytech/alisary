<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->update('homepage.hero', function (mixed $hero): array {
            $hero = json_decode(json_encode($hero, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);

            $hero['slides'] = collect($hero['slides'] ?? [])
                ->map(function (array $slide): array {
                    $slide['subtitle'] ??= null;
                    $slide['cta_label'] ??= null;
                    $slide['cta_url'] ??= null;

                    return $slide;
                })
                ->all();

            return $hero;
        });
    }
};
