const identifier = 'spotify';
import axios from 'axios';

export default class SpotifyProvider {

    constructor(deviceId, spotifyPlayerInstance) {
        this.progress = 0;
        this._deviceId = deviceId;
        this._spotifyPlayerInstance = spotifyPlayerInstance;
    }

    play(track) {
        return axios.put('/api/player/spotify/playTrack', {device_id: this._deviceId, track_id: track.spotify_id});
    }

    pause() {
        this._spotifyPlayerInstance.pause();
    }

    resume() {
        this._spotifyPlayerInstance.resume();
    }

    get identifier() {
        return identifier;
    }

}
