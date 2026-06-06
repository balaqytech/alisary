<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class HomepageSettings extends Settings
{
    public array $hero;

    public array $proof;

    public array $legacy;

    public array $impact;

    public array $waqf;

    public array $doors;

    public array $founder;

    public array $gallery;

    public static function group(): string
    {
        return 'homepage';
    }
}
