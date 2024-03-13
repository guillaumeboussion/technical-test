<?php

namespace App\Enum;

enum ProfileStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Pending = 'pending';
}
