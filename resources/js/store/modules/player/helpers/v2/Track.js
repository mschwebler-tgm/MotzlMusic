export default class Track {

    constructor(trackData, isQueued, queueIndex) {
        this.trackData = trackData;
        this.isQueued = isQueued;
        this.queueIndex = queueIndex;
    }

    get provider() {
        return this.trackData.provider;
    }

}
