<template>
    <section class="tab-scroll">
        <b-tabs v-model="activeTab">
            <b-tab-item label="Playlists">
                <playlists></playlists>
            </b-tab-item>
            <b-tab-item label="Tracks">
                <tracks></tracks>
            </b-tab-item>
            <b-tab-item label="Artists">
                <h2 class="has-text-weight-light title is-9">Artists</h2>
                <!--<div class="flex flex-wrap space-around">-->
                    <!--<artist v-for="(data, index) in testData" :key="index"></artist>-->
                    <!--<artist v-for="(data, index) in testData" :key="'s' + index"></artist>-->
                <!--</div>-->
            </b-tab-item>
            <b-tab-item label="Albums">
                <h2 class="has-text-weight-light title is-9">Albums</h2>
                <!--<div class="flex flex-wrap">-->
                    <!--<album v-for="(data, index) in testData" :data="data" :key="index"></album>-->
                <!--</div>-->
            </b-tab-item>
        </b-tabs>
    </section>
</template>

<script>
    import BSwitch from "buefy/src/components/switch/Switch";
    import Tracks from "./Tracks";
    import Artist from "./Artist";
    import Album from "./Album";
    import BIcon from "buefy/src/components/icon/Icon";
    import Playlists from "./Playlists";

    export default {
        components: {
            Playlists,
            BIcon,
            Album,
            Artist,
            Tracks,
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
    .tab-tools {
        position: absolute;
        top: 15px;
        right: 15px;
    }
</style>