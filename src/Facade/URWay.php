<?php

namespace URWay\Facade;

use URWay\Client;
use Illuminate\Support\Facades\Facade;

class URWay extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return Client::class;
    }
}