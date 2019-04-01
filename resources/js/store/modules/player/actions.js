export default {
    init() {
    },
    play({ state, commit }, track) {
        commit('setLoading', true);
        state.playerController.play(track)
            .finally(() => commit('setLoading', false))
    },
    spotifyPlayTrack({ commit }, {trackId, deviceId}) {
        return axios.put('/api/player/spotify/playTrack', {device_id: deviceId, track_id: trackId});
    }
}
