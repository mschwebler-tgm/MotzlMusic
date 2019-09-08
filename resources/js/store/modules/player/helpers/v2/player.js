import PlayerClient from "./playerClient";

const DEBUG = true;
const KEEP_PAST_TRACKS = 15;

export default class Player {

    constructor(playerClient) {
        this._playerClient = playerClient || new PlayerClient();
        this._currentTrackList = [];
        this._currentTrackIndex = 0;
        this._isPlaying = true;
        this._pastTracksAmountToKeep = KEEP_PAST_TRACKS;
    }

    playList(tracks = [], startIndex = 0) {
        this._currentTrackList = tracks;
        this._currentTrackIndex = startIndex;
        this._playCurrentTrack();
        this._setTrackList();
    }

    playNext() {
        if (this.canPlayNext) {
            this._log('Tried to call playNext(), but end of track list was already reached.');
            return;
        }

        this._currentTrackIndex++;
        this._playCurrentTrack();
        this._setTrackList();
    }

    pause() {
        if (this._isPlaying) {
            this._playerClient.pause();
            this._isPlaying = false;
        }
    }

    resume() {
        if (this.currentTrack && this.isPaused) {
            this._playerClient.resume();
            this._isPlaying = true;
        }
    }

    _playCurrentTrack() {
        this._playerClient.play(this.currentTrack);
    }

    _setTrackList() {
        const pastTracksToRemove = this._currentTrackIndex - this._pastTracksAmountToKeep;
        if (pastTracksToRemove > 0) {
            this._currentTrackList = this._currentTrackList.slice(pastTracksToRemove);
            this._currentTrackIndex = this._currentTrackIndex - pastTracksToRemove;
        }
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

    get trackList() {
        return this._currentTrackList;
    }
}
