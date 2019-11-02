<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\GenericDaos\AlbumDao;
use App\Transformer\AlbumTransformer;
use App\Transformer\TrackTransformer;

class AlbumController extends Controller
{
    public function album($id, AlbumDao $albumDao, AlbumTransformer $transformer)
    {
        $album = $albumDao->getMultiple([$id])->first();

        return $transformer->transform($album);
    }

    public function albums($ids, AlbumDao $albumDao, AlbumTransformer $transformer)
    {
        $ids = explode(',', $ids);
        $albums = $albumDao->getMultiple($ids);

        return $transformer->transform($albums);
    }

    public function tracks($id, AlbumDao $albumDao, TrackTransformer $transformer)
    {
        $tracks = $albumDao->tracksForAlbum($id);

        return $transformer->transform($tracks);
    }
}
