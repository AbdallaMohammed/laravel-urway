<?php

namespace URWay;

use GuzzleHttp\Client;

abstract class BaseService
{
    /**
     * Store guzzle client instance.
     *
     * @var Client
     */
    protected $guzzleClient;

    /**
     * Store URWAY payment endpoint.
     *
     * @var string
     */
    protected $endpoint;

    /**
     * BaseService Constructor.
     */
    public function __construct()
    {
        $this->guzzleClient = new Client();
    }

    /**
     * @return string
     */
    public function getEndPointPath()
    {
        return $this->getBasePath() . '/' . $this->endpoint;
    }

    /**
     * Determine the base path based on the mode.
     *
     * @return string
     */
    public function getBasePath()
    {
        if ($this->isTesting()) {
            return 'https://payments-dev.urway-tech.com';
        }

        return 'https://payments.urway-tech.com';
    }

    /**
     * Get the package mode.
     *
     * @return string
     */
    public function getMode()
    {
        return config('urway.mode', 'test');
    }

    /**
     * Determine whether the mode is test.
     *
     * @return boolean
     */
    protected function isTesting()
    {
        return $this->getMode() == 'test';
    }

    /**
     * Determine whether the mode is production.
     *
     * @return boolean
     */
    protected function isProduction()
    {
        return $this->getMode() == 'production';
    }
}
