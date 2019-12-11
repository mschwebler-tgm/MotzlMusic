<?php

namespace App\Transformer;

use App\ModelScopes\PlaylistsCurrentUserScope;
use App\Playlist;

class PlaylistTransformer extends Transformable
{
    /**
     * @param $playlist Playlist
     * @return array
     */
    protected function transformItem($playlist)
    {
        $tracks = $this->pluckIdAndName($playlist->tracks);
        $tracksUrl = Playlist::hasGlobalScope(PlaylistsCurrentUserScope::class) ?
            route('getMyPlaylistsTracks', ['id' => $playlist->id], false) :
            route('getPlaylistTracks', ['id' => $playlist->id], false);

        return [
            'type' => 'playlist',
            'id' => $playlist->id,
            'name' => $playlist->name,
            'description' => $playlist->description,
            'is_public' => $playlist->is_public,
            'user_id' => $playlist->user_id,
            'spotify_id' => $playlist->spotify_id,
            'spotify_image_small' => $playlist->spotify_image_small,
            'spotify_image_medium' => $playlist->spotify_image_medium,
            'spotify_image_large' => $playlist->spotify_image_large,
            'audio_features_url' => route('getPlaylistAudioFeatures', ['id' => $playlist->id], false),
            'tracks' => $tracks,
            'tracks_url' => $tracksUrl,
        ];
    }
}
