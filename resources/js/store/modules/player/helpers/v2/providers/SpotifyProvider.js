const identifier = 'spotify';
import axios from 'axios';
import player from '../player';

export default class SpotifyProvider {

    constructor(deviceId, spotifyPlayerInstance) {
        this.progress = 0;
        this.progressPercent = 0;
        this._deviceId = deviceId;
        this._spotifyPlayerInstance = spotifyPlayerInstance;
        this._pollInterval = null;
        this._initListeners();
    }

    play(track) {
        this._subscribeToProgress();
        return axios.put('/api/player/spotify/playTrack', {device_id: this._deviceId, track_id: track.spotify_id});
    }

    pause() {
        this._unsubscribeFromProgress();
        this._spotifyPlayerInstance.pause();
    }

    resume() {
        this._subscribeToProgress();
        this._spotifyPlayerInstance.resume();
    }

    _subscribeToProgress() {
        this._pollInterval = setInterval(() => {
            this._spotifyPlayerInstance.getCurrentState().then(state => state && this._handleProgress(state));
        }, 1000);
    }

    _unsubscribeFromProgress() {
        clearInterval(this._pollInterval);
    }

    _handleProgress(state) {
        const total = state.duration;
        const current = state.position;

        if (!total || !current) {
            return 0;
        }

        this._setProgressPercent(total, current);
        this._playNextIfNeeded(total, current);
    }

    _setProgressPercent(total, current) {
        this.progress = current;
        this.progressPercent = Math.round((100 * current / total) * 1000) / 1000;
    }

    _playNextIfNeeded(total, current) {
        if (total - current <= 1000) {
            this._unsubscribeFromProgress();
            player.playNext();
        }
    }

    _initListeners() {
        this._spotifyPlayerInstance.addListener('player_state_changed', state => this._handlePlayerStateChanged(state));
    }

    /** @param state WebPlaybackState https://developer.spotify.com/documentation/web-playback-sdk/reference/#object-web-playback-state */
    _handlePlayerStateChanged(state) {
        this._setPlayingState(state.paused);
    }

    _setPlayingState(isPaused) {
        if (isPaused) {
            player.pause();
        } else {
            player.resume();
        }
    }

    get identifier() {
        return identifier;
    }
}
