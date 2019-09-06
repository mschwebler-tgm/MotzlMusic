export default class Player {

    constructor() {
        this._currentTrackList = [];
        this._playingTrackIndex = 0;
    }

    playList(tracks = [], startIndex = 0) {
        this._currentTrackList = tracks;
        this._playingTrackIndex = startIndex;
    }

    get playingTrack() {
        return this._currentTrackList[this._playingTrackIndex];
    }
}
