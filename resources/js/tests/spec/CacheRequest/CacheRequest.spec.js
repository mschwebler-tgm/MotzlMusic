import {CacheRequest} from '$scripts/cacheReqest/cacheRequest';
import MemoryCache from '$scripts/cacheReqest/Cache';

describe('CacheRequest', () => {
    let cacheRequest;
    beforeEach(() => {
        cacheRequest = new CacheRequest(new MemoryCache());
    });

    it('should return cached track as Promise', async done => {
        const track = {id: 1};
        cacheRequest.cacheTracks(track);

        const retrievedTrack = await cacheRequest.getTrack(1);

        expect(retrievedTrack).toBe(track);
        done();
    });

    it('should not add track twice', async done => {
        const name = 'track name';
        const track = {id: 1, name};
        cacheRequest.cacheTracks(track);
        cacheRequest.cacheTracks({id: 1, name: 'other name'});

        const retrievedTrack = await cacheRequest.getTrack(1);

        expect(retrievedTrack.name).toBe(name);
        done();
    });

    it('should return cached tracks as Promise', async done => {
        const track1 = {id: 1};
        const track2 = {id: 2};
        cacheRequest.cacheTracks(track1, track2);

        const retrievedTracks = await cacheRequest.getTracks([1, 2]);

        expect(retrievedTracks[0]).toBe(track1);
        expect(retrievedTracks[1]).toBe(track2);
        done();
    });

    describe('Fetching data', () => {
        let fetchedTracks = [];
        const clientMock = {
            fetchTrack(id) {
                fetchedTracks = [id];
                return Promise.resolve({id});
            },
            fetchTracks(ids) {
                fetchedTracks = ids;
                return Promise.resolve(ids.map(id => ({id})));
            }
        };
        beforeEach(() => {
            fetchedTracks = [];
            cacheRequest = new CacheRequest(new MemoryCache(), clientMock);
        });

        it('should fetch track if it is not present in cache', async done => {
            await cacheRequest.getTrack(1);

            expect(fetchedTracks[0]).toBe(1);
            done();
        });

        it('should not fetch track if it is present in cache', async done => {
            await cacheRequest.getTrack(1);
            fetchedTracks = [];
            await cacheRequest.getTrack(1);

            expect(fetchedTracks.length).toBe(0);
            done();
        });

        it('should fetch multiple tracks at once if not present in cache', async done => {
            const tracks = await cacheRequest.getTracks([1, 2, 3]);

            expect(fetchedTracks.join(',')).toBe('1,2,3');
            expect(tracks.map(track => track.id).join(',')).toBe('1,2,3');
            done();
        });

        it('should fetch only fetch remaining tracks that are not present in cache', async done => {
            await cacheRequest.getTrack(1);
            fetchedTracks = [];
            const tracks = await cacheRequest.getTracks([1, 2, 3]);

            expect(fetchedTracks.join(',')).toBe('2,3');
            expect(tracks.map(track => track.id).join(',')).toBe('1,2,3');
            done();
        });

    });
});
