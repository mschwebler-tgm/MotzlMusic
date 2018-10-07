<template>
    <div>
        <section>
            <b-tabs v-model="activeTab">
                <b-tab-item label="Playlists">
                    <h2 class="has-text-weight-light title is-9">Newest</h2>
                    <div class="flex flex-wrap playlist-wrapper">
                        <playlist></playlist>
                        <playlist></playlist>
                        <playlist></playlist>
                        <playlist></playlist>
                        <playlist></playlist>
                        <playlist></playlist>
                        <playlist></playlist>
                    </div>
                    <h2 class="has-text-weight-light title is-9">Automatic Playlists</h2>
                    <div class="flex flex-wrap playlist-wrapper">
                        <playlist></playlist>
                        <playlist></playlist>
                        <playlist></playlist>
                        <playlist></playlist>
                    </div>
                    <h2 class="has-text-weight-light title is-9">Subscribed Playlists</h2>
                    <div class="flex flex-wrap playlist-wrapper">
                        <playlist></playlist>
                        <playlist></playlist>
                    </div>
                    <div class="has-text-centered" style="padding: 65px;">
                        No more playlists found. <a href="#">Create new!</a>
                    </div>
                </b-tab-item>
                <b-tab-item label="Tracks">
                    Lorem <br>
                    ipsum <br>
                    dolor <br>
                    sit <br>
                    amet.
                </b-tab-item>
                <b-tab-item label="Artists">
                    Lorem <br>
                    ipsum <br>
                    dolor <br>
                    sit <br>
                    amet.
                </b-tab-item>
                <b-tab-item label="Albums">
                    Lorem <br>
                    ipsum <br>
                    dolor <br>
                    sit <br>
                    amet.
                </b-tab-item>
            </b-tabs>
        </section>
    </div>
</template>

<script>
    import BSwitch from "buefy/src/components/switch/Switch";
    import Playlist from "./Playlist";

    export default {
        components: {
            Playlist,
            BSwitch},
        name: "index",
        data() {
            return {
                activeTab: 0,
                showBooks: false,
                isSwitched: false,
            }
        }
    }
</script>

<style scoped>

</style>