export default class SpotifyPlayer {

    constructor($store, controller) {
        this.$store = $store;
        this.deviceId = null;  // is set from SpotifyPlayer.vue
        this._player = null;
        this._controller = controller;
        this._pollInterval = null;
    }

    play(track) {
        this._subscribeToProgress();
        return axios.put('/api/player/spotify/playTrack', {device_id: this.deviceId, track_id: track.spotify_id});
    }

    resume() {
        this._subscribeToProgress();
        this._player.resume();
    }

    pause() {
        clearInterval(this._pollInterval);
        this._player.pause();
    }

    _initListeners() {
        this._player.addListener('player_state_changed', state => this._handlePlayerStateChanged(state));
    }

    /**
     * @param state WebPlaybackState https://developer.spotify.com/documentation/web-playback-sdk/reference/#object-web-playback-state
     * @private
     */
    _handlePlayerStateChanged(state) {
        this._setPlayingState(state.paused);
    }

    _setPlayingState(isPaused) {
        if (this.$store.getters['player/playing'] === isPaused) {
            this.$store.commit('player/setPlayingState', !isPaused);
        }
    }

    _subscribeToProgress() {
        clearInterval(this._pollInterval);
        this._pollInterval = setInterval(() => {
            this._player.getCurrentState().then(state => state && this._setProgressPercent(state));
        }, 1000);
    }

    _setProgressPercent(state) {
        const total = state.duration;
        const current = state.position;
        if (!total || !current) {
            return 0;
        }

        this._controller.progressPercent = Math.round((100 * current / total) * 1000) / 1000;
    }

    set player(player) {
        this._player = player;
        this._initListeners();
    }
}
