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
                    $slide['mobile_image_path'] ??= $slide['image_path'] ?? null;

                    return $slide;
                })
                ->all();

            return $hero;
        });
    }
};
