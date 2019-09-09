export default class Track {

    constructor(trackData, isQueued) {
        this.trackData = trackData;
        this.isQueued = isQueued;
    }

    get provider() {
        return this.trackData.provider;
    }

}
