import PlayerClient from "./playerClient";
import Track from "./Track";

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
        this._currentTrackList = tracks.map(track => new Track(track));
        this._currentTrackIndex = startIndex;
        this._playCurrentTrack();
        this._setTrackList();
    }

    playNext() {
        if (this.canPlayNext) {
            _log('Tried to call playNext(), but end of track list was already reached.');
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

    playTrackImmediately(track) {
        this._insertTrackAfter(this._currentTrackIndex, new Track(track));
        this._currentTrackIndex++;
        this._setTrackList();
        this._playCurrentTrack();
    }

    queueTrack(track) {
        let index = this._currentTrackIndex;
        while (index < this._currentTrackList.length) {
            if (!this._currentTrackList[index].isQueued) {
                this._insertTrackAfter(index, new Track(track, true));
                break;
            }
            index++;
        }
    }

    _insertTrackAfter(index, track) {
        this._currentTrackList.splice(index + 1, 0, track);
    }

    _playCurrentTrack() {
        this._playerClient.play(this.currentTrack);
        const currentTrack = this._currentTrackList[this._currentTrackIndex];
        if (currentTrack.isQueued) {
            currentTrack.isQueued = false;
        }
    }

    _setTrackList() {
        const pastTracksToRemove = this._currentTrackIndex - this._pastTracksAmountToKeep;
        if (pastTracksToRemove > 0) {
            this._currentTrackList = this._currentTrackList.slice(pastTracksToRemove);
            this._currentTrackIndex = this._currentTrackIndex - pastTracksToRemove;
        }
    }

    get canPlayNext() {
        return this._currentTrackIndex + 1 >= this._currentTrackList.length;
    }

    get currentTrack() {
        return this._currentTrackList[this._currentTrackIndex].trackData;
    }

    get isPaused() {
        return !this._isPlaying;
    }

    get trackList() {
        return this._currentTrackList.map(track => track.trackData);
    }

    get queuedTracks() {
        return this._currentTrackList.filter(track => track.isQueued).map(track => track.trackData);
    }
}

function _log(msg) {
    DEBUG && console.log('[Player] ' + msg);
}
