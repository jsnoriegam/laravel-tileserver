<?php

namespace LaravelTileserver\Controllers;

use Illuminate\Http\Request;
use LaravelTileserver\Tileset;

class MetadataController
{
    public function __invoke(Request $request, $tileset)
    {
        // handle non modified etags
        $tileset = Tileset::fromMbtiles($tileset);
        return response()->json($tileset->getMetadata()->all());
    }
}
