import PlayerClient from "./playerClient";
import Track from "./Track";

const DEBUG = true;
const KEEP_PAST_TRACKS = 15;
const LISTENER_BLACKLIST = ['on'];

export class Player {

    constructor(playerClient) {
        this._playerClient = playerClient || new PlayerClient();
        this._currentTrackList = [];
        this._currentTrackIndex = 0;
        this._isPlaying = true;
        this._pastTracksAmountToKeep = KEEP_PAST_TRACKS;
        this._onListeners = {};
        this._onceListeners = {};
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
        if (this._currentTrackList.length === 0) {
            this._currentTrackList = [new Track(track)];
            this._currentTrackIndex = 0;
        } else {
            this._insertTrackAfter(this._currentTrackIndex, new Track(track));
            this._currentTrackIndex++;
        }
        this._setTrackList();
        this._playCurrentTrack();
    }

    queueTrack(track) {
        let index = this._currentTrackIndex + 1;
        while (index < this._currentTrackList.length) {
            if (!this._currentTrackList[index].isQueued) {
                this._insertTrackAfter(index - 1, new Track(track, true));
                return true;
            }
            index++;
        }

        return false;
    }

    on(property, callback) {
        if (LISTENER_BLACKLIST.includes(property)) {
            return;
        }
        if (!this._onListeners[property]) {
            this._onListeners[property] = [];
        }
        this._onListeners[property].push(callback);
    }

    once(property, callback) {
        if (LISTENER_BLACKLIST.includes(property)) {
            return;
        }
        if (!this._onceListeners[property]) {
            this._onceListeners[property] = [];
        }
        this._onceListeners[property].push(callback);
    }

    addProvider(provider) {
        this._playerClient.addProvider(provider);
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
        this._updateActiveClasses(currentTrack);
    }

    _updateActiveClasses(currentTrack) {
        const oldTrackRows = [...document.getElementsByClassName('track')];
        oldTrackRows.forEach($row => $row.classList.remove('active'));
        const trackRows = [...document.getElementsByClassName(`track-row-${currentTrack.trackData.id}`)];
        trackRows.forEach($row => $row.classList.add('active'));
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
        return this._currentTrackList[this._currentTrackIndex] ?
            this._currentTrackList[this._currentTrackIndex].trackData : null;
    }

    get currentTrackId() {
        return this.currentTrack ? this.currentTrack.id : null;
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

    get isLoading() {
        return this._playerClient.isLoading;
    }

    get progress() {
        return this._playerClient.progress;
    }

    get progressPercent() {
        return this._playerClient.progressPercent;
    }
}

function _log(msg) {
    DEBUG && console.log('[Player] ' + msg);
}

const player = new Player(new PlayerClient());
let handler = {
    get: function (playerObj, propKey) {
        const origMethod = playerObj[propKey];
        return function (...args) {
            processOnListeners(args);
            processOnceListeners(args);
            return origMethod.apply(playerObj, args);
        };

        function processOnListeners(args) {
            const onListeners = playerObj._onListeners[propKey];
            if (onListeners) {
                executeCallbacks(onListeners, args);
            }
        }

        function processOnceListeners(args) {
            const onceListeners = playerObj._onceListeners[propKey];
            if (onceListeners) {
                executeCallbacks(onceListeners, args);
                playerObj._onceListeners[propKey] = [];
            }
        }

        function executeCallbacks(onListeners, args) {
            onListeners.forEach(callback => callback(...args));
        }
    }
};

/** @type Player */
const playerProxy = new Proxy(player, handler);

export default player;
export {playerProxy};
