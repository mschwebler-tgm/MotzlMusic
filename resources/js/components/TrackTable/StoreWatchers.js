import {Clusterizer} from "../../store/modules/myLibrary/helpers/clusterizeTracks";

const handleTrackRatingChange = function (payload) {
    const track = payload.track;
    const trackElement = this.findElementByTrackId(track.id);
    if (trackElement) {
        trackElement.querySelector('.track-list-rating').innerHTML = Clusterizer._rowRating(track);
    }
};

const handlerByMutation = {
    'tracks/setTrackRating': handleTrackRatingChange,
};

/**
 * this context refers to BaseTrackTable component
 * @param mutation vuex mutation
 */
export default function (mutation) {
    let handler = handlerByMutation[mutation.type];
    if (handler) {
        handler.apply(this, [mutation.payload]);
    }
};
