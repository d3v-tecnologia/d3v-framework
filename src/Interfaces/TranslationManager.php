<?php

namespace D3V\Interfaces;

interface TranslationManager
{
    public function loadLanguageCode(): string;

    public function getTerm(string $term, string $namespace = "common"): string;

    public function getPlural(string $term, string $plural, float $n, string $namespace = "common"): string;
}
