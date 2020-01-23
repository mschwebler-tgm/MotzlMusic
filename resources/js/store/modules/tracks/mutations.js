import cacheRequest from "$scripts/cacheReqest/cacheRequest";

export default {
    setTrackRating: (state, {track, rating}) => {
        track.rating = rating;
        cacheRequest.getTrack(track.id).rating = rating;
    },
}
