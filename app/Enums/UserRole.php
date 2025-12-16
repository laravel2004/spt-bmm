<?php

namespace App\Enums;

enum UserRole: string
{
    case SUPERADMIN   = 'SUPERADMIN';
    case ADMIN  = 'ADMIN';
    case SOPIR = 'DRIVER';
}
