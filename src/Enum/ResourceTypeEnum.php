<?php

namespace App\Enum;

class ResourceTypeEnum
{
    const URL = 'URL';
    const FILE = 'FILE';

    public static array $types = [
        self::URL => 'URL',
        self::FILE => 'Fichier',
    ];

    public static function getType($key): string
    {
        if (!isset(self::$types[$key])) {
            return "Type inconnu ($key)";
        }

        return self::$types[$key];
    }

    public static function getChoices(): array
    {
        return array_flip(self::$types);
    }
}
