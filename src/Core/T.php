<?php

namespace D3V\Core;

use D3V\Interfaces\TranslationManager;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class T
{
    private static TranslationManager $manager;
    private static CacheInterface $cache;

    public static function setupTranslationManager($manager, $cache)
    {
        self::$manager = $manager;
        self::$cache = $cache;
    }

    // singular terms
    public static function t($term, $namespace = "common"): string
    {
        return self::$cache->get("i18n.$namespace.$term", function (ItemInterface $item) use ($term, $namespace) {
            $item->tag(['i18n', $namespace]);
            return self::$manager->getTerm($term, $namespace);
        });
    }

    //plural terms
    public static function p($singular, $plural, $n, $namespace = "common"): string
    {
        return self::$cache->get("i18n.$namespace.$singular.$plural.$n", function (ItemInterface $item) use ($singular, $plural, $n, $namespace) {
            $item->tag(['i18n', $namespace]);
            return self::$manager->getPlural($singular, $plural, $n, $namespace);
        });
    }
}
