export default class SpotifyPlayer {

    constructor($store) {
        this.$store = $store;
        this.deviceId = null;  // is set from SpotifyPlayer.vue
    }

    play(track) {
        return this.$store.dispatch('player/spotifyPlayTrack', {trackId: track.spotify_id, deviceId: this.deviceId});
    }
}
