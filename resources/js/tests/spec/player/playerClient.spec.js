import PlayerClient from "../../../store/modules/player/helpers/v2/playerClient";

let spotifyPlayWasCalled = false;

function spotifyProvider() {
    return {
        identifier: 'spotify',
        play() {
            spotifyPlayWasCalled = true;
        }
    }
}

describe('PlayerClient', () => {
    it('should call play on spotify provider for spotify track', () => {
        const client = new PlayerClient(spotifyProvider());

        client.play({provider: 'spotify'});

        expect(spotifyPlayWasCalled).toBe(true);
    });
});
