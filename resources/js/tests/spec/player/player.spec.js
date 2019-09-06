import Player from '$store/player/helpers/v2/player';

describe('Player', () => {
    it('should set list of tracks with starting index', () => {
        const player = new Player();

        player.playList([1, 2, 3], 1);

        const currentTrack = player.currentTrack;
        expect(currentTrack).toBe(2);
    });

    it('should dispatch play request for second track', () => {
        let playWasCalled = false;
        let trackToPlay = null;
        const playerClient = {
            play(track) {
                playWasCalled = true;
                trackToPlay = track;
            }
        };
        const player = new Player(playerClient);

        player.playList([1, 2, 3], 1);

        expect(playWasCalled).toBe(true);
        expect(trackToPlay).toBe(2);
    });
});
