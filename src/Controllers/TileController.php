<?php

namespace LaravelTileserver\Controllers;

use Illuminate\Http\Request;
use LaravelTileserver\Exceptions\TileNotFoundException;
use LaravelTileserver\Tileset;

class TileController
{
    public function __invoke(Request $request, $tileset, $z, $x, $y)
    {
        // handle non modified etags
        $tiles = Tileset::fromMbtiles($tileset);

        try {
            $tile = $tiles->getTile($x, $y, $z);    
        } catch (TileNotFoundException $e) {
            abort(404);
        }

        return response($tile)
            ->header('Content-Type', 'application/x-protobuf')
            ->header('Content-Encoding', 'gzip')
            ->header('Access-Control-Allow-Origin', '*');
    }
}
