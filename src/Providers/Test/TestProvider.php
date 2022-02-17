<?php

namespace LaravelTileserver\Providers\Test;

use LaravelTileserver\Contracts\TileProviderContract;

class TestProvider implements TileProviderContract
{
    public function getMetadata()
    {

    }

    public function getTile($x, $y, $z)
    {
        
    }
}
