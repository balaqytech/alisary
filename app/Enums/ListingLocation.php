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

    /**
     * Real-world Omani governorate each branch/town belongs to.
     *
     * NOTE: "Khairat" has no confirmed match in the standard wilayat list;
     * mapped to Muscat as a best guess — verify with an admin before relying on it.
     */
    public function governorate(): ?Governorate
    {
        return match ($this) {
            self::Remote => null,
            self::Muscat, self::Mawaleh, self::Amarat, self::MabailaSouth,
            self::MabailaEighth, self::Bawshar, self::Udhaibah, self::Khoudh,
            self::Khairat => Governorate::Muscat,
            self::Salalah => Governorate::Dhofar,
            self::Sohar => Governorate::NorthBatinah,
            self::Rustaq, self::Suwaiq, self::Barka => Governorate::SouthBatinah,
            self::Nizwa, self::Bahla, self::Bidbid => Governorate::Dakhiliyah,
            self::Ibri, self::Yanqul => Governorate::Dhahirah,
            self::Buraimi => Governorate::Buraimi,
            self::Khasab => Governorate::Musandam,
            self::Duqm => Governorate::Wusta,
            self::Ibra => Governorate::NorthSharqiyah,
            self::Sur => Governorate::SouthSharqiyah,
        };
    }
}
