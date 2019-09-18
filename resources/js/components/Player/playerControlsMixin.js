import player from '$store/player/helpers/v2/player';

export default {
    data() {
        return {
            progressInterval: null,
            progressMs: 0,
        }
    },
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
        albumCover() {
            if (!this.currentTrack || !this.currentTrack.album) {
                return window.playlistFallback;
            }

            return this.$root.getSpotifyImage(this.currentTrack.album, 'small');
        },
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
        playerProgress() {
            return player.progress;
        },
        durationFormatted() {
            return this.currentTrack ? this.currentTrack.duration_formatted : '-:-'
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
