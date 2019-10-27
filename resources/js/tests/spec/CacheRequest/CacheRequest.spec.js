import cacheRequest from '$scripts/cacheReqest/cacheRequest';

describe('CacheRequest', () => {
    it('should return cached track as Promise', async done => {
        const track = {id: 1};
        cacheRequest.addTracks(track);

        const retrievedTrack = await cacheRequest.getTrack(1);

        expect(retrievedTrack).toBe(track);
        done();
    });
});
