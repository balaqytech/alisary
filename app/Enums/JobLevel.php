<?php

namespace App\Enums;

enum JobLevel: string
{
    case L1 = 'L1';
    case L2 = 'L2';
    case L3 = 'L3';
    case L4 = 'L4';
    case L5 = 'L5';

    public function label(): string
    {
        return $this->value;
    }
}
