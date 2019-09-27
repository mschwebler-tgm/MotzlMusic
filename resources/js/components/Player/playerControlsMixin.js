import player from '$store/player/helpers/v2/player';
import { mapGetters } from 'vuex'

export default {
    data() {
        return {
            progressInterval: null,
            progressMs: 0,
        }
    },
    computed: {
        ...mapGetters({
            currentTrack: 'player/currentTrack',
            playing: 'player/playing',
            trackDuration: 'player/trackDuration',
            noNextTrack: 'player/noNextTrack',
            noPreviousTrack: 'player/noPreviousTrack',
            loading: 'player/loading',
            title: 'player/title',
            artists: 'player/artists',
            album: 'player/album',
            albumName: 'player/albumName',
            albumCover: 'player/albumCover',
            playerProgress: 'player/playerProgress',
            playerProgressPercent: 'player/playerProgressPercent',
            durationFormatted: 'player/durationFormatted',
        }),
        progress: {
            get() {
                return this.progressMs
            },
            set(milliseconds) {
                clearInterval(this.progressInterval);
                this.progressMs = milliseconds;
                player.seek(milliseconds).then(this.setProgressInterval);
            }
        },
        progressFormatted() {
            let seconds = Math.floor(this.progressMs / 1000);
            const minutes = Math.floor(seconds / 60);
            seconds = seconds - minutes * 60;

            seconds = seconds < 10 ? `0${seconds}` : seconds;

            return `${minutes}:${seconds}`;
        }
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
        setProgressInterval() {
            this.progressInterval = setInterval(() => this.progressMs += 100, 100);
        },
    },
    watch: {
        playing(playing) {
            if (playing) {
                this.setProgressInterval();
            } else {
                clearInterval(this.progressInterval);
            }
        },
        playerProgress(progress) {
            this.progressMs = progress;
        }
    },
}
