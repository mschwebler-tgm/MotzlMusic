export default class MemoryCache {
    constructor() {
        this.init();
    }

    init() {
        this._tracks = {};
        this._audioAnalytics = {};
        this._albums = {};
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

    putAudioAnalytics(analytics) {
        this._audioAnalytics[analytics.track_id] = analytics;
        return Promise.resolve();
    }

    getAudioAnalytics(trackId) {
        return Promise.resolve(this._audioAnalytics[trackId]);
    }

    getAlbum(id) {
        return Promise.resolve(this._albums[id]);
    }

    putAlbum(album) {
        this._albums[album.id] = album;
        return Promise.resolve();
    }
}
