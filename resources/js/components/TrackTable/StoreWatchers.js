import {Clusterizer, MobileClusterizer} from "../../store/modules/myLibrary/helpers/clusterizeTracks";
import player from "../../store/modules/player/helpers/v2/player";
import app from "$components/app";

const handleTrackRatingChange = function (payload) {
    const clusterizerClass = app.isMobile ? MobileClusterizer : Clusterizer;
    const track = payload.track;
    const trackElement = this.findElementByTrackId(track.id);
    if (trackElement) {
        trackElement.querySelector('.track-list-rating').innerHTML = clusterizerClass._rowRating(track);
    }
};

const handleTrackQueueIndicators = function (payload) {
    const clusterizerClass = app.isMobile ? MobileClusterizer : Clusterizer;
    _removeExtraInfoFromTrack.apply(this, [payload]);
    const queuedTracks = player.queuedTracks;
    queuedTracks.forEach((track, index) => {
        const trackTitleElement = this.findElementByTrackId(track.id).querySelector('.track-list-title');
        trackTitleElement.innerHTML = clusterizerClass._rowTitle(track.name, `[${index + 1}]`);
    });
};

const _removeExtraInfoFromTrack = function (track) {
    const clusterizerClass = app.isMobile ? MobileClusterizer : Clusterizer;
    console.log(clusterizerClass, clusterizerClass._rowTitle);
    const trackElement = this.findElementByTrackId(track.id);
    trackElement.querySelector('.track-list-title').innerHTML = clusterizerClass._rowTitle(track.name);
};

const handlerByMutation = {
    'tracks/setTrackRating': handleTrackRatingChange,
    'player/addTrackToQueue': handleTrackQueueIndicators,
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
