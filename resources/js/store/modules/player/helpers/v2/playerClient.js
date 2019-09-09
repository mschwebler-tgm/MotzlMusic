export default class PlayerClient {

    constructor(...providers) {
        this._providers = providers;
    }

    play(track) {
        const provider = this._getProviderFor(track);
        provider.play(track);
    }

    pause() {
        // TODO implement, test
    }

    resume() {

    }

    _getProviderFor(track) {
        const trackProvider = this._providers.find(provider => provider.identifier === track.provider);
        if (!trackProvider) {
            throw new Error(`Provider "${track.provider}" not found. Track id: ${track.id}`);
        }

        return trackProvider;
    }
}
