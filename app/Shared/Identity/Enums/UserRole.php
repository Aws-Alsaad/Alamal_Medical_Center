<?php

namespace App\Shared\Identity\Enums;

enum UserRole: string
{
    case Patient = 'patient';
    case Doctor = 'doctor';
    case Secretary = 'secretary';
    case SuperAdministrator = 'super_administrator';
}
