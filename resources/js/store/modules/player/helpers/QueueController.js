export default class QueueController {

    constructor() {
        this._queue = [];
        this._currentIndex = 0;
    }

    setActiveTrack(track) {
        this._currentIndex = this._queue.findIndex(queueTrack => queueTrack.id === track.id);
    }

    addTrackToQueue(track) {
        console.log(track);
        track.isQueued = true;
        let index = this._findNextSlotForTrackToQueue();
        this._insertTrack(index, track);
    }

    _findNextSlotForTrackToQueue() {
        let index = this._currentIndex + 1;
        while (this._queue[index].isQueued) {
            index++;
        }
        return index;
    }

    _insertTrack(index, track) {
        this._queue.splice(index, 0, track);
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
        this._queue = [...queue];
    }

    get currentTrack() {
        return this._queue[this._currentIndex];
    }
}
