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

    playNext() {
        if (this._currentIndex + 1 >= this._queue.length) {
            return;
        }

        this._currentIndex++;
        return this._queue[this._currentIndex];
    }

    playPrevious() {
        if (this._currentIndex - 1 < 0) {
            return;
        }

        this._currentIndex--;
        return this._queue[this._currentIndex];
    }
}
