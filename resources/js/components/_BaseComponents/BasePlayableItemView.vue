<template>
    <v-container>
        <div class="d-flex" v-if="loading">
            <v-skeleton-loader type="image" width="190"></v-skeleton-loader>
            <v-skeleton-loader type="sentences" width="400" class="ml-3 d-flex"></v-skeleton-loader>
            <div class="flex-1 d-flex justify-end align-end">
                <v-skeleton-loader type="button" width="80"></v-skeleton-loader>
                <v-skeleton-loader type="button"></v-skeleton-loader>
            </div>
        </div>
        <div class="d-flex pa-3" v-else>
            <v-img :src="$root.getSpotifyImage(item, 'medium')"
                   aspect-ratio="1"
                   max-width="190px"
                   min-width="190px"
                   :class="{'image-rounded': roundedImage}"></v-img>
            <div class="d-flex flex-column pa-3 ml-3">
                <div class="d-flex">
                    <h1 class="display-3 font-weight-thin">{{ item.name }}</h1>
                    <v-btn color="secondary"
                           aria-label="Start Artist Playback"
                           class="ml-4"
                           @click="playList"
                           fab outlined>
                        <v-icon large>play_arrow</v-icon>
                    </v-btn>
                </div>
                <div class="body-2 grey--text mt-2">
                    <span v-if="releaseYear">
                        <v-icon x-small color="grey">calendar_today</v-icon>
                        {{ releaseYear }}
                    </span>
                    &nbsp;&nbsp;
                    <span v-if="totalPlayTime">
                        <v-icon x-small color="grey">timelapse</v-icon>
                        {{ totalPlayTime }}
                    </span>
                </div>
                <div class="mt-auto">
                    <v-switch
                        v-model="showAllTracks"
                        label="Show all tracks (from global library)"
                        hide-details
                    ></v-switch>
                </div>
            </div>
        </div>
        <v-divider></v-divider>
        <template v-if="relatedItems.length > 0 || !relatedItemsLoaded">
            <div class="pl-3 pt-3 grey--text body-1">
                {{ cacheRequestGetRelatedMethod.slice(3) }}
                <span class="caption grey--text" v-if="relatedItemsLoaded">
                    ({{ relatedItems.length }})
                </span>
            </div>
            <base-card-slider :items="relatedItems" :loading="!relatedItemsLoaded"></base-card-slider>
        </template>
        <div class="pl-3 pt-3 grey--text body-1">
            Tracks
            <span class="caption grey--text">
                ({{ tracks.length }})
            </span>
        </div>
        <track-table :tracks="tracks"
                     :config="tableConfig"
                     :class="{'pa-3': !$root.isMobile}"
                     height="444px"></track-table>
    </v-container>
</template>

<script>
    import cacheRequest from "$scripts/cacheReqest/cacheRequest";
    import BaseCardSlider from "$scripts/components/_BaseComponents/BaseCardSlider";
    import TrackTable from "$scripts/components/TrackTable/TrackTable";
    import player from "$store/player/helpers/v2/player";

    export default {
        name: "BasePlayableItemView",
        components: {TrackTable, BaseCardSlider},
        props: {
            id: [String, Number],
            onlyOwnTracks: Boolean,
            roundedImage: Boolean,
            tableConfig: Object,
            relatedItemsKey: {
                type: String,
                required: true,
            },
            type: {
                type: String,
                required: true,
            },
        },
        data() {
            return {
                loading: false,
                showAllTracks: !this.onlyOwnTracks,
                item: null,
                tracks: [],
                ownTrackIds: [],
                ownTrackIdsInitialized: false,
                relatedItems: [],
                relatedItemsLoaded: false,
                ownRelatedItemIds: [],
                ownRelatedItemIdsInitialized: false,
            }
        },
        watch: {
            async showAllTracks() {
                this.loadTracks();
                this.loadRelatedItems();
            },
            id() {
                this.loadContent();
            }
        },
        async created() {
            this.loadContent();
        },
        methods: {
            async loadContent() {
                this.tracks = [];
                await this.loadItem();
                this.loadTracks();
                this.loadRelatedItems();
            },
            async loadItem() {
                this.loading = true;
                this.item = await cacheRequest[this.cacheRequestGetItemMethod](this.id);
                this.loading = false;
            },
            async loadTracks() {
                let trackIds = [];
                if (this.showAllTracks) {
                    trackIds = this.item.tracks.map(track => track.id);
                } else if (this.ownTrackIdsInitialized) {
                    trackIds = this.ownTrackIds;
                } else {
                    // /api/my/artist/8/trackIds
                    const response = await axios.get(`/api/my/${this.item.type}/${this.id}/tracksIds`);
                    trackIds = response.data;
                    this.ownTrackIds = trackIds;
                    this.ownTrackIdsInitialized = true;
                }
                this.tracks = await cacheRequest.getTracks(trackIds);
            },
            async loadRelatedItems() {
                let itemIds = [];
                if (this.showAllTracks) {
                    itemIds = this.item[this.relatedItemsKey].map(item => item.id);
                } else if (this.ownRelatedItemIdsInitialized) {
                    itemIds = this.ownRelatedItemIds;
                } else {
                    // /api/my/artist/8/albumIds
                    const response = await axios.get(`/api/my/${this.item.type}/${this.id}/${this.relatedItemsKey.slice(0, -1)}Ids`);
                    itemIds = response.data;
                    this.ownRelatedItemIds = itemIds;
                    this.ownRelatedItemIdsInitialized = true;
                }

                this.relatedItems = await cacheRequest[this.cacheRequestGetRelatedMethod](itemIds);
                this.relatedItemsLoaded = true;
            },
            playList() {
                player.playList(this.tracks);
            }
        },
        computed: {
            cacheRequestGetRelatedMethod() {
                return 'get' + this.relatedItemsKey.charAt(0).toUpperCase() + this.relatedItemsKey.slice(1);
            },
            cacheRequestGetItemMethod() {
                return 'get' + this.type.charAt(0).toUpperCase() + this.type.slice(1);
            },
            releaseYear() {
                if (!this.item.release_date) {
                    return null;
                }

                return this.item.release_date.substring(0, 4);
            },
            totalPlayTime() {
                let text = '';
                const totalTimeMs = this.tracks.reduce((totalTime, track) => totalTime + track.duration, 0);
                let minutes = Math.round(totalTimeMs / 60000);
                let hours = Math.floor(minutes / 60);
                minutes -= hours * 60;

                if (hours) {
                    text += `${hours}h `;
                }
                if (minutes) {
                    text += `${minutes}min`;
                }

                return text;
            },
        }
    }
</script>
