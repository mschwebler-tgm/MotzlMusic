import player from '$store/player/helpers/v2/player';

export default {
    computed: {
        playing() {
            return player.isPlaying;
        },
        trackDuration() {
            return this.currentTrack ? this.currentTrack.duration : 0;
        },
        noNextTrack() {
            return !player.canPlayNext;
        },
        noPreviousTrack() {
            return !player.canPlayPrevious;
        },
        loading() {
            return player.isLoading;
        },
        currentTrack() {
            return player.currentTrack;
        },
        title() {
            return this.currentTrack ? this.currentTrack.name : 'No track';
        },
        artists() {
            return this.currentTrack ? this.currentTrack.artists.map(artist => artist.name).join(', ') : '-';
        },
    },
    methods: {
        togglePlay() {
            if (this.playing) {
                player.pause();
            } else {
                player.resume();
            }
        },
        playNext() {
            player.playNext();
        },
        playPrevious() {
            player.playPrevious();
        },
    }
}
