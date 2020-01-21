<script>
    import SpotifyProvider from "$store/player/helpers/v2/providers/SpotifyProvider";
    import player from '$store/player/helpers/v2/player';

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
                            },
                            volume: parseInt(localStorage.getItem('volume')) / 100 || .5,
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
                    });
                }
            },
        }
    }
</script>
