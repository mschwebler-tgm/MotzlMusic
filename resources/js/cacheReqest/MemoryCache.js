export default class MemoryCache {
    constructor() {
        this.init();
    }

    init() {
        this._tracks = {};
        this._audioAnalyticsByUrl = {};
        this._albums = {};
        this._artists = {};
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

    putAudioAnalytics(url, analytics) {
        this._audioAnalyticsByUrl[url] = analytics;
        return Promise.resolve();
    }

    getAudioAnalytics(url) {
        return Promise.resolve(this._audioAnalyticsByUrl[url]);
    }

    getAlbum(id) {
        return Promise.resolve(this._albums[id]);
    }

    getAlbums(ids) {
        const albums = [];
        ids.forEach(id => {
            if (this._albums[id]) {
                albums.push(this._albums[id]);
            }
        });
        return Promise.resolve(albums);
    }

    putAlbum(album) {
        this._albums[album.id] = album;
        return Promise.resolve();
    }

    putAlbums(albums) {
        albums.forEach(album => this.putAlbum(album));
        return Promise.resolve();
    }

    getArtist(id) {
        return Promise.resolve(this._artists[id]);
    }

    getArtists(ids) {
        const artists = [];
        ids.forEach(id => {
            if (this._artists[id]) {
                artists.push(this._artists[id]);
            }
        });
        return Promise.resolve(artists);
    }

    putArtist(artist) {
        this._artists[artist.id] = artist;
        return Promise.resolve();
    }

    putArtists(albums) {
        albums.forEach(artists => this.putArtist(artists));
        return Promise.resolve();
    }
}
