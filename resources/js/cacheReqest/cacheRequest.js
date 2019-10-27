class CacheRequest {
    constructor() {
        this.initCache()
    }

    initCache() {
        this._cachedTracks = {};
    }

    addTracks(...tracks) {
        tracks.forEach(track => {
            if (!this._cachedTracks[track.id]) {
                this._cachedTracks[track.id] = track;
            }
        });
    }

    getTrack(id) {
        return Promise.resolve(this._cachedTracks[id]);
    }

    getTracks(ids) {
        return Promise.resolve(ids.map(id => this._cachedTracks[id]));
    }
}

export default new CacheRequest();
