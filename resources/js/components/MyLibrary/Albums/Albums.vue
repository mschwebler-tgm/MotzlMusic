<template>
    <div>
        <v-container><h2 class="headline">Albums</h2></v-container>
        <div class="mt-2 text-xs-center caption">
            <span v-for="albumsByLetter in albumsByLetters"
                  :key="albumsByLetter.letter"
                  @click="clickedAlbums = albumsByLetter"
                  :class="{active: selectedAlbums.letter === albumsByLetter.letter}"
                  class="pa-2 subheading album-letter">
                {{ albumsByLetter.letter }}
            </span>
        </div>
        <v-container>
            <v-layout row wrap>
                <v-flex v-for="album in selectedAlbums.albums"
                        :key="album.id"
                        xs6 sm4 md4 lg3 xl2 d-block justify-center>
                    <album-item :album="album"></album-item>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
    import AlbumItem from "./AlbumItem";

    export default {
        name: "Albums",
        components: {AlbumItem},
        data() {
            return {
                clickedAlbums: {},
            }
        },
        computed: {
            albumsByLetters() {
                return this.$store.getters['myLibrary/albums'];
            },
            selectedAlbums() {
                if (this.clickedAlbums.letter) {
                    return this.clickedAlbums;
                }
                if (this.albumsByLetters.length > 0) {
                    return this.albumsByLetters[0];
                }
                return [];
            }
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
