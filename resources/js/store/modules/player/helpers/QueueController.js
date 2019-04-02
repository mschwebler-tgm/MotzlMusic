export default class QueueController {

    constructor() {
        this._queue = [];
        this._currentIndex = 0;
    }

    set queue(queue) {
        this._queue = queue;
    }

    setActiveTrack(track) {
        this._currentIndex = this._queue.findIndex(queueTrack => queueTrack.id === track.id);
    }
}
