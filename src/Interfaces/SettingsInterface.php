<?php

namespace Muscobytes\Laravel\TakeadsApi\Interfaces;

interface SettingsInterface
{
    public function getById(string $id): string;
}
