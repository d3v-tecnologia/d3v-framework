<?php

namespace D3V\Interfaces;

use D3V\Core\Request;

interface Authenticatable
{
    public static function loadFromRequest(Request $request): Authenticatable;

    public function getUsername(): string;

    public function checkPermission(string $permissionName): bool;

    public function logout(): void;
}
