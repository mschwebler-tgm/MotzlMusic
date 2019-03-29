import SpotifyPlayer from "./spotifyPlayer";

export default class PlayerController {

    constructor($store) {
        this.$store = $store;
        this.spotifyPlayer = new SpotifyPlayer($store);
    }

    play(track) {
        if (track.type === 'spotify') {
            this.spotifyPlayer.play(track);
        }
        this.$store.commit('player/setPlayingTrack', track);
    }
};
