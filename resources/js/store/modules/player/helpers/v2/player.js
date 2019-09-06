import PlayerClient from "./playerClient";

export default class Player {

    constructor(playerClient) {
        this._playerClient = playerClient || new PlayerClient();
        this._currentTrackList = [];
        this._currentTrackIndex = 0;
    }

    playList(tracks = [], startIndex = 0) {
        this._currentTrackList = tracks;
        this._currentTrackIndex = startIndex;
        this._playCurrentTrack();
    }

    playNext() {
        this._currentTrackIndex++;
        this._playCurrentTrack();
    }

    _playCurrentTrack() {
        this._playerClient.play(this.currentTrack);
    }

    get currentTrack() {
        return this._currentTrackList[this._currentTrackIndex];
    }
}
