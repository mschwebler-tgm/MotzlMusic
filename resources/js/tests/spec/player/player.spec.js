import {Player, playerProxy} from '$store/player/helpers/v2/player';

const spotifyProviderMock = {
    identifier: 'spotify',
    play() {
        return new Promise(resolve => resolve());
    }
};
playerProxy.addProvider(spotifyProviderMock);

let playWasCalled = false;
let pauseWasCalled = false;
let resumeWasCalled = false;
let trackToPlay = null;

function preparePlayer() {
    playWasCalled = false;
    pauseWasCalled = false;
    resumeWasCalled = false;
    trackToPlay = null;
    const playerClient = {
        play(track) {
            playWasCalled = true;
            trackToPlay = track;
        },
        pause() {
            pauseWasCalled = true;
        },
        resume() {
            resumeWasCalled = true;
        }
    };

    return new Player(playerClient);
}

describe('Player', () => {
    it('should set list of tracks with starting index', () => {
        const player = preparePlayer();

        player.playList([1, 2, 3], 1);

        const currentTrack = player.currentTrack;
        expect(currentTrack).toBe(2);
    });

    it('should dispatch play request for second track', () => {
        const player = preparePlayer();

        player.playList([1, 2, 3], 1);

        expect(playWasCalled).toBe(true);
        expect(trackToPlay).toBe(2);
    });

    it('should set next track to current track', () => {
        const player = preparePlayer();
        player.playList([1, 2, 3], 1);
        playWasCalled = false;

        player.playNext();

        const currentTrack = player.currentTrack;
        expect(currentTrack).toBe(3);
        expect(trackToPlay).toBe(3);
        expect(playWasCalled).toBe(true);
    });

    it('should do nothing if last track is played and play next is called', () => {
        const player = preparePlayer();
        player.playList([1, 2, 3], 2);
        playWasCalled = false;
        trackToPlay = null;

        player.playNext();

        const currentTrack = player.currentTrack;
        expect(currentTrack).toBe(3);
        expect(trackToPlay).toBeNull();
        expect(playWasCalled).toBe(false);
    });

    it('should dispatch pause request to player client', () => {
        const player = preparePlayer();
        player.playList([1, 2, 3]);

        player.pause();

        expect(pauseWasCalled).toBe(true);
        expect(player.isPaused).toBe(true);
    });

    it('should dispatch resume request to player client', () => {
        const player = preparePlayer();
        player.playList([1, 2, 3]);

        player.pause();
        player.resume();

        expect(pauseWasCalled).toBe(true);
        expect(resumeWasCalled).toBe(true);
        expect(player.isPaused).toBe(false);
    });

    it('should return track list', () => {
        const player = preparePlayer();
        player.playList([1, 2, 3], 0);

        const trackList = player.trackList;

        expect(trackList.length).toBe(3);
        expect(trackList[0]).toBe(1);
    });

    it('should only keep specific amount of past tracks in list', () => {
        const player = preparePlayer();
        player._pastTracksAmountToKeep = 3;
        player.playList([1, 2, 3, 4, 5, 6, 7, 8], 4);

        const trackList = player.trackList;

        expect(trackList.length).toBe(7);
        expect(trackList[0]).toBe(2);
        expect(trackList[1]).toBe(3);
        expect(trackList[2]).toBe(4);
        expect(player.currentTrack).toBe(5);
    });

    it('should only keep specific amount of past tracks in list: end of list', () => {
        const player = preparePlayer();
        player._pastTracksAmountToKeep = 3;
        player.playList([1, 2, 3, 4, 5, 6, 7, 8], 7);

        const trackList = player.trackList;

        expect(trackList.length).toBe(4);
        expect(trackList[0]).toBe(5);
        expect(trackList[1]).toBe(6);
        expect(trackList[2]).toBe(7);
        expect(player.currentTrack).toBe(8);
    });

    it('play track immediately without loosing current track list', () => {
        const player = preparePlayer();
        player.playList([1, 2, 3], 1);
        playWasCalled = false;

        player.playTrackImmediately(100);

        expect(playWasCalled).toBe(true);
        expect(player.currentTrack).toBe(100);
        expect(player.trackList[2]).toBe(100);
    });

    it('should queue track', () => {
        const player = preparePlayer();
        player.playList([1, 2, 3], 1);

        player.queueTrack(101);

        expect(player.trackList[2]).toBe(101);
        expect(player.queuedTracks[0]).toBe(101);
    });

    it('should queue multiple tracks', () => {
        const player = preparePlayer();
        player.playList([1, 2, 3], 1);
        player.queueTrack({id: 101});
        player.queueTrack({id: 102});

        expect(player.queuedTracks.length).toBe(2);
    });

    it('should set queue index on tracks', () => {
        const player = preparePlayer();
        player.playList([{id: 1}, {id: 2}]);
        player.queueTrack({id: 101});
        player.queueTrack({id: 102});

        expect(player.trackListRaw[1].queueIndex).toBe(0);
        expect(player.trackListRaw[2].queueIndex).toBe(1);
    });

    it('should play queued track', () => {
        const player = preparePlayer();
        player.playList([1, 2, 3], 1);
        player.queueTrack(101);

        player.playNext();

        expect(player.currentTrack).toBe(101);
    });

    it('should not queue track if it is queued already', () => {
        const player = preparePlayer();
        player.playList([1, 2, 3], 1);

        player.queueTrack({id: 101});
        player.queueTrack({id: 102});
        player.queueTrack({id: 101});

        expect(player.queuedTracks).toEqual([{id: 101}, {id: 102}]);
    });

    it('should un-queue track if it is queued last and queued again', () => {
        const player = preparePlayer();
        player.playList([1, 2, 3], 1);

        player.queueTrack({id: 101});
        player.queueTrack({id: 101});

        expect(player.queuedTracks).toEqual([]);
    });

    it('should unmark queued track when being played', () => {
        const player = preparePlayer();
        player.playList([1, 2, 3], 1);
        player.queueTrack(101);

        player.playNext();

        expect(player.currentTrack).toBe(101);
        expect(player.queuedTracks.length).toBe(0);
    });

    it('should emit event when track is queued', () => {
        let queuedTrack = null;
        playerProxy.playList([{id: 1, provider: 'spotify'}]);

        playerProxy.on('queueTrack', track => queuedTrack = track);
        playerProxy.queueTrack({id: 101, provider: 'spotify'});

        expect(queuedTrack.id).toBe(101);
    });

    it('should not emit event when accessing a getter property', () => {
        let callbackWasExecuted = false;
        playerProxy.playList([{id: 1, provider: 'spotify'}]);

        playerProxy.on('currentTrack', () => callbackWasExecuted = true);
        playerProxy.currentTrack;

        expect(callbackWasExecuted).toBe(false);
    });

    it('should not emit event when accessing a getter property', () => {
        let callbackWasExecuted = false;
        playerProxy.playList([{id: 1, provider: 'spotify'}]);

        playerProxy.on('on', () => callbackWasExecuted = true);
        playerProxy.on('test', () => {
        });

        expect(callbackWasExecuted).toBe(false);
    });

    it('should only listen once to an event', () => {
        let callAmount = 0;
        playerProxy.playList([{id: 1, provider: 'spotify'}]);

        playerProxy.once('queueTrack', () => callAmount++);
        playerProxy.queueTrack({id: 101, provider: 'spotify'});
        playerProxy.queueTrack({id: 102, provider: 'spotify'});

        expect(callAmount).toBe(1);
    });

    it('should add provider', () => {
        let providerWasCalled = false;
        const providerIdentifier = 'customProvider';
        playerProxy.addProvider({
            identifier: providerIdentifier,
            play() {
                providerWasCalled = true;
                return Promise.resolve();
            }
        });
        playerProxy.playList([{id: 1, provider: providerIdentifier}]);

        expect(providerWasCalled).toBe(true);
    });
});
