import {Clusterizer} from "../../store/modules/myLibrary/helpers/clusterizeTracks";

const handleTrackRatingChange = function (payload) {
    const track = payload.track;
    const trackElement = this.findElementByTrackId(track.id);
    if (trackElement) {
        trackElement.querySelector('.track-list-rating').innerHTML = Clusterizer._rowRating(track);
    }
};

const handleTrackQueue = function (payload, state) {
    const queuedTracks = state.player.queueController.getQueuedTracks();
    queuedTracks.forEach((track, index) => {
        const trackTitleElement = this.findElementByTrackId(track.id).querySelector('.track-list-title');
        trackTitleElement.innerHTML = Clusterizer._rowTitle(track.name, `[${index + 1}]`);
    });
};

const handlerByMutation = {
    'tracks/setTrackRating': handleTrackRatingChange,
    'player/addTrackToQueue': handleTrackQueue,
};

/**
 * this context refers to BaseTrackTable component
 * @param mutation vuex mutation
 * @param state
 */
export default function (mutation, state) {
    let handler = handlerByMutation[mutation.type];
    if (handler) {
        handler.apply(this, [mutation.payload, state]);
    }
};
