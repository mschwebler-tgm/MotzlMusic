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
        return this.cache.getTracks(ids);
    }
}

export {CacheRequest};
export default new CacheRequest(new Cache(), new RequestClient());
