export default class QueueController {

    constructor() {
        this._queue = [];
        this._currentIndex = 0;
    }

    setActiveTrack(track) {
        this._currentIndex = this._queue.findIndex(queueTrack => queueTrack.id === track.id);
    }

    setNext() {
        if (this._currentIndex + 1 >= this._queue.length) {
            return;
        }

        this._currentIndex++;
    }

    setPrevious() {
        if (this._currentIndex - 1 < 0) {
            return;
        }

        this._currentIndex--;
    }

    set queue(queue) {
        this._queue = queue;
    }

    get currentTrack() {
        return this._queue[this._currentIndex];
    }
}
