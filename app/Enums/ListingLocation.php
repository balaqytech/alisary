<?php

namespace App\Enums;

enum ListingLocation: string
{
    case Remote = 'remote';
    case Muscat = 'muscat';
    case Salalah = 'salalah';
    case Sohar = 'sohar';
    case Nizwa = 'nizwa';
    case Sur = 'sur';
    case Ibri = 'ibri';
    case Buraimi = 'buraimi';
    case Rustaq = 'rustaq';
    case Khasab = 'khasab';
    case Duqm = 'duqm';
    case Ibra = 'ibra';

    public function label(): string
    {
        return match ($this) {
            self::Remote => 'عن بعد',
            self::Muscat => 'مسقط',
            self::Salalah => 'صلالة',
            self::Sohar => 'صحار',
            self::Nizwa => 'نزوى',
            self::Sur => 'صور',
            self::Ibri => 'عبري',
            self::Buraimi => 'البريمي',
            self::Rustaq => 'الرستاق',
            self::Khasab => 'خصب',
            self::Duqm => 'الدقم',
            self::Ibra => 'إبراء',
        };
    }
}
