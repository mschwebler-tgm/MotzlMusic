import PlayerClient from "./playerClient";

const DEBUG = true;

export default class Player {

    constructor(playerClient) {
        this._playerClient = playerClient || new PlayerClient();
        this._currentTrackList = [];
        this._currentTrackIndex = 0;
        this._isPlaying = true;
    }

    playList(tracks = [], startIndex = 0) {
        this._currentTrackList = tracks;
        this._currentTrackIndex = startIndex;
        this._playCurrentTrack();
    }

    playNext() {
        if (this.canPlayNext) {
            this._log('Tried to call playNext(), but end of track list was already reached.');
            return;
        }

        this._currentTrackIndex++;
        this._playCurrentTrack();
    }

    pause() {
        if (this._isPlaying) {
            this._playerClient.pause();
            this._isPlaying = false;
        }
    }

    _playCurrentTrack() {
        this._playerClient.play(this.currentTrack);
    }

    _log(msg) {
        DEBUG && console.log(msg);
    }

    get canPlayNext() {
        return this._currentTrackIndex + 1 >= this._currentTrackList.length;
    }

    get currentTrack() {
        return this._currentTrackList[this._currentTrackIndex];
    }

    get isPaused() {
        return !this._isPlaying;
    }
}
