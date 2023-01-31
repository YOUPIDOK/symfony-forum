<?php

namespace App\Enum;

class UserRoleEnum
{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_SPEAKER = 'ROLE_SPEAKER';
    const ROLE_STUDENT = 'ROLE_STUDENT';
    const ROLE_HIGH_SCHOOL = 'ROLE_HIGH_SCHOOL';

    public static array $roles = [
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_SPEAKER => 'Intervenant',
        self::ROLE_STUDENT => 'Étudiant',
        self::ROLE_HIGH_SCHOOL => 'Lycée'
    ];

    public static function getRole($key): string
    {
        if (!isset(self::$roles[$key])) {
            return "Role ($key) inconnu";
        }

        return self::$roles[$key];
    }

    public static function getChoices(): array
    {
        return array_flip(self::$roles);
    }
}
