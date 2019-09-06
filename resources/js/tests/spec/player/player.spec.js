import Player from '$store/player/helpers/v2/player';

describe('Player', () => {
    it('should set list of tracks with starting index', () => {
        const player = new Player();

        player.playList([1, 2, 3], 1);

        const currentTrack = player.playingTrack;
        expect(currentTrack).toBe(2);
    });
});
