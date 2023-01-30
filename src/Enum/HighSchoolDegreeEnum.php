<?php

namespace App\Enum;

class HighSchoolDegreeEnum
{
    const SECOND = 'SECOND';
    const FIRST = 'FIRST';
    const TERMINAL = 'TERMINAL';

    public static array $degrees = [
        self::SECOND => 'Seconde',
        self::FIRST => 'Première',
        self::TERMINAL => 'Terminale'
    ];

    public static function getDegree($key): string
    {
        if (!isset(self::$degrees[$key])) {
            return "Niveau inconnu ($key)";
        }

        return self::$degrees[$key];
    }

    public static function getChoices(): array
    {
        return array_flip(self::$degrees);
    }
}
