export default class SpotifyPlayer {

    constructor($store) {
        this.$store = $store;
        this.deviceId = null;  // is set from SpotifyPlayer.vue
        this._player = null;
    }

    play(track) {
        return axios.put('/api/player/spotify/playTrack', {device_id: this.deviceId, track_id: track.spotify_id});
    }

    playCurrentTrack() {
        this._player.resume();
    }

    pause() {
        this._player.pause();
    }

    _initListeners() {
        this._player.addListener('player_state_changed', state => this._setLocalPlayingState(!state.paused));
    }

    _setLocalPlayingState(isPlaying) {
        if (this.$store.getters['player/playing'] !== isPlaying) {
            this.$store.commit('player/setPlayingState', isPlaying);
        }
    }

    set player(player) {
        this._player = player;
        this._initListeners();
    }
}
