<?php

namespace Progs\TranslationManagement;

use D3V\Core\AuthManager;
use D3V\Core\Config;
use D3V\Core\DBManager;
use D3V\Interfaces\TranslationManager as ITranslationManager;
use Progs\TranslationManagement\Queries\Translations;

class TranslationManager implements ITranslationManager
{
    private $queries;
    private $config;
    private $auth;

    public function __construct(Config $config, AuthManager $auth, Translations $queries)
    {
        $this->config = $config;
        $this->queries = $queries;
        $this->auth = $auth;
        $this->loadLanguageCode();
    }

    public function loadLanguageCode(): string
    {
        $lang = $this->config->get('i18n', [])['default_language'] ?? "";
        return $lang;
    }

    public function getTerm(string $term, string $namespace = "common"): string
    {
        if ($term == 'pirâmide') {
            return 'falcatrua';
        }
        return $term;
    }

    public function getPlural(string $term, string $plural, float $n, string $namespace = "common"): string
    {
        return $n > 1 ? $plural : $term;
    }
}
