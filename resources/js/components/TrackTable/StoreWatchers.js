import {Clusterizer} from "../../store/modules/myLibrary/helpers/clusterizeTracks";

const handleTrackRatingChange = function (payload) {
    const track = payload.track;
    const trackElement = this.findElementByTrackId(track.id);
    if (trackElement) {
        trackElement.querySelector('.track-list-rating').innerHTML = Clusterizer._rowRating(track);
    }
};

const handleTrackQueueIndicators = function (payload, state) {
    _removeExtraInfoFromTrack.apply(this, [payload]);
    const queuedTracks = state.player.queueController.getQueuedTracks();
    queuedTracks.forEach((track, index) => {
        const trackTitleElement = this.findElementByTrackId(track.id).querySelector('.track-list-title');
        trackTitleElement.innerHTML = Clusterizer._rowTitle(track.name, `[${index + 1}]`);
    });
};

const _removeExtraInfoFromTrack = function (track) {
    const trackElement = this.findElementByTrackId(track.id);
    trackElement.querySelector('.track-list-title').innerHTML = Clusterizer._rowTitle(track.name);
};

const handlerByMutation = {
    'tracks/setTrackRating': handleTrackRatingChange,
    'player/addTrackToQueue': handleTrackQueueIndicators,
    'player/setPlayingTrack': handleTrackQueueIndicators,
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
