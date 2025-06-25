<?php

namespace Tests;

use App\Clients\StockStatus;
use Facades\App\Clients\ClientFactory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function mockClientRequest($available, $price)
    {

        ClientFactory::shouldReceive('make->checkAvailability')
            ->andReturn(new StockStatus($available, $price));

    }
}
