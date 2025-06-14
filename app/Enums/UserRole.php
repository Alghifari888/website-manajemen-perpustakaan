<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case OFFICER = 'petugas';
    case MEMBER = 'anggota';
}