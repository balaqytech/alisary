<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->update('homepage.proof', function (mixed $proof): array {
            $proof = json_decode(json_encode($proof, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);

            $proof['items'] = collect($proof['items'] ?? [])
                ->map(function (array $item): array {
                    $item['image_path'] ??= null;

                    return $item;
                })
                ->all();

            return $proof;
        });
    }
};
