<?php

namespace App\Users\Infrastructure;

enum Roles: string
{
    case USER = 'ROLE_USER';
    case ADMIN = 'ROLE_ADMIN';
}
