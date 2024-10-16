<?php

namespace Muscobytes\Laravel\TakeadsApi\Facades;

use Illuminate\Support\Facades\Facade;

class TakeadsApiFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'takeadsapi';
    }
}
