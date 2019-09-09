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
        return this._providers.find(provider => provider.identifier === track.provider);
    }
}
