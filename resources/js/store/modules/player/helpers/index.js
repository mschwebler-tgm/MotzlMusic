import SpotifyPlayer from "./spotifyPlayer";

export default class PlayerController {

    constructor($store) {
        this.$store = $store;
        this.spotifyPlayer = new SpotifyPlayer($store);
    }

    play(track) {
        if (track.is_spotify) {
            this.spotifyPlayer.play(track);
        }
    }
};
