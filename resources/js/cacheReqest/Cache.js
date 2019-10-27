export default class Cache {
    constructor() {
        this.init();
    }

    init() {
        this._tracks = {};
    }

    putTrack(track) {
        if (!this._tracks[track.id]) {
            this._tracks[track.id] = track;
        }
    }

    getTrack(id) {
        return Promise.resolve(this._tracks[id]);
    }

    getTracks(ids) {
        return Promise.resolve(ids.map(id => this._tracks[id]));
    }
}
