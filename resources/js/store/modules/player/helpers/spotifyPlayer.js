export default class SpotifyPlayer {

    constructor($store) {
        this.$store = $store;
    }

    play(track) {
        this.$store.dispatch('player/playSpotifyTrack');
    }
}
