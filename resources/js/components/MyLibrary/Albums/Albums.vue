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
            <div class="mt-2 mb-4 text-xs-center caption">
                <span v-for="albumsByLetter in albumsByLetters"
                      :key="albumsByLetter.letter"
                      @click="clickedAlbums = albumsByLetter"
                      :class="{active: selectedAlbums.letter === albumsByLetter.letter}"
                      class="pa-2 subheading album-letter">
                    {{ albumsByLetter.letter }}
                </span>
            </div>
            <v-checkbox v-model="hideSingles" label="Only albums with more than 1 track"></v-checkbox>
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
                return this.$store.getters['myLibrary/albums'];
            },
            selectedAlbums() {
                let albumsByLetter = [];
                if (this.clickedAlbums.letter) {
                    albumsByLetter = this.clickedAlbums;
                } else if (this.albumsByLetters.length > 0) {
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
        }
    }
</script>

<style scoped>
    .album-letter {
        cursor: pointer;
    }

    .album-letter:hover {
        border-bottom: 2px solid var(--v-primary-base);
    }

    .album-letter.active {
        border-bottom: 2px solid var(--v-primary-base);
    }
</style>
