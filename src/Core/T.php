<?php

namespace D3V\Core;

use D3V\Interfaces\TranslationManager;

class T
{
    private static TranslationManager $manager;

    public static function setupTranslationManager($manager)
    {
        self::$manager = $manager;
    }

    // singular terms
    public static function t($term, $namespace = ""): string
    {
        return self::$manager->getTerm($term, $namespace);
    }

    //plural terms
    public static function p($singular, $plural, $n, $namespace = ""): string
    {
        return self::$manager->getTerm($singular, $plural, $n, $namespace);
    }
}
