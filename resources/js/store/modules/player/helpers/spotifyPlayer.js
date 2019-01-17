export default class SpotifyPlayer {

    constructor($store) {
        this.$store = $store;
        this.deviceId = null;  // is set from SpotifyPlayer.vue
    }

    play(track) {
        this.$store.dispatch('player/spotifyPlayTrack', {id: track.spotify_id, deviceId: this.deviceId});
    }
}
