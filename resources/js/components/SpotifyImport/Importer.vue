<template>
    <div class="modal-card spotify">
        <header class="modal-card-head">
            <img src="/images/spotify_black.png" width="50px">
            <p class="modal-card-title">&nbsp;&nbsp;Import from Spotify</p>
        </header>
        <section class="modal-card-body">
            You can import your favourite tracks, albums and playlists from spotify.<br><br>
            <div class="field">
                <b-checkbox v-model="toImport" native-value="tracks">
                    Import saved tracks&nbsp;&nbsp;&nbsp;<span class="is-size-7" :class="_colorClass('tracks')" v-if="tracks.total">{{ tracks.total }} tracks</span>
                </b-checkbox>
            </div>
            <div class="field">
                <b-checkbox v-model="toImport" native-value="albums">
                    Import albums
                </b-checkbox>
            </div>
            <div class="field">
                <b-checkbox v-model="toImport" native-value="playlists">
                    Import playlists&nbsp;&nbsp;&nbsp;<span class="is-size-7" :class="_colorClass('playlists')" v-if="playlistTracksTotal">{{ playlistTracksTotal }} tracks in {{ playlists.total }} playlists</span>
                </b-checkbox>
            </div>
        </section>
        <footer class="modal-card-foot">
            <button class="button is-success">Import</button>
            <button class="button">Cancel</button>
            <span class="total-tracks has-text-spotify is-size-5">{{ animatedTotalTracksToImport }} tracks </span>
        </footer>
    </div>
</template>

<script>
    export default {
        name: "Importer",
        data() {
            return {
                tracks: {},
                playlists: {},
                toImport: [],
                totalTracksToImport: 0,
            }
        },
        created() {
            this.loadTracks();
            this.loadPlaylists();
        },
        methods: {
            loadTracks() {
                axios.get('/api/spotify/tracks/my').then(res => {
                    this.tracks = res.data;
                });
            },
            loadPlaylists() {
                axios.get('/api/spotify/playlists/my').then(res => {
                    this.playlists = {
                        items: res.data,
                        total: res.data.length
                    };
                });
            },
            _colorClass(toImport) {
                if (this.toImport.indexOf(toImport) !== -1) {
                    return 'has-text-spotify';
                }
                return 'has-text-grey';
            },
        },
        watch: {
            toImport() {
                let total = 0;
                if (this.willImportTracks) {
                    total += this.tracks.total;
                }
                if (this.willImportPlaylists) {
                    total += this.playlistTracksTotal;
                }
                TweenLite.to(this.$data, 0.5, { totalTracksToImport: Math.round(total) });
            }
        },
        computed: {
            animatedTotalTracksToImport() {
                return this.totalTracksToImport.toFixed(0);
            },
            willImportTracks() {
                return this.toImport.filter(item => item === 'tracks').length > 0;
            },
            willImportPlaylists() {
                return this.toImport.filter(item => item === 'playlists').length > 0;
            },
            willImportAlbums() {
                return this.toImport.filter(item => item === 'albums').length > 0;
            },
            playlistTracksTotal() {
                if (!this.playlists.items) {
                    return null;
                }
                return this.playlists.items.reduce((acc, item) => acc + item.tracks, 0);
            }
        }
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/_variables.scss";

    .total-tracks {
        margin-left: auto;
    }

</style>
