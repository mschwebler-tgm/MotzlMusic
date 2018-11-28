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
                    Import saved tracks&nbsp;&nbsp;&nbsp;<span class="is-size-7" :class="_colorClass('tracks')">{{ tracks.total }} Tracks</span>
                </b-checkbox>
            </div>
            <div class="field">
                <b-checkbox v-model="toImport" native-value="albums">
                    Import albums
                </b-checkbox>
            </div>
            <div class="field">
                <b-checkbox v-model="toImport" native-value="playlists">
                    Import playlists&nbsp;&nbsp;&nbsp;<span class="is-size-7" :class="_colorClass('playlists')">{{ playlists.length }} Playlists</span>
                </b-checkbox>
            </div>
        </section>
        <footer class="modal-card-foot">
            <button class="button is-success">Import</button>
            <button class="button">Cancel</button>
        </footer>
    </div>
</template>

<script>
    export default {
        name: "Importer",
        data() {
            return {
                tracks: {},
                playlists: [],
                toImport: []
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
                    this.playlists = res.data;
                });
            },
            _colorClass(toImport) {
                if (this.toImport.indexOf(toImport) !== -1) {
                    return 'has-text-spotify';
                }
                return 'has-text-grey';
            }
        }
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/_variables.scss";

</style>
