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
                    <div v-for="albumsByLetter in albumsByLetters"
                         :key="albumsByLetter.letter"
                         v-ripple
                         @click="clickedAlbums = albumsByLetter"
                         :class="{active: selectedAlbums.letter === albumsByLetter.letter}"
                         class="pa-2 subheading album-letter">
                        {{ albumsByLetter.letter }}
                    </div>
                </div>
                <div class="tools">
                    <v-checkbox v-model="hideSingles" label="Hide singles"></v-checkbox>
                    <span class="subheading">{{ albumCount }} Album{{ albumCount > 1 ? 's' : ''}}</span>
                </div>
                <v-divider></v-divider>
                <v-layout row wrap class="mt-2">
                    <v-flex v-for="album in selectedAlbums.items"
                            :key="album.id"
                            xs6 sm4 md4 lg3 xl2 d-block justify-center>
                        <base-playable-item-card :item="album">
                            <span slot="footer" class="caption grey--text">
                                {{ album.tracks.length }} track{{ album.tracks.length > 1 ? 's' : '' }}
                            </span>
                        </base-playable-item-card>
                    </v-flex>
                </v-layout>
                <div class="d-flex pa-3 mt-2" v-if="!selectedAlbums.items.length">
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
                clickedAlbums: JSON.parse(sessionStorage.getItem('myLibraryClickedAlbums')) || {},
                hideSingles: localStorage.getItem('myLibraryHideSingles'),
            }
        },
        watch: {
            hideSingles() {
                localStorage.setItem('myLibraryHideSingles', this.hideSingles);
            },
            clickedAlbums() {
                sessionStorage.setItem('myLibraryClickedAlbums', JSON.stringify(this.clickedAlbums));
            }
        },
        computed: {
            albumsInitialized() {
                return this.$store.getters['myLibrary/albumsInitialized'];
            },
            albumsByLetters() {
                return this.$store.getters['myLibrary/albums'] || [];
            },
            selectedAlbums() {
                let albumsByLetter = [];
                if (this.clickedAlbums.letter) {
                    albumsByLetter = this.clickedAlbums;
                } else if (this.albumsByLetters.length > 0) {
                    // noinspection JSPotentiallyInvalidTargetOfIndexedPropertyAccess
                    albumsByLetter = this.albumsByLetters[0];
                }

                if (this.hideSingles) {
                    albumsByLetter = {
                        ...albumsByLetter,
                        items: albumsByLetter.items.filter(album => album.tracks.length > 1),
                    };
                }

                return albumsByLetter;
            },
            albumCount() {
                return this.albumsByLetters.reduce((count, albumsByLetter) => {
                    let albums = albumsByLetter.items;
                    if (this.hideSingles) {
                        albums = albums.filter(album => album.tracks.length > 1);
                    }
                    return count + albums.length;
                }, 0);
            },
            allSinglesInAlbum() {
                const singleTracks = this.albumsByLetters
                    .map(albumsByLetter => albumsByLetter.items)
                    .flat()
                    .filter(album => album.tracks.length === 1)
                    .map(album => album.tracks)
                    .flat();

                return {
                    name: 'All Singles',
                    id: 'myLibrarySingles',
                    total_tracks: singleTracks.length,
                    tracks: singleTracks,
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
