import SpotifyPlayer from "./spotifyPlayer";

export default class PlayerController {

    constructor($store) {
        this.$store = $store;
        this.spotifyPlayer = new SpotifyPlayer($store, this);
        this.playingTrack = null;
        this.loading = false;
        this.playing = false;
        this.progressPercent = 0;
    }

    play(track) {
        if (!track) {
            return this._resume();
        }

        this._updateBrowserTitle(track);
        if (track.type === 'spotify') {
            this.loading = true;
            return this.spotifyPlayer.play(track).then(() => this._setPlayingTrack(track))
                .then(() => this.loading = false);
        }
    }

    pause() {
        if (this.playingTrack.type === 'spotify') {
            this.playing = false;
            return this.spotifyPlayer.pause();
        }
    }

    _resume() {
        if (this.playingTrack.type === 'spotify') {
            this.playing = true;
            return this.spotifyPlayer.resume();
        }
    }

    _setPlayingTrack(track) {
        this.$store.commit('player/setPlayingTrack', track);
    }

    _updateBrowserTitle(track) {
        document.getElementsByTagName('title')[0].text = track.name;
        // if ('mediaSession' in navigator) {
        //     navigator.mediaSession.metadata = new MediaMetadata({
        //         title: 'Never Gonna Give You Up',
        //         artist: 'Rick Astley',
        //         album: 'Whenever You Need Somebody',
        //         artwork: [
        //             { src: 'https://dummyimage.com/96x96',   sizes: '96x96',   type: 'image/png' },
        //             { src: 'https://dummyimage.com/128x128', sizes: '128x128', type: 'image/png' },
        //             { src: 'https://dummyimage.com/192x192', sizes: '192x192', type: 'image/png' },
        //             { src: 'https://dummyimage.com/256x256', sizes: '256x256', type: 'image/png' },
        //             { src: 'https://dummyimage.com/384x384', sizes: '384x384', type: 'image/png' },
        //             { src: 'https://dummyimage.com/512x512', sizes: '512x512', type: 'image/png' },
        //         ]
        //     });
        //     navigator.mediaSession.setActionHandler('play', function() {});
        //     navigator.mediaSession.setActionHandler('pause', function() {});
        //     navigator.mediaSession.setActionHandler('seekbackward', function() {});
        //     navigator.mediaSession.setActionHandler('seekforward', function() {});
        //     navigator.mediaSession.setActionHandler('previoustrack', function() {});
        //     navigator.mediaSession.setActionHandler('nexttrack', function() {});
        //     navigator.mediaSession.playbackState = 'playing';
        // }
    }
};
