<?php

namespace Progs\UserManagement\Models;

use D3V\Interfaces\Authenticatable;

class User implements Authenticatable
{
    private $username = "";

    private $permissions = [];

    public static function loadFromRequest(): Authenticatable | null
    {
        return new User();
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function logout(): void
    {
        return;
    }

    public function checkPermission(string $permissionName): bool
    {
        return isset($this->permissions[$permissionName]);
    }
}
