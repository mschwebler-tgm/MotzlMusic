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

                        // Playback status updates
                        player.addListener('player_state_changed', state => console.log(state));

                        // Ready
                        player.addListener('ready', ({device_id}) => {
                            console.log('Ready with Device ID', device_id);
                        });

                        // Not Ready
                        player.addListener('not_ready', ({device_id}) => {
                            console.log('Device ID has gone offline', device_id);
                        });

                        player.connect();
                        this.player = player;
                    });
                }
            }
        }
    }
</script>