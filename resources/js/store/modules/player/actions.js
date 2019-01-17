export default {
    init() {
    },

    spotifyPlayTrack({ commit }, {trackId, deviceId}) {
        axios.put('/api/player/spotify/playTrack', {device_id: deviceId, track_id: trackId});
    }
}
