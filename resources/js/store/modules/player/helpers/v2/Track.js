export default class Track {

    constructor(trackData, isQueued) {
        this._trackData = trackData;
        this._isQueued = isQueued;
    }

    get trackData() {
        return this._trackData;
    }

    get isQueued() {
        return this._isQueued;
    }
}
