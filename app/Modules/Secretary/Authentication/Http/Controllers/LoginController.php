<?php

namespace App\Modules\Secretary\Authentication\Http\Controllers;

use App\Shared\Identity\Enums\UserRole;
use App\Shared\Identity\Http\Controllers\AbstractLoginController;

class LoginController extends AbstractLoginController
{
    protected function expectedRole(): UserRole {
        return UserRole::Secretary;
    }
}
