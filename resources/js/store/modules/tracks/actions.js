import app from '../../../app';

export default {
    init() {
    },
    rateTrack({commit}, {track, rating}) {
        axios.put(`/api/track/${track.id}/rate`, {rating})
            .then(() => commit('setTrackRating', {track, rating}))
            .catch(err => app.showAlert('Failed to rate track!'));
    }
}
