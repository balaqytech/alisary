<?php

namespace App\Enums;

enum Governorate: string
{
    case Muscat = 'muscat_gov';
    case Dhofar = 'dhofar_gov';
    case NorthBatinah = 'north_batinah_gov';
    case SouthBatinah = 'south_batinah_gov';
    case Dakhiliyah = 'dakhiliyah_gov';
    case Dhahirah = 'dhahirah_gov';
    case Buraimi = 'buraimi_gov';
    case Musandam = 'musandam_gov';
    case Wusta = 'wusta_gov';
    case NorthSharqiyah = 'north_sharqiyah_gov';
    case SouthSharqiyah = 'south_sharqiyah_gov';

    public function label(): string
    {
        return match ($this) {
            self::Muscat => 'محافظة مسقط',
            self::Dhofar => 'محافظة ظفار',
            self::NorthBatinah => 'محافظة شمال الباطنة',
            self::SouthBatinah => 'محافظة جنوب الباطنة',
            self::Dakhiliyah => 'محافظة الداخلية',
            self::Dhahirah => 'محافظة الظاهرة',
            self::Buraimi => 'محافظة البريمي',
            self::Musandam => 'محافظة مسندم',
            self::Wusta => 'محافظة الوسطى',
            self::NorthSharqiyah => 'محافظة شمال الشرقية',
            self::SouthSharqiyah => 'محافظة جنوب الشرقية',
        };
    }
}
