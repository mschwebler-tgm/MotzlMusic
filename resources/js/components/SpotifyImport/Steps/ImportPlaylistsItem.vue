<template>
    <v-hover>
        <v-card slot-scope="{ hover }" class="pointer playlist-card" @click="toggleSelected">
            <v-img :aspect-ratio="1"
                   width="200"
                   height="200"
                   :src="getImage()">
                <v-expand-transition>
                    <div v-if="hover || playlist.selected"
                         class="d-flex align-center justify-center transition-fast-in-fast-out spotify darken-2 v-card--reveal display-1 white--text"
                         style="height: 100%;">
                        {{ playlist.tracks }} Track{{ playlist.tracks > 1 ? 's' : '' }}
                    </div>
                </v-expand-transition>
            </v-img>
            <v-card-text class="pt-4 overflow-hidden">
                <h3 class="headline font-weight-light spotify--text mb-2 truncate">{{ playlist.name }}</h3>
                <div class="font-weight-light grey--text title mb-1 align-center" style="display: flex;" v-if="isForeign()">
                    <v-icon>perm_identity</v-icon>
                    <span class="caption ml-1">{{ playlist.owner.display_name }}</span>
                </div>
            </v-card-text>
        </v-card>
    </v-hover>
</template>

<script>
    import Vue from "vue";

    export default {
        name: "ImportPlaylistsItem",
        props: {
            playlist: Object,
        },
        methods: {
            getImage() {
                return this.playlist.image || window.playlistFallback;
            },
            isForeign() {
                return !this.playlist.owner || this.playlist.owner.id !== this.$root.user.spotify_id;
            },
            toggleSelected() {
                if (!this.playlist.selected) {
                    Vue.set(this.playlist, 'selected', true);
                } else {
                    this.playlist.selected = false;
                }
            }
        }
    }
</script>

<style scoped>
    .truncate {
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: fade;
    }

    .playlist-card {
        width: 200px;
        overflow: hidden;
    }
</style>