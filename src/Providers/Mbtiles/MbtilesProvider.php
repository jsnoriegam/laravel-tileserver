<?php

namespace LaravelTileserver\Providers\Mbtiles;

use Illuminate\Support\Facades\DB;
use LaravelTileserver\Contracts\TileProviderContract;
use LaravelTileserver\Exceptions\TileNotFoundException;
use LaravelTileserver\Tileserver;
use LaravelTileserver\TilesetMetadata;

class MbtilesProvider implements TileProviderContract
{
    /** @var SQLiteConnection */
    protected $database;

    /** @var string */
    protected $tileset;

    public function __construct($tileset)
    {
        $this->tileset = $tileset;

        DB::purge('tileset');
        
        config()->set('database.connections.tileset', array_merge(config('database.connections.sqlite'), [
            'database' => Tileserver::file($tileset),
        ]));

        $this->database = DB::connection('tileset');
    }
    
    public function getMetadata(): TilesetMetadata
    {
        return (new GenerateMetadataFromMbtiles)($this->tileset, $this->database);
    }

    public function getTile($x, $y, $z)
    {
        $flip = true;
        if ($flip) {
            $y = pow(2, $z) - 1 -$y;
        }

        $result = $this->database->table('tiles')
            ->where('zoom_level', (int) $z)
            ->where('tile_column', (int) $x)
            ->where('tile_row', (int) $y)
            ->first();

        throw_if(is_null($result), TileNotFoundException::class);

        return $result->tile_data;
    }
}
