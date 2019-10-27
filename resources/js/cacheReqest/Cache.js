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
        return Promise.resolve();
    }

    putTracks(tracks) {
        tracks.forEach(track => this.putTrack(track));
        return Promise.resolve();
    }

    getTrack(id) {
        return Promise.resolve(this._tracks[id]);
    }

    getTracks(ids) {
        const tracks = [];
        ids.forEach(id => {
            if (this._tracks[id]) {
                tracks.push(this._tracks[id]);
            }
        });
        return Promise.resolve(tracks);
    }
}
