import Track from "../../../store/modules/player/helpers/v2/Track";

describe('Track', () => {
    it('should return internal provider for track', () => {
        const provider = 'testProvider';
        const track = new Track({provider});

        const trackProvider = track.provider;

        expect(trackProvider).toBe(provider);
    });
});
