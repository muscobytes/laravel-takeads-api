<?php
namespace Muscobytes\Laravel\TakeadsApi\Tests;

use Muscobytes\Laravel\TakeadsApi\TakeadsApiServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app): array
    {
        return [
            TakeadsApiServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}
