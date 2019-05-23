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
        this._updateBrowserTitle(track);
        if (!track) {
            return this._resume();
        }

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
    }
};
