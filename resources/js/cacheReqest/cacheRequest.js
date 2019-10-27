import Cache from "$scripts/cacheReqest/Cache";

class CacheRequest {
    /**
     * @param cache Cache
     */
    constructor(cache) {
        this.cache = cache;
    }

    resetCache() {
        delete this.cache;
        this.cache = new Cache();
    }

    addTracks(...tracks) {
        tracks.forEach(track => {
            this.cache.putTrack(track);
        });
    }

    getTrack(id) {
        return this.cache.getTrack(id);
    }

    getTracks(ids) {
        return this.cache.getTracks(ids);
    }
}

export default new CacheRequest(new Cache());
