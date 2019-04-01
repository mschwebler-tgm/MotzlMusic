export default class SpotifyPlayer {

    constructor($store) {
        this.$store = $store;
        this.deviceId = null;  // is set from SpotifyPlayer.vue
        this._player = null;
    }

    play(track) {
        return axios.put('/api/player/spotify/playTrack', {device_id: this.deviceId, track_id: track.spotify_id});
    }

    set player(player) {
        this._player = player;
    }
}
