<template>
    <div>
        <v-container>
            <div class="d-flex justify-center" v-if="!artistsInitialized">
                <v-progress-circular
                        v-if="!artistsInitialized"
                        color="primary"
                        indeterminate>
                </v-progress-circular>
            </div>

            <div v-else>
                <div class="text-center artist-letters">
                    <div v-for="letter in availableLetters"
                         :key="letter"
                         v-ripple
                         @click="selectedLetter = letter"
                         :class="{active: letter === selectedLetter}"
                         class="pa-2 subheading artist-letter">
                        {{ letter }}
                    </div>
                </div>
                <div class="tools">
                    <v-checkbox v-model="hideSingleTrackArtists" label="Hide artists with single track"></v-checkbox>
                    <span class="subheading">{{ totalArtistCount }} Artist{{ totalArtistCount > 1 ? 's' : ''}}</span>
                </div>
                <v-divider></v-divider>
                <v-layout row wrap class="mt-2" v-if="loading">
                    <v-flex v-for="item in 6"
                            :key="item"
                            xs6 sm4 md4 lg3 xl2 d-block justify-center>
                        <v-skeleton-loader type="card"></v-skeleton-loader>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-2" v-else>
                    <v-flex v-for="artist in artistsToShow"
                            :key="artist.id"
                            xs6 sm4 md4 lg3 xl2 d-block justify-center>
                        <base-playable-item-card :item="artist" rounded transparent>
                            <span slot="footer" class="caption grey--text">
                                {{ artist.tracks.length }} track{{ artist.tracks.length > 1 ? 's' : '' }}
                            </span>
                        </base-playable-item-card>
                    </v-flex>
                </v-layout>
                <div class="d-flex pa-3 mt-2" v-if="!artistsToShow.length">
                    <span class="subheading text-center">No artists here. Check filters and try again.</span>
                </div>
                <v-divider class="mt-3 mb-3"></v-divider>
                <v-layout>
                    <v-flex xs6 sm4 md4 lg3 xl2 d-block justify-center>
                        <base-playable-item-card :item="artistsWithOneTrack">
                            <!-- Artist with one track-->
                            <span slot="footer" class="caption grey--text">
                                {{ artistsWithOneTrack.tracks.length }} track{{ artistsWithOneTrack.tracks.length > 1 ? 's' : '' }}
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
    import cacheRequest from "$scripts/cacheReqest/cacheRequest";

    export default {
        name: "Artists",
        components: {BasePlayableItemCard},
        data() {
            return {
                selectedLetter: sessionStorage.getItem('myLibrarySelectedLetter') || '#',
                hideSingleTrackArtists: localStorage.getItem('myLibraryHideArtistsWithOneTrack') === 'true',
                selectedArtists: [],
                loading: false,
            }
        },
        watch: {
            selectedLetter(selectedLetter) {
                sessionStorage.setItem('myLibraryClickedArtist', selectedLetter);
                this.showArtistsForLetter(selectedLetter);
            },
            hideSingleTrackArtists() {
                localStorage.setItem('myLibraryHideArtistsWithOneTrack', this.hideSingleTrackArtists);
            },
            artistsInitialized(isInitialized) {
                if (isInitialized) {
                    this.showArtistsForLetter(this.selectedLetter);
                }
            }
        },
        created() {
            if (this.artistsInitialized) {
                this.showArtistsForLetter(this.selectedLetter);
            }
        },
        computed: {
            artistsInitialized() {
                return this.$store.getters['myLibrary/artistsInitialized'];
            },
            artistsByLetters() {
                return this.$store.getters['myLibrary/artists'] || [];
            },
            artistsToShow() {
                if (this.hideSingleTrackArtists) {
                    return this.selectedArtists.filter(artists => artists.tracks.length > 1);
                }
                return this.selectedArtists;
            },
            availableLetters() {
                return this.artistsByLetters.map(byLetter => byLetter.letter);
            },
            totalArtistCount() {
                return this.artistsByLetters.reduce((total, artistByLetter) => artistByLetter.count + total, 0);
            },
            artistsWithOneTrack() {
                const singleTracksIds = this.$store.getters['myLibrary/artistsSingleTracks'];

                return {
                    name: 'My one hit wonders',
                    id: 'myLibraryArtistSingles',
                    total_tracks: singleTracksIds.length,
                    tracks: singleTracksIds,
                };
            }
        },
        methods: {
            async showArtistsForLetter(selectedLetter) {
                const artistsByLetter = this.artistsByLetters.find(byLetter => byLetter.letter === selectedLetter);
                if (!artistsByLetter) {
                    return [];
                }

                const artistIds = artistsByLetter.items;
                this.loading = true;
                this.selectedArtists = await cacheRequest.getArtists(artistIds);
                this.loading = false;
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

            scrollbar-width: none;
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
