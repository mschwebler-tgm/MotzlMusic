import player from "$store/player/helpers/v2/player";
import app from "$components/app";

export default {
    currentTrack() {
        return player.currentTrack;
    },
    currentTrackId() {
        return player.currentTrackId;
    },
    playing() {
        return player.isPlaying;
    },
    trackDuration() {
        return player.currentTrack ? player.currentTrack.duration : 0;
    },
    noNextTrack() {
        return !player.canPlayNext;
    },
    noPreviousTrack() {
        return !player.canPlayPrevious;
    },
    loading() {
        return player.isLoading;
    },
    title() {
        return player.currentTrack ? player.currentTrack.name : 'No track';
    },
    artists() {
        return player.currentTrack ? player.currentTrack.artists.map(artist => artist.name).join(', ') : '-';
    },
    album() {
        if (!player.currentTrack || !player.currentTrack.album) {
            return null;
        }

        return player.currentTrack.album;
    },
    albumName() {
        if (!player.currentTrack || !player.currentTrack.album) {
            return '-';
        }

        return player.currentTrack.album.name;
    },
    albumCover() {
        if (!player.currentTrack || !player.currentTrack.album) {
            return window.playlistFallback;
        }

        return app.$root.getSpotifyImage(player.currentTrack.album, 'small');
    },
    playerProgress() {
        return player.progress;
    },
    playerProgressPercent() {
        return player.progressPercent;
    },
    durationFormatted() {
        return player.currentTrack ? player.currentTrack.duration_formatted : '-:-'
    },
    queuedTracks() {
        return player.queuedTracks;
    },
    queuedTracksRaw() {
        return player.queuedTracksRaw;
    },
    trackList() {
        return player.trackList;
    },
    trackListRaw() {
        return player.trackListRaw;
    },
}
