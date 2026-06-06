<?php

namespace App\Enums;

enum CustomFieldType: string
{
    case Text = 'text';
    case Textarea = 'textarea';
    case Email = 'email';
    case Phone = 'phone';
    case Number = 'number';
    case Date = 'date';
    case Select = 'select';
    case Checkbox = 'checkbox';
    case File = 'file';

    public function label(): string
    {
        return match ($this) {
            self::Text => 'نص قصير',
            self::Textarea => 'نص طويل',
            self::Email => 'بريد إلكتروني',
            self::Phone => 'هاتف',
            self::Number => 'رقم',
            self::Date => 'تاريخ',
            self::Select => 'قائمة اختيار',
            self::Checkbox => 'مربع موافقة',
            self::File => 'ملف',
        };
    }
}
