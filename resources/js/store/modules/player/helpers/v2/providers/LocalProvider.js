const identifier = 'local';
import player from '../player';

export default class SpotifyProvider {

    constructor(audioElement) {
        this.progress = 0;
        this.progressPercent = 0;
        this._audioElement = audioElement;
        this._pollInterval = null;
    }

    async play(track) {
        this._audioElement.src = this._getAudioSource(track.id);
        await this._audioElement.play();
        this._subscribeToProgress();
    }

    async pause() {
        await this._audioElement.pause();
        this._unsubscribeFromProgress();
    }

    async resume() {
        if (this._audioElement.src) {
            await this._audioElement.play();
            this._subscribeToProgress();
        }
    }

    async seek(ms) {
        this._audioElement.currentTime = ms / 1000;
    }

    async setVolume(volume) {
        this._audioElement.volume = volume;
    }

    get identifier() {
        return identifier;
    }

    _getAudioSource(trackId) {
        return '/file/track/' + trackId;
    }

    _subscribeToProgress() {
        this._pollInterval = setInterval(() => {
            this._handleProgress(this._audioElement.currentTime * 1000);
        }, 1000);
    }

    _unsubscribeFromProgress() {
        clearInterval(this._pollInterval);
    }

    _handleProgress(progressMs) {
        const total = player.currentTrack.duration;

        this._setProgressPercent(total, progressMs);
        this._playNextIfNeeded(total, progressMs);
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
}
