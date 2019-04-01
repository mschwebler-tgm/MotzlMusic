export default class SpotifyPlayer {

    constructor($store) {
        this.$store = $store;
        this.deviceId = null;  // is set from SpotifyPlayer.vue
    }

    play(track) {
        return axios.put('/api/player/spotify/playTrack', {device_id: this.deviceId, track_id: track.spotify_id});
    }
}
