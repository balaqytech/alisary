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
    case Khairat = 'khairat';
    case Mawaleh = 'mawaleh';
    case Amarat = 'amarat';
    case MabailaSouth = 'mabaila_south';
    case Barka = 'barka';
    case Yanqul = 'yanqul';
    case Bahla = 'bahla';
    case Suwaiq = 'suwaiq';
    case Bidbid = 'bidbid';
    case Bawshar = 'bawshar';
    case Udhaibah = 'udhaibah';
    case MabailaEighth = 'mabaila_eighth';
    case Khoudh = 'khoudh';

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
            self::Khairat => 'الخيرات',
            self::Mawaleh => 'الموالح',
            self::Amarat => 'العامرات',
            self::MabailaSouth => 'المعبيلة الجنوبية',
            self::Barka => 'بركاء',
            self::Yanqul => 'ينقل',
            self::Bahla => 'بهلا',
            self::Suwaiq => 'السويق',
            self::Bidbid => 'بدبد',
            self::Bawshar => 'بوشر',
            self::Udhaibah => 'العذيبة',
            self::MabailaEighth => 'المعبيلة الثامنة',
            self::Khoudh => 'الخوض',
        };
    }
}
