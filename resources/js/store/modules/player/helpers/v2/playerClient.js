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

    seek(ms) {
        return this.provider.seek(ms);
    }

    addProvider(provider) {
        this._providers.push(provider);
    }

    get provider() {
        if (!this._currentTrack) {
            return null;
        }

        const trackProvider = this._providers.find(provider => provider.identifier === this._currentTrack.provider);
        if (!trackProvider) {
            throw new Error(`Provider "${this._currentTrack.provider}" not found. Track id: ${this._currentTrack.id}`);
        }

        return trackProvider;
    }

    get progress() {
        return this.provider ? this.provider.progress : 0;
    }

    get progressPercent() {
        return this.provider ? this.provider.progressPercent : 0;
    }
}
