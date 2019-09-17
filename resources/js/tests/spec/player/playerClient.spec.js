import PlayerClient from "../../../store/modules/player/helpers/v2/playerClient";

let spotifyPlayWasCalled = false;

function spotifyProvider() {
    return {
        identifier: 'spotify',
        play() {
            spotifyPlayWasCalled = true;
            return Promise.resolve();
        }
    }
}

describe('PlayerClient', () => {
    it('should call play on spotify provider for spotify track', () => {
        const client = new PlayerClient(spotifyProvider());

        client.play({provider: 'spotify'});

        expect(spotifyPlayWasCalled).toBe(true);
    });

    it('should throw error when no provider found', () => {
        const client = new PlayerClient();

        expect(() => client.play({id: 1, provider: 'iDoNotExist'}))
            .toThrow(new Error('Provider "iDoNotExist" not found. Track id: 1'));
    });
});
