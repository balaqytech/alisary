<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;

    public ?string $slogan;

    public ?string $logo_path;

    public ?string $email;

    public ?string $phone;

    public ?string $address;

    public ?string $assistant_url;

    public ?string $seo_title;

    public ?string $seo_description;

    public array $social_links;

    public static function group(): string
    {
        return 'general';
    }
}
