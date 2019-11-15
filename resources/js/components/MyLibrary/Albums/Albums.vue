<template>
    <div>
        <v-container>
            <div class="d-flex justify-center" v-if="!albumsInitialized">
                <v-progress-circular
                        v-if="!albumsInitialized"
                        color="primary"
                        indeterminate>
                </v-progress-circular>
            </div>

            <div v-else>
                <div class="text-center album-letters">
                    <div v-for="letter in availableLetters"
                         :key="letter"
                         v-ripple
                         @click="selectedLetter = letter"
                         :class="{active: letter === selectedLetter}"
                         class="pa-2 subheading album-letter">
                        {{ letter }}
                    </div>
                </div>
                <div class="tools">
                    <v-checkbox v-model="hideSingles" label="Hide singles" color="primary"></v-checkbox>
                    <span class="subheading">{{ totalAlbumCount }} Album{{ totalAlbumCount > 1 ? 's' : ''}}</span>
                </div>
                <v-divider></v-divider>
                <v-layout row wrap class="mt-2">
                    <v-flex v-for="album in albumsToShow"
                            :key="album.id"
                            xs6 sm4 md4 lg3 xl2 d-block justify-center>
                        <base-playable-item-card :item="album">
                            <span slot="footer" class="caption grey--text">
                                {{ album.tracks.length }} track{{ album.tracks.length > 1 ? 's' : '' }}
                            </span>
                        </base-playable-item-card>
                    </v-flex>
                </v-layout>
                <div class="d-flex pa-3 mt-2" v-if="!albumsToShow.length">
                    <span class="subheading text-center">No albums here. Check filters and try again.</span>
                </div>
                <v-divider class="mt-3 mb-3"></v-divider>
                <v-layout>
                    <v-flex xs6 sm4 md4 lg3 xl2 d-block justify-center>
                        <base-playable-item-card :item="allSinglesInAlbum">
                            <span slot="footer" class="caption grey--text">
                                {{ allSinglesInAlbum.tracks.length }} track{{ allSinglesInAlbum.tracks.length > 1 ? 's' : '' }}
                            </span>
                        </base-playable-item-card>
                    </v-flex>
                </v-layout>
            </div>
        </v-container>
    </div>
</template>

<script>
    import BasePlayableItemCard from "../../_BaseComponents/BasePlayableItemCard";

    export default {
        name: "Albums",
        components: {BasePlayableItemCard},
        data() {
            return {
                selectedLetter: sessionStorage.getItem('myLibraryAlbumsLetter') || '#',
                hideSingles: localStorage.getItem('myLibraryHideSingles') === 'true',
                selectedAlbums: [],
            }
        },
        watch: {
            selectedLetter(selectedLetter) {
                sessionStorage.setItem('myLibraryAlbumsLetter', selectedLetter);
                this.showAlbumsForLetter(selectedLetter);
            },
            hideSingles() {
                localStorage.setItem('myLibraryHideSingles', this.hideSingles);
            },
            albumsInitialized(isInitialized) {
                if (isInitialized) {
                    this.showAlbumsForLetter(this.selectedLetter);
                }
            }
        },
        created() {
            if (this.albumsInitialized) {
                this.showAlbumsForLetter(this.selectedLetter);
            }
        },
        methods: {
            async showAlbumsForLetter(selectedLetter) {
                const albumsByLetter = this.albumsByLetters.find(byLetter => byLetter.letter === selectedLetter);
                if (!albumsByLetter) {
                    return [];
                }

                const albumIds = albumsByLetter.items;
                this.selectedAlbums = await cacheRequest.getAlbums(albumIds);
            },
        },
        computed: {
            albumsInitialized() {
                return this.$store.getters['myLibrary/albumsInitialized'];
            },
            totalAlbumCount() {
                return this.albumsByLetters.reduce((total, albumsByLetter) => albumsByLetter.count + total, 0);
            },
            albumsByLetters() {
                return this.$store.getters['myLibrary/albums'] || [];
            },
            albumsToShow() {
                if (this.hideSingles) {
                    return this.selectedAlbums.filter(album => album.tracks.length > 1);
                }
                return this.selectedAlbums;
            },
            availableLetters() {
                return this.albumsByLetters.map(byLetter => byLetter.letter);
            },
            allSinglesInAlbum() {
                const singleTrackIds = this.$store.getters['myLibrary/albumsSingleTracks'];

                return {
                    name: 'All Singles',
                    id: 'myLibraryAlbumSingles',
                    total_tracks: singleTrackIds.length,
                    tracks: singleTrackIds,
                };
            }
        }
    }
</script>

<style scoped lang="scss">

    .album-letters {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .album-letter {
        cursor: pointer;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;

        &:hover, &.active {
            color: var(--v-primary-base);

        }
    }

    .tools {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    @media screen and (max-width: 600px) {
        .album-letters {
            flex-wrap: nowrap;
            justify-content: flex-start;
            /*white-space: nowrap;*/
            overflow-x: scroll;
            overflow-y: hidden;

            &::-webkit-scrollbar {
                display: none;
            }

            .album-letter {
                line-height: 1em;
                font-size: 1em !important;
            }
        }
    }
</style>
