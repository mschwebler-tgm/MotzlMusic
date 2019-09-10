import PlayerClient from "./playerClient";
import Track from "./Track";
import SpotifyProvider from "./providers/SpotifyProvider";

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

const player = new Player(new PlayerClient(new SpotifyProvider()));
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

export default playerProxy;
