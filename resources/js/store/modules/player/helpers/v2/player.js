import PlayerClient from "./playerClient";

export default class Player {

    constructor(playerClient) {
        this._playerClient = playerClient || new PlayerClient();
        this._currentTrackList = [];
        this._playingTrackIndex = 0;
    }

    playList(tracks = [], startIndex = 0) {
        this._currentTrackList = tracks;
        this._playingTrackIndex = startIndex;
        this._playerClient.play(this.currentTrack);
    }

    get currentTrack() {
        return this._currentTrackList[this._playingTrackIndex];
    }
}
