<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class StorySettings extends Settings
{
    public string $eyebrow;

    public string $title;

    public ?string $lead;

    public ?string $image_path;

    public ?string $image_caption;

    public ?string $body;

    public ?string $closing;

    public static function group(): string
    {
        return 'story';
    }
}
