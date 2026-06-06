<?php

namespace App\Enums;

enum ListingKind: string
{
    case Job = 'job';
    case Tender = 'tender';

    public function label(): string
    {
        return match ($this) {
            self::Job => 'وظيفة',
            self::Tender => 'مناقصة',
        };
    }

    public function routeSegment(): string
    {
        return match ($this) {
            self::Job => 'jobs',
            self::Tender => 'tenders',
        };
    }
}
