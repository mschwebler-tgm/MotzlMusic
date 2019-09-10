const identifier = 'spotify';
import axios from 'axios';

export default class SpotifyProvider {

    constructor(deviceId) {
        this.progress = 0;
        this._deviceId = deviceId;
        this._spotifyPlayerInstance = null;
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

    setSpotifyPlayerInstance(instance) {
        this._spotifyPlayerInstance = instance;
    }

    get identifier() {
        return identifier;
    }

}
