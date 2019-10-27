import cacheRequest from '$scripts/cacheReqest/cacheRequest';

describe('CacheRequest', () => {
    beforeEach(() => {
        cacheRequest.resetCache();
    });

    it('should return cached track as Promise', async done => {
        const track = {id: 1};
        cacheRequest.addTracks(track);

        const retrievedTrack = await cacheRequest.getTrack(1);

        expect(retrievedTrack).toBe(track);
        done();
    });

    it('should return cached tracks as Promise', async done => {
        const track1 = {id: 1};
        const track2 = {id: 2};
        cacheRequest.addTracks(track1, track2);

        const retrievedTracks = await cacheRequest.getTracks([1, 2]);

        console.log(retrievedTracks);

        expect(retrievedTracks[0]).toBe(track1);
        expect(retrievedTracks[1]).toBe(track2);
        done();
    });
});
