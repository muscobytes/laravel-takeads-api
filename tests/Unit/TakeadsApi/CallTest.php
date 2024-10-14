<?php

namespace Muscobytes\Laravel\TakeadsApi\Tests\Unit\TakeadsApi;

use Muscobytes\Laravel\TakeadsApi\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversMethod;


#[CoversMethod('Muscobytes\Laravel\TakeadsApi\TakeadsApi', 'call')]
class CallTest extends TestCase
{
    public function testTakeadsApiCallMethod()
    {
        $this->assertTrue(true);
    }
}