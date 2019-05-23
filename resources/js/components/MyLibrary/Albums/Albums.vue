<template>
    <v-container>
        <h2 class="headline">Albums</h2>
        <div class="d-flex justify-center" v-if="!albumsInitialized">
            <v-progress-circular
                    v-if="!albumsInitialized"
                    color="primary"
                    indeterminate>
            </v-progress-circular>
        </div>

        <div v-else>
            <div class="mt-2 mb-3 text-xs-center album-letters">
                <span v-for="albumsByLetter in albumsByLetters"
                      :key="albumsByLetter.letter"
                      @click="clickedAlbums = albumsByLetter"
                      :class="{active: selectedAlbums.letter === albumsByLetter.letter}"
                      class="pa-2 subheading album-letter">
                    {{ albumsByLetter.letter }}
                </span>
            </div>
            <div class="tools">
                <v-checkbox v-model="hideSingles" label="Hide singles"></v-checkbox>
                <span class="subheading">{{ albumCount }} Album{{ albumCount > 1 ? 's' : ''}}</span>
            </div>
            <v-divider></v-divider>
            <v-layout row wrap class="mt-2">
                <v-flex v-for="album in selectedAlbums.albums"
                        :key="album.id"
                        xs6 sm4 md4 lg3 xl2 d-block justify-center>
                    <album-item :album="album"></album-item>
                </v-flex>
            </v-layout>
        </div>
    </v-container>
</template>

<script>
    import AlbumItem from "./AlbumItem";

    export default {
        name: "Albums",
        components: {AlbumItem},
        data() {
            return {
                clickedAlbums: {},
                hideSingles: false,
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
                        albums: albumsByLetter.albums.filter(album => album.tracks.length > 1),
                    };
                }

                return albumsByLetter;
            },
            albumCount() {
                return this.albumsByLetters.reduce((count, albumsByLetter) => {
                    let albums = albumsByLetter.albums;
                    if (this.hideSingles) {
                        albums = albums.filter(album => album.tracks.length > 1);
                    }
                    return count + albums.length;
                }, 0);
            }
        }
    }
</script>


<style scoped lang="scss">

    .album-letter {
        cursor: pointer;
        line-height: 2.6em;

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
            white-space: nowrap;
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
