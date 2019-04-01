import SpotifyPlayer from "./spotifyPlayer";

export default class PlayerController {

    constructor($store) {
        this.$store = $store;
        this.spotifyPlayer = new SpotifyPlayer($store);
        this.playingTrack = null;
        this.loading = false;
        this.playing = false;
    }

    play(track) {
        if (track.type === 'spotify') {
            return this.spotifyPlayer.play(track).then(() => this._setPlayingTrack(track))
        }
    }

    pause() {
        if (this.playingTrack.type === 'spotify') {
            return this.spotifyPlayer.pause();
        }
    }

    _setPlayingTrack(track) {
        this.$store.commit('player/setPlayingTrack', track);
    }
};
