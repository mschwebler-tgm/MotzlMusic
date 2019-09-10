<script>
    import SpotifyProvider from "../../../store/modules/player/helpers/v2/providers/SpotifyProvider";

    export default {
        name: "SpotifyPlayer",
        data() {
            return {
                spotifyPlayer: null,
                spotifyPlayerName: 'MotzlMusic',
            }
        },
        render() {},
        created() {
            this.initWebPlayerSDK();
        },
        methods: {
            whenReady(deviceId) {
                this.fixPlayerIFramePosition();
                this.setupSpotifyProvider(deviceId);
            },
            setupSpotifyProvider(deviceId) {
                const player = this.$store.getters['player/player'];
                const spotifyProvider = new SpotifyProvider(deviceId, this.spotifyPlayer);
                player.addProvider(spotifyProvider);
            },
            fixPlayerIFramePosition() {
                // playback workaround https://github.com/spotify/web-playback-sdk/issues/75
                const iframe = document.querySelector('iframe[src="https://sdk.scdn.co/embedded/index.html"]');
                iframe.setAttribute('title', 'Spotify player');
                if (iframe) {
                    iframe.style.display = 'block';
                    iframe.style.position = 'absolute';
                    iframe.style.top = '-1000px';
                    iframe.style.left = '-1000px';
                }
            },
            initWebPlayerSDK() {
                window.onSpotifyWebPlaybackSDKReady = _ => {
                    axios.get('/api/spotify/access').then(res => {
                        const accessToken = res.data;
                        this.spotifyPlayer = new Spotify.Player({
                            name: this.spotifyPlayerName,
                            getOAuthToken: callback => {
                                callback(accessToken);
                            }
                        });

                        // Error handling
                        this.spotifyPlayer.addListener('initialization_error', ({message}) => console.error(message));
                        this.spotifyPlayer.addListener('authentication_error', ({message}) => console.error(message));
                        this.spotifyPlayer.addListener('account_error', ({message}) => console.error(message));
                        this.spotifyPlayer.addListener('playback_error', ({message}) => console.error(message));

                        // Ready
                        this.spotifyPlayer.addListener('ready', ({device_id}) => this.whenReady(device_id));

                        // Not Ready
                        this.spotifyPlayer.addListener('not_ready', ({device_id}) => {
                        });

                        this.spotifyPlayer.connect();

                        this.$store.commit('player/setSpotifyPlayer', this.spotifyPlayer);
                    });
                }
            },
        }
    }
</script>
