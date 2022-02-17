<?php

namespace TeamZac\LaravelTileserver\Tests;

use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase;
use LaravelTileserver\LaravelTileserverServiceProvider;
use LaravelTileserver\Tileserver;
use LaravelTileserver\Tileset;

class MbtilesProviderTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [LaravelTileserverServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        Tileserver::routes();

        $a = Tileset::fromMbtiles('cfw');
        dd($a->getMetadata()->all());
    }
}
