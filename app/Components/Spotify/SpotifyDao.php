<?php

namespace App\Components\Spotify;

use App\Album;
use App\Artist;
use App\Components\Spotify\Models\Album as SpotifyAlbum;
use App\Components\Spotify\Models\AudioFeatures as SpotifyAudioFeatures;
use App\Components\Spotify\Models\Artist as SpotifyArtist;
use App\Components\Spotify\Models\Track as SpotifyTrack;
use App\Components\Spotify\Models\Playlist as SpotifyPlaylist;
use App\DTOs\TrackDTO;
use App\Playlist;
use App\SpotifyAudioFeature;
use App\Track;
use App\User;
use Illuminate\Support\Collection;

class SpotifyDao
{
    public function storeTrack(SpotifyTrack $spotifyTrack, User $user, $albumId = null)
    {
        /** @var Track $track */
        $track = Track::firstOrCreate([
            'spotify_id' => $spotifyTrack->id,
            'name' => $spotifyTrack->name,
            'user_id' => $user->id,
            'type' => 'spotify',
        ]);
        $track->fill(TrackDTO::spotifyModelToDatabaseArray($spotifyTrack, $user, $albumId))->save();

        return $track;
    }

    public function storeAlbum(SpotifyAlbum $spotifyAlbum)
    {
        /** @var Album $album */
        $album = Album::firstOrCreate([
            'spotify_id' => $spotifyAlbum->id,
            'name' => $spotifyAlbum->name
        ]);
        $album->fill([
            'popularity' => $spotifyAlbum->popularity ?? $album->popularity,
            'label' => $spotifyAlbum->label ?? $album->label,
            'release_date' => $spotifyAlbum->releaseDate,
            'total_tracks' => $spotifyAlbum->totalTracks,
            'spotify_href' => $spotifyAlbum->href,
            'spotify_uri' => $spotifyAlbum->uri,
            'spotify_image_small' => $spotifyAlbum->images[2]->url ?? $album->spotify_image_small,
            'spotify_image_medium' => $spotifyAlbum->images[1]->url ?? $album->spotify_image_medium,
            'spotify_image_large' => $spotifyAlbum->images[0]->url ?? $album->spotify_image_large,
        ])->save();

        return $album;
    }

    public function storeArtists(Collection $spotifyArtists)
    {
        $artists = collect();
        /** @var SpotifyArtist $spotifyArtist */
        foreach ($spotifyArtists as $spotifyArtist) {
            $artists->push($this->storeArtist($spotifyArtist));
        }

        return $artists;
    }

    public function storeArtist(SpotifyArtist $spotifyArtist)
    {
        /** @var Artist $artist */
        $artist = Artist::firstOrCreate([
            'spotify_id' => $spotifyArtist->id,
            'name' => $spotifyArtist->name
        ]);
        $artist->fill([
            'popularity' => $spotifyArtist->popularity ?? $artist->popularity,
            'spotify_href' => $spotifyArtist->href,
            'spotify_uri' => $spotifyArtist->uri,
            'spotify_image_small' => $spotifyArtist->images[2]->url ?? $artist->spotify_image_small,
            'spotify_image_medium' => $spotifyArtist->images[1]->url ?? $artist->spotify_image_medium,
            'spotify_image_large' => $spotifyArtist->images[0]->url ?? $artist->spotify_image_large,
        ])->save();

        return $artist;
    }

    public function storeAudioFeature(SpotifyAudioFeatures $spotifyAudioFeatures, $spotifyTrackId)
    {
        $track = Track::where('spotify_id', $spotifyTrackId)->first();
        if (!$track) {
            \Log::warning('Trying to save spotify audio feature to track which is not available in database. (' . __METHOD__ . ')');
            return null;
        }

        /** @var SpotifyAudioFeature $audioFeatures */
        $audioFeatures = SpotifyAudioFeature::firstOrNew([
            'track_id' => $track->id
        ]);
        $audioFeatures->fill([
            'energy' => $spotifyAudioFeatures->energy,
            'valence' => $spotifyAudioFeatures->valence,
            'danceability' => $spotifyAudioFeatures->danceability,
            'speechiness' => $spotifyAudioFeatures->speechiness,
            'acousticness' => $spotifyAudioFeatures->acousticness,
            'instrumentalness' => $spotifyAudioFeatures->instrumentalness,
            'liveness' => $spotifyAudioFeatures->liveness,
            'loudness' => $spotifyAudioFeatures->loudness,
            'key' => $spotifyAudioFeatures->key,
            'mode' => $spotifyAudioFeatures->mode,
            'tempo' => $spotifyAudioFeatures->tempo,
            'spotify_id' => $spotifyAudioFeatures->id,
        ])->save();

        return $audioFeatures;
    }

    public function storePlaylist(SpotifyPlaylist $spotifyPlaylist, $userId)
    {
        /** @var Playlist $playlist */
        $playlist = Playlist::firstOrNew([
            'spotify_id' => $spotifyPlaylist->id
        ]);
        $playlist->fill([
            'name' => $spotifyPlaylist->name,
            'description' => $spotifyPlaylist->description,
            'spotify_image_small' => $spotifyPlaylist->images[2]->url ?? $playlist->spotify_image_small,
            'spotify_image_medium' => $spotifyPlaylist->images[1]->url ?? $playlist->spotify_image_medium,
            'spotify_image_large' => $spotifyPlaylist->images[0]->url ?? $playlist->spotify_image_large,
            'user_id' => $userId,
            'is_public' => $spotifyPlaylist->isPublic,
        ])->save();

        return $playlist;
    }
}
