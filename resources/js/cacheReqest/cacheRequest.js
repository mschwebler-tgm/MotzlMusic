import MemoryCache from "$scripts/cacheReqest/MemoryCache";
import RequestClient from "$scripts/cacheReqest/RequestClient";

class CacheRequest {
    /**
     * @param cache Cache
     * @param requestClient RequestClient
     */
    constructor(cache, requestClient) {
        this.cache = cache;
        this.requestClient = requestClient;
    }

    cacheTracks(...tracks) {
        return this.cache.putTracks(tracks);
    }

    async getTrack(id) {
        const cachedTrack = await this.cache.getTrack(id);
        if (cachedTrack) {
            return cachedTrack;
        } else {
            const track = await this.requestClient.fetchTrack(id);
            await this.cache.putTrack(track);
            return track;
        }
    }

    async getTracks(ids, fetchUrl = null) {
        const tracks = await this.cache.getTracks(ids);
        if (tracks.length === ids.length) {
            return tracks;
        } else {
            const remainingIds = this._getMissingIds(ids, tracks);
            const fetchedTracks = await this.requestClient.fetchTracks(remainingIds, fetchUrl);
            await this.cache.putTracks(fetchedTracks);
            return this.cache.getTracks(ids);
        }
    }

    async getAudioAnalyticsForTrackId(trackId) {
        const url = `/api/track/${trackId}/audio-features`;
        return this.getAudioAnalytics(url);
    }

    async getAudioAnalytics(url) {
        let audioAnalytics = await this.cache.getAudioAnalytics(url);
        if (audioAnalytics) {
            return audioAnalytics;
        } else {
            audioAnalytics = await this.requestClient.fetchAudioAnalytics(url);
            await this.cache.putAudioAnalytics(audioAnalytics);
            return audioAnalytics;
        }
    }

    async getAlbum(albumId) {
        const cachedAlbum = await this.cache.getAlbum(albumId);
        if (cachedAlbum) {
            return cachedAlbum;
        } else {
            const album = await this.requestClient.fetchAlbum(albumId);
            await this.cache.putAlbum(album);
            return album;
        }
    }

    async getAlbums(ids, fetchUrl) {
        const albums = await this.cache.getAlbums(ids);
        if (albums.length === ids.length) {
            return albums;
        } else {
            const remainingIds = this._getMissingIds(ids, albums);
            const fetchedAlbums = await this.requestClient.fetchAlbums(remainingIds, fetchUrl);
            await this.cache.putAlbums(fetchedAlbums);
            return this.cache.getAlbums(ids);
        }
    }

    async getArtist(artistId) {
        const cachedArtist = await this.cache.getArtist(artistId);
        if (cachedArtist) {
            return cachedArtist;
        } else {
            const artist = await this.requestClient.fetchArtist(artistId);
            await this.cache.putArtist(artist);
            return artist;
        }
    }

    async getArtists(ids, fetchUrl) {
        const artists = await this.cache.getArtists(ids);
        if (artists.length === ids.length) {
            return artists;
        } else {
            const remainingIds = this._getMissingIds(ids, artists);
            const fetchedArtists = await this.requestClient.fetchArtists(remainingIds, fetchUrl);
            await this.cache.putArtists(fetchedArtists);
            return this.cache.getArtists(ids);
        }
    }

    _getMissingIds(ids, objects) {
        const requestedIds = [...ids];
        objects.forEach(object => {
            let requestedIdIndex = requestedIds.indexOf(object.id);
            if (requestedIdIndex !== -1) {
                requestedIds.splice(requestedIdIndex, 1);
            }
        });
        return requestedIds;
    }
}

export {CacheRequest};
export default new CacheRequest(new MemoryCache(), new RequestClient());
