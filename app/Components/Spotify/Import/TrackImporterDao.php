<?php

namespace App\Components\Spotify\Import;

use App\Album;
use App\Artist;
use App\Components\Spotify\Models\Album as SpotifyAlbum;
use App\Components\Spotify\Models\Artist as SpotifyArtist;
use App\Components\Spotify\Models\Track as SpotifyTrack;
use App\Track;
use App\User;
use Illuminate\Support\Collection;

class TrackImporterDao
{
    public function saveTracksForCurrentUser(Collection $spotifyTracks)
    {
        $this->saveTracksForUser($spotifyTracks, apiUser());
    }

    private function saveTracksForUser(Collection $spotifyTracks, User $apiUser)
    {
        /** @var SpotifyTrack $spotifyTrack */
        foreach ($spotifyTracks as $spotifyTrack) {
            $track = $this->storeTrack($spotifyTrack, $apiUser);
            $album = $this->storeAlbum($spotifyTrack->album);
            $artists = $this->storeArtists($spotifyTrack->artists);
        }
    }

    private function storeTrack(SpotifyTrack $spotifyTrack, User $user)
    {
        /** @var Track $track */
        $track = Track::firstOrCreate([
            'spotify_id' => $spotifyTrack->id,
            'name' => $spotifyTrack->name,
            'user_id' => $user->id
        ]);
        $track->fill([
            'duration' => $spotifyTrack->duration,
            'popularity' => $spotifyTrack->popularity,
            'spotify_href' => $spotifyTrack->href,
            'spotify_uri' => $spotifyTrack->uri,
        ])->save();

        // TODO dispatch job to fetch track analysis

        return $track;
    }

    private function storeAlbum(SpotifyAlbum $spotifyAlbum)
    {
        /** @var Album $album */
        $album = Album::firstOrCreate([
            'spotify_id' => $spotifyAlbum->id,
            'name' => $spotifyAlbum->name
        ]);
        $album->fill([
            'popularity' => $spotifyAlbum->popularity,
            'label' => $spotifyAlbum->label,
            'release_date' => $spotifyAlbum->releaseDate,
            'total_tracks' => $spotifyAlbum->totalTracks,
            'spotify_href' => $spotifyAlbum->href,
            'spotify_uri' => $spotifyAlbum->uri,
            'spotify_image_small' => $spotifyAlbum->images[2]->url ?? $album->spotify_image_small,
            'spotify_image_medium' => $spotifyAlbum->images[1]->url ?? $album->spotify_image_medium,
            'spotify_image_large' => $spotifyAlbum->images[0]->url ?? $album->spotify_image_large,
        ])->save();

        // TODO dispatch job to refine album

        return $album;
    }

    private function storeArtists(Collection $spotifyArtists)
    {
        $artists = collect();
        /** @var SpotifyArtist $spotifyArtist */
        foreach ($spotifyArtists as $spotifyArtist) {
            /** @var Artist $artist */
            $artist = Artist::firstOrCreate([
                'spotify_id' => $spotifyArtist->id,
                'name' => $spotifyArtist->name
            ]);
            $artist->fill([
                'popularity' => $spotifyArtist->popularity,
                'spotify_href' => $spotifyArtist->href,
                'spotify_uri' => $spotifyArtist->uri,
                'spotify_image_small' => $spotifyArtist->images[2]->url ?? $artist->spotify_image_small,
                'spotify_image_medium' => $spotifyArtist->images[1]->url ?? $artist->spotify_image_medium,
                'spotify_image_large' => $spotifyArtist->images[0]->url ?? $artist->spotify_image_large,
            ])->save();

            // TODO dispatch job to refine artist

            $artists->push($artist);
        }

        return $artists;
    }
}
