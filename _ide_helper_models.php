<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Album
 *
 * @property int $id
 * @property string $name
 * @property int|null $popularity
 * @property string|null $label
 * @property string|null $release_date
 * @property int|null $total_tracks
 * @property string|null $spotify_id
 * @property string|null $spotify_href
 * @property string|null $spotify_uri
 * @property string|null $spotify_image_small
 * @property string|null $spotify_image_medium
 * @property string|null $spotify_image_large
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Artist[] $artists
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Album newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Album newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Album query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Album whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Album whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Album whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Album whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Album wherePopularity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Album whereReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Album whereSpotifyHref($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Album whereSpotifyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Album whereSpotifyImageLarge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Album whereSpotifyImageMedium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Album whereSpotifyImageSmall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Album whereSpotifyUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Album whereTotalTracks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Album whereUpdatedAt($value)
 */
	class Album extends \Eloquent {}
}

namespace App{
/**
 * App\AlbumHasArtist
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AlbumHasArtist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AlbumHasArtist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AlbumHasArtist query()
 */
	class AlbumHasArtist extends \Eloquent {}
}

namespace App{
/**
 * App\Artist
 *
 * @property int $id
 * @property string $name
 * @property int|null $popularity
 * @property string|null $spotify_id
 * @property string|null $spotify_href
 * @property string|null $spotify_uri
 * @property string|null $spotify_image_small
 * @property string|null $spotify_image_medium
 * @property string|null $spotify_image_large
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Album[] $albums
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Track[] $tracks
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist wherePopularity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist whereSpotifyHref($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist whereSpotifyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist whereSpotifyImageLarge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist whereSpotifyImageMedium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist whereSpotifyImageSmall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist whereSpotifyUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist whereUpdatedAt($value)
 */
	class Artist extends \Eloquent {}
}

namespace App{
/**
 * App\Track
 *
 * @property int $id
 * @property string $name
 * @property int|null $popularity
 * @property int|null $duration
 * @property int|null $album_id
 * @property int $user_id
 * @property string|null $spotify_id
 * @property string|null $spotify_href
 * @property string|null $spotify_uri
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Artist[] $artists
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Track newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Track newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Track query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Track whereAlbumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Track whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Track whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Track whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Track whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Track wherePopularity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Track whereSpotifyHref($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Track whereSpotifyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Track whereSpotifyUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Track whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Track whereUserId($value)
 */
	class Track extends \Eloquent {}
}

namespace App{
/**
 * App\TrackHasArtist
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TrackHasArtist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TrackHasArtist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TrackHasArtist query()
 */
	class TrackHasArtist extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $spotify_id
 * @property string|null $spotify_access_token
 * @property string|null $spotify_refresh_token
 * @property string|null $spotify_token_expire
 * @property string|null $birthdate
 * @property bool $spotify_import_complete
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSpotifyAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSpotifyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSpotifyImportComplete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSpotifyRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSpotifyTokenExpire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

