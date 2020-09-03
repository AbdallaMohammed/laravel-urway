<?php

namespace URWAY\Tests;

use URWay\Client;

class TestServiceProvider extends AbstractTestCase
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('urway.auth.terminal_id', 'my_terminal_id');
        $app['config']->set('urway.auth.password', 'my_password');
        $app['config']->set('urway.auth.merchant_key', 'my_merchant_key');
    }

    /**
     * Test that we can create the client
     * from container binding.
     * 
     * @return void
     */
    public function testClientResolutionFromContainer()
    {
        $client = app(Client::class);

        $this->assertInstanceOf(Client::class, $client);
    }
}