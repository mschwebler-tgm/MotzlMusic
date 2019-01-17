export default {
    init() {
    },
    play({ state }, track) {
        state.playerController.play(track);
    },
    spotifyPlayTrack({ commit }, {trackId, deviceId}) {
        axios.put('/api/player/spotify/playTrack', {device_id: deviceId, track_id: trackId});
    }
}
