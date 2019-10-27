import Cache from "$scripts/cacheReqest/Cache";
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

    addTracks(...tracks) {
        tracks.forEach(track => {
            this.cache.putTrack(track);
        });
    }

    async getTrack(id) {
        const cachedTrack = await this.cache.getTrack(id);
        if (cachedTrack) {
            return cachedTrack;
        } else {
            const track = await this.requestClient.fetchTrack(id);
            this.cache.putTrack(track);
            return track;
        }
    }

    async getTracks(ids) {
        const tracks = await this.cache.getTracks(ids);
        if (tracks.length === ids.length) {
            return tracks;
        } else {
            const remainingIds = this._getMissingIds(ids, tracks);
            const fetchedTracks = await this.requestClient.fetchTracks(remainingIds);
            this.cache.putTracks(fetchedTracks);
            return this.cache.getTracks(ids);
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
export default new CacheRequest(new Cache(), new RequestClient());
