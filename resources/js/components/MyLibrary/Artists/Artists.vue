<template>
    <v-container>
        <div class="d-flex justify-center" v-if="!artistsInitialized">
            <v-progress-circular
                    v-if="!artistsInitialized"
                    color="primary"
                    indeterminate>
            </v-progress-circular>
        </div>

        <div v-else>
            <div class="text-xs-center artist-letters">
                <div v-for="artistsByLetter in artistsByLetters"
                     :key="artistsByLetter.letter"
                     v-ripple
                     @click="clickedArtists = artistsByLetter"
                     :class="{active: selectedArtists.letter === artistsByLetter.letter}"
                     class="pa-2 subheading artist-letter">
                    {{ artistsByLetter.letter }}
                </div>
            </div>
            <div class="tools">
                <v-checkbox v-model="hideSingleTrackArtists" label="Hide artists with 1 track"></v-checkbox>
                <span class="subheading">{{ artistCount }} Artist{{ artistCount > 1 ? 's' : ''}}</span>
            </div>
            <v-divider></v-divider>
            <v-layout row wrap class="mt-2">
                <v-flex v-for="artist in selectedArtists.items"
                        :key="artist.id"
                        xs6 sm4 md4 lg3 xl2 d-block justify-center>
                    <artist-item :artist="artist"></artist-item>
<!--                    {{ artist.name }}-->
                </v-flex>
            </v-layout>
            <div class="d-flex pa-3 mt-2" v-if="!selectedArtists.items.length">
                <span class="subheading text-xs-center">No artists here. Check filters and try again.</span>
            </div>
            <v-divider class="mt-3 mb-3"></v-divider>
            <v-layout>
                <v-flex xs6 sm4 md4 lg3 xl2 d-block justify-center>
                    <artist-item :artist="artistsWithOneTrack"></artist-item>
<!--                    Artist with one track-->
                </v-flex>
            </v-layout>
        </div>
    </v-container>
</template>

<script>
    import ArtistItem from "./ArtistItem";

    export default {
        name: "Artists",
        components: {ArtistItem},
        data() {
            return {
                clickedArtists: JSON.parse(sessionStorage.getItem('myLibraryClickedArtist')) || {},
                hideSingleTrackArtists: JSON.parse(localStorage.getItem('myLibraryHideArtistsWithOneTrack')),
            }
        },
        watch: {
            hideSingleTrackArtists() {
                localStorage.setItem('myLibraryHideArtistsWithOneTrack', this.hideSingleTrackArtists);
            },
            clickedArtists() {
                sessionStorage.setItem('myLibraryClickedArtist', JSON.stringify(this.clickedArtists));
            }
        },
        computed: {
            artistsInitialized() {
                return this.$store.getters['myLibrary/artistsInitialized'];
            },
            artistsByLetters() {
                return this.$store.getters['myLibrary/artists'] || [];
            },
            selectedArtists() {
                let artistsByLetter = [];
                if (this.clickedArtists.letter) {
                    artistsByLetter = this.clickedArtists;
                } else if (this.artistsByLetters.length > 0) {
                    // noinspection JSPotentiallyInvalidTargetOfIndexedPropertyAccess
                    artistsByLetter = this.artistsByLetters[0];
                }

                if (this.hideSingleTrackArtists) {
                    artistsByLetter = {
                        ...artistsByLetter,
                        items: artistsByLetter.items.filter(artist => artist.tracks.length > 1),
                    };
                }

                return artistsByLetter;
            },
            artistCount() {
                return this.artistsByLetters.reduce((count, artistsByLetter) => {
                    let artists = artistsByLetter.items;
                    if (this.hideSingleTrackArtists) {
                        artists = artists.filter(artist => artist.tracks.length > 1);
                    }
                    return count + artists.length;
                }, 0);
            },
            artistsWithOneTrack() {
                const singleTracks = this.artistsByLetters
                    .map(artistsByLetter => artistsByLetter.items)
                    .flat()
                    .filter(artist => artist.tracks.length === 1)
                    .map(artist => artist.tracks)
                    .flat();

                return {
                    name: 'My one hit wonders',
                    id: 'myLibrarySingles',
                    total_tracks: singleTracks.length,
                    tracks: singleTracks,
                };
            }
        }
    }
</script>


<style scoped lang="scss">

    .artist-letters {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .artist-letter {
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
        .artist-letters {
            flex-wrap: nowrap;
            justify-content: flex-start;
            /*white-space: nowrap;*/
            overflow-x: scroll;
            overflow-y: hidden;

            &::-webkit-scrollbar {
                display: none;
            }

            .artist-letter {
                line-height: 1em;
                font-size: 1em !important;
            }
        }
    }
</style>
