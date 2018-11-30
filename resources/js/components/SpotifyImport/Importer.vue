<template>
    <div class="modal-card spotify">
        <header class="modal-card-head">
            <img src="/images/spotify_black.png" width="50px">
            <p class="modal-card-title">&nbsp;&nbsp;Import from Spotify</p>
        </header>
        <section class="modal-card-body">
            You can import your favourite tracks, albums and playlists from spotify.<br><br>

            <!-- TRACKS -->
            <div class="field">
                <b-checkbox v-model="importAllTracks">
                    Import saved tracks&nbsp;&nbsp;&nbsp;
                    <span class="is-size-7" v-if="tracks.total">
                        {{ tracks.total }} tracks
                    </span>
                </b-checkbox>
            </div>

            <!-- ALBUMS -->
            <div class="field">
                <b-checkbox @input="selectAllAlbums" ref="albumCheckbox">
                    Import albums&nbsp;&nbsp;&nbsp;
                    <span class="is-size-7" v-if="albumsTracksTotal">
                        {{ albumsTracksTotal }} tracks in {{ albumsToImport.length || albums.total }} albums
                    </span>
                </b-checkbox>
                &nbsp;&nbsp;&nbsp;
                <span class="has-text-grey is-size-7 customize" v-if="albumsToImport.length > 0"
                      @click="customizeAlbums = !customizeAlbums">
                    customize
                </span>
            </div>
            <div class="item-picker" v-show="customizeAlbums && albumsToImport.length !== 0">
                <div v-for="album in albums.items" :key="album.id"
                     :class="{selected: isItemSelected(albumsToImport, album)}">
                    <div class="item" :style="{backgroundImage: 'url(' + album.image + ')'}"
                         @click="handleItemClick(albumsToImport, album, $refs.albumCheckbox)">
                        <div class="is-overlay select-check">
                            <div class="check">
                                <b-icon icon="check" size="is-large" type="is-white"
                                        v-if="isItemSelected(albumsToImport, album)"></b-icon>
                                <span class="has-text-white">{{ album.tracks }} tracks</span>
                            </div>
                        </div>
                    </div>
                    <div class="has-text-centered has-text-wrapped item-name"
                         @click="handleItemClick(albumsToImport, album, $refs.albumCheckbox)">
                        {{ album.name }}
                    </div>
                </div>
            </div>

            <!-- PLAYLISTS -->
            <div class="field">
                <b-checkbox @input="selectAllPlaylists" ref="playlistCheckbox">
                    Import playlists&nbsp;&nbsp;&nbsp;
                    <span class="is-size-7" v-if="playlistTracksTotal">
                        {{ playlistTracksTotal }} tracks in {{ playlistsToImport.length || playlists.total }} playlists
                    </span>
                </b-checkbox>
                &nbsp;&nbsp;&nbsp;
                <span class="has-text-grey is-size-7 customize"
                      v-if="playlistsToImport.length > 0"
                      @click="customizePlaylists = !customizePlaylists">customize</span>
            </div>
            <div class="item-picker" v-show="customizePlaylists && playlistsToImport.length !== 0">
                <div v-for="playlist in playlists.items" :key="playlist.id"
                     :class="{selected: isItemSelected(playlistsToImport, playlist)}">
                    <div class="item"
                         :style="{backgroundImage: 'url(' + playlist.image + ')'}"
                         @click="handleItemClick(playlistsToImport, playlist, $refs.playlistCheckbox)">
                        <div class="is-overlay select-check">
                            <div class="check">
                            <b-icon icon="check" size="is-large" type="is-white"
                                    v-if="isItemSelected(playlistsToImport, playlist)"></b-icon>
                            <span class="has-text-white">{{ playlist.tracks }} tracks</span>
                            </div>
                        </div>
                    </div>
                    <div class="has-text-centered has-text-wrapped item-name"
                         @click="handleItemClick(playlistsToImport, playlist, $refs.playlistCheckbox)">
                        {{ playlist.name }}
                    </div>
                </div>
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
    import BIcon from "buefy/src/components/icon/Icon";

    export default {
        name: "Importer",
        components: {BIcon},
        data() {
            return {
                tracks: {},
                playlists: {},
                albums: {},
                importAllTracks: false,
                albumsToImport: [],
                playlistsToImport: [],
                customizeAlbums: false,
                customizePlaylists: false,
                totalTracksToImport: 0,
            }
        },
        created() {
            this.loadTracks();
            this.loadPlaylists();
            this.loadAlbums();
        },
        methods: {
            loadTracks() {
                axios.get('/api/spotify/tracks/my').then(res => this.tracks = res.data);
            },
            loadPlaylists() {
                axios.get('/api/spotify/playlists/my').then(res => {
                    this.playlists = {
                        items: res.data,
                        total: res.data.length
                    };
                });
            },
            loadAlbums() {
                axios.get('/api/spotify/albums/my').then(res => this.albums = res.data);
            },
            selectAllAlbums(isSelected) {
                this.albumsToImport = isSelected ? _.clone(this.albums.items) : [];
            },
            selectAllPlaylists(isSelected) {
                this.playlistsToImport = isSelected ? _.clone(this.playlists.items) : [];
            },
            handleItemClick(toImport, item, checkbox) {
                if (this.isItemSelected(toImport, item)) {
                    toImport.splice(toImport.map(a => a.id).indexOf(item.id), 1);
                } else {
                    toImport.push(item);
                }
                checkbox.newValue = toImport.length !== 0;
            },
            isItemSelected(items, paramItem) {
                return !!items.filter(item => item.id === paramItem.id).length;
            },
            updateTotalTracksToImport() {
                let total = 0;
                total += this.importAllTracks ? this.tracks.total : 0;
                total += this.albumsToImport.reduce((acc, item) => acc + item.tracks, 0);
                total += this.playlistsToImport.reduce((acc, item) => acc + item.tracks, 0);
                TweenLite.to(this.$data, 0.5, {totalTracksToImport: total});
            }
        },
        watch: {
            importAllTracks() {
                this.updateTotalTracksToImport()
            },
            playlistsToImport() {
                this.updateTotalTracksToImport()
            },
            albumsToImport() {
                this.updateTotalTracksToImport()
            },
        },
        computed: {
            animatedTotalTracksToImport() {
                return this.totalTracksToImport.toFixed(0);
            },
            playlistTracksTotal() {
                if (!this.playlistsToImport.length && this.playlists.items) {
                    return this.playlists.items.reduce((acc, item) => acc + item.tracks, 0);
                }
                return this.playlistsToImport.reduce((acc, item) => acc + item.tracks, 0);
            },
            albumsTracksTotal() {
                if (!this.albumsToImport.length && this.albums.items) {
                    return this.albums.items.reduce((acc, item) => acc + item.tracks, 0);
                }
                return this.albumsToImport.reduce((acc, item) => acc + item.tracks, 0);
            }
        }
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/_variables.scss";

    .total-tracks {
        margin-left: auto;
    }

    .customize:hover {
        text-decoration: underline;
        cursor: pointer;
    }

    .item-picker {
        display: flex;
        flex-wrap: wrap;
        padding: 3px 15px 15px;
    }

    .item-picker > div {
        width: 150px;
        margin-right: 30px;
        margin-bottom: 10px;
        cursor: pointer;
    }

    .item {
        position: relative;
        width: 150px;
        height: 150px;
        background-position: center center;
        background-size: cover;
    }

    .select-check {
        display: none;
        background-color: transparentize($spotify-primary, .7);
    }

    .select-check .check {
        padding: 5px;
        background-color: $spotify-secondary;
        display: flex;
        align-items: center;
    }

    .item-picker > div.selected .select-check {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .item-picker > div:hover .item-name, .item-picker > div.selected .item-name {
        color: $spotify-primary;
    }

</style>
