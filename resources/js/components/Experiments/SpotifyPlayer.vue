<template>
    <div class="wrapper">
        <div id="timestamp"
             :style="{left: progressBarPercent}"></div>
        <div class="sections" ref="sections">
            <div v-for="(sectionStyle, index) in sectionStyles"
                 :style="sectionStyle">
                {{ index }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SpotifyPlayer",
        data() {
            return {
                player: null,
                currentTrack: {},
                analysis: {},
                duration: 1,
                paused: true,
                position: 0,
                progressSetterInterval: null,
                sectionStyles: []
            }
        },
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
                        player.addListener('player_state_changed', state => this.handleStateChanged(state));

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
            },
            handleStateChanged(state) {
                const currentTrack = state.track_window.current_track;
                this.duration = state.duration;
                this.paused = state.paused;
                this.position = state.position;

                clearInterval(this.progressSetterInterval);
                if (!this.paused) {
                    // this.position += 1000;
                    this.progressSetterInterval = setInterval(_ => {
                        this.position += 100;
                    }, 100);
                }

                if (this.currentTrack.id !== currentTrack.id) {
                    this.currentTrack = currentTrack;
                    axios.get('/api/track/audio-analysis/' + currentTrack.id).then(res => {
                        this.sectionStyles = this.calcStyleForSections(res.data.sections);
                        console.log(this.sectionStyles);
                        // this.analysis = res.data;
                    });
                }
            },
            calcStyleForSections(sections) {
                return sections.map(section => {
                    return {
                        left: (section.start / this.duration * 100000) + '%',
                        width: (section.duration / this.duration * 100000) + '%',
                        'background-color': '#' + Math.floor(Math.random() * 16777215).toString(16)
                    };
                });
            }
        },
        computed: {
            progressBarPercent() {
                return (this.position / this.duration * 100) + '%';
            }
        }
    }
</script>

<style scoped>
    .wrapper {
        flex: 1;
        height: 100%;
        position: relative;
    }
    #timestamp {
        position: absolute;
        height: 100%;
        border-left: 1px solid black;
        z-index: 1;
    }
    .sections {
        position: relative;
        height: 100%;
    }
    .sections > div {
        position: absolute;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>