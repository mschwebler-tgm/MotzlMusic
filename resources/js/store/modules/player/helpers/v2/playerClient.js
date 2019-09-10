export default class PlayerClient {

    constructor(...providers) {
        this._providers = providers;
        this._currentTrack = null;
        this.isLoading = false;
    }

    play(track) {
        this.isLoading = true;
        this._currentTrack = track;
        this.provider.play(track)
            .finally(() => this.isLoading = false);
    }

    pause() {
        this.provider.pause();
    }

    resume() {
        this.provider.resume();
    }

    addProvider(provider) {
        this._providers.push(provider);
    }

    get provider() {
        const trackProvider = this._providers.find(provider => provider.identifier === this._currentTrack.provider);
        if (!trackProvider) {
            throw new Error(`Provider "${this._currentTrack.provider}" not found. Track id: ${this._currentTrack.id}`);
        }

        return trackProvider;
    }
}
