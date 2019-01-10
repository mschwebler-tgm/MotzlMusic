<template>
    <section class="tab-scroll">
        <b-tabs v-model="activeTab">
            <b-tab-item label="Playlists">
                <playlists></playlists>
            </b-tab-item>
            <b-tab-item label="Tracks" class="h-100">
                <tracks></tracks>
            </b-tab-item>
            <b-tab-item label="Artists">
                <artists></artists>
            </b-tab-item>
            <b-tab-item label="Albums">
                <albums></albums>
            </b-tab-item>
        </b-tabs>
    </section>
</template>

<script>
    import BSwitch from "buefy/src/components/switch/Switch";
    import Tracks from "./Tracks";
    import Artists from "./Artists";
    import Albums from "./Albums";
    import BIcon from "buefy/src/components/icon/Icon";
    import Playlists from "./Playlists";

    export default {
        components: {
            Playlists,
            BIcon,
            Albums,
            Artists,
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

<style>
    .tab-tools {
        position: absolute;
        top: 15px;
        right: 15px;
    }

    .tab-scroll .tab-content {
        height: 100%;
    }
</style>