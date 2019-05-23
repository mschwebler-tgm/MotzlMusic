<script>
    export default {
        name: "SpotifyPlayer",
        data() {
            return {
                player: null
            }
        },
        render() {},
        created() {
            this.initWebPlayerSDK();
        },
        methods: {
            initWebPlayerSDK() {
                window.onSpotifyWebPlaybackSDKReady = _ => {
                    axios.get('/api/spotify/access').then(res => {
                        const accessToken = res.data;
                        const player = new Spotify.Player({
                            name: 'MotzlMusic',
                            getOAuthToken: callback => {
                                callback(accessToken);
                            }
                        });

                        // Error handling
                        player.addListener('initialization_error', ({message}) => {
                            console.error(message);
                        });
                        player.addListener('authentication_error', ({message}) => {
                            console.error(message);
                        });
                        player.addListener('account_error', ({message}) => {
                            console.error(message);
                        });
                        player.addListener('playback_error', ({message}) => {
                            console.error(message);
                        });

                        // Ready
                        player.addListener('ready', ({device_id}) => {
                            // playback workaround https://github.com/spotify/web-playback-sdk/issues/75
                            const iframe = document.querySelector('iframe[src="https://sdk.scdn.co/embedded/index.html"]');
                            if (iframe) {
                                iframe.style.display = 'block';
                                iframe.style.position = 'absolute';
                                iframe.style.top = '-1000px';
                                iframe.style.left = '-1000px';
                            }

                            this.$store.getters['player/controller'].spotifyPlayer.deviceId = device_id;
                        });

                        // Not Ready
                        player.addListener('not_ready', ({device_id}) => {
                        });

                        player.connect();
                        this.player = player;
                        this.$store.commit('player/setSpotifyPlayer', this.player);
                    });
                }
            }
        }
    }
</script>