import QueueItem from "./QueueItem";

export default class QueueController {

    constructor() {
        this._queue = [];
        this._currentIndex = 0;
    }

    setActiveTrack(track) {
        this._currentIndex = this._queue.findIndex(queueItem => queueItem.track.id === track.id);
    }

    addTrackToQueue(track) {
        let index = this._findNextSlotForTrackToQueue();
        this._insertTrack(index, new QueueItem(track, true));
    }

    _findNextSlotForTrackToQueue() {
        let index = this._currentIndex + 1;
        while (this._queue[index].isQueued) {
            index++;
        }
        return index;
    }

    _insertTrack(index, queueItem) {
        this._queue.splice(index, 0, queueItem);
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

    getQueuedTracks() {
        const queuedTracks = [];
        for (let i = 0; i < this._queue.length; i++) {
            console.log(this._queue[i]);
            if (this._queue[i].isQueued) {
                queuedTracks.push(this._queue[i]);
            } else {
                break;
            }
        }

        return queuedTracks;
    }

    setQueue(queue) {
        this._queue = queue.map(track => new QueueItem(track));
    }

    get currentTrack() {
        return this._queue[this._currentIndex].track;
    }
}
