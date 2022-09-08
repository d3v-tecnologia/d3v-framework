<?php

namespace D3V\Lib;

class Permission
{
    private string $name;
    private string $displayName;
    private string $description;


    public function __construct($name, $displayName, $description)
    {
        $this->name = $name;
        $this->displayName = $displayName;
        $this->description = $description;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function getDescription()
    {
        return $this->description;
    }
}
