const identifier = 'local';
import axios from 'axios';
import player from '../player';

export default class SpotifyProvider {

    constructor(audioElement) {
        this._audioElement = audioElement;
    }

    async play(track) {
        console.log('play', track);
    }

    async pause() {
        console.log('pause');
    }

    async resume() {
        console.log('resume');
    }

    async seek(ms) {
        console.log('seek');
    }

    async setVolume(volume) {
        console.log('setVolume');
    }

    get identifier() {
        return identifier;
    }

}
