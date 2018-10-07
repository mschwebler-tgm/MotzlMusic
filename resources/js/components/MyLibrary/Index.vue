<template>
    <section class="tab-scroll">
        <b-tabs v-model="activeTab">
            <b-tab-item label="Playlists">
                <h2 class="has-text-weight-light title is-9">Newest</h2>
                <div class="flex flex-wrap">
                    <playlist></playlist>
                    <playlist></playlist>
                    <playlist></playlist>
                    <playlist></playlist>
                    <playlist></playlist>
                    <playlist></playlist>
                    <playlist></playlist>
                </div>
                <h2 class="has-text-weight-light title is-9">Automatic Playlists</h2>
                <div class="flex flex-wrap">
                    <playlist></playlist>
                    <playlist></playlist>
                    <playlist></playlist>
                    <playlist></playlist>
                </div>
                <h2 class="has-text-weight-light title is-9">Subscribed Playlists</h2>
                <div class="flex flex-wrap">
                    <playlist></playlist>
                    <playlist></playlist>
                </div>
                <div class="has-text-centered" style="padding: 65px;">
                    No more playlists found. <a href="#">Create new!</a>
                </div>
            </b-tab-item>
            <b-tab-item label="Tracks">
                <h2 class="has-text-weight-light title is-9">Tracks</h2>
                <div class="tab-tools">
                    <button class="button is-white"><b-icon icon="pencil"></b-icon>&nbsp;&nbsp;&nbsp;Edit</button>
                </div>
                <tracks :data="testData"></tracks>
            </b-tab-item>
            <b-tab-item label="Artists">
                <h2 class="has-text-weight-light title is-9">Artists</h2>
                <div class="flex flex-wrap space-around">
                    <artist v-for="(data, index) in testData" :key="index"></artist>
                    <artist v-for="(data, index) in testData" :key="'s' + index"></artist>
                </div>
            </b-tab-item>
            <b-tab-item label="Albums">
                <h2 class="has-text-weight-light title is-9">Albums</h2>
                <div class="flex flex-wrap">
                    <album v-for="(data, index) in testData" :data="data" :key="index"></album>
                </div>
            </b-tab-item>
        </b-tabs>
    </section>
</template>

<script>
    import BSwitch from "buefy/src/components/switch/Switch";
    import Playlist from "./Playlist";
    import Tracks from "./Tracks";
    import Artist from "./Artist";
    import Album from "./Album";
    import BIcon from "buefy/src/components/icon/Icon";

    export default {
        components: {
            BIcon,
            Album,
            Artist,
            Tracks,
            Playlist,
            BSwitch},
        name: "index",
        data() {
            return {
                activeTab: 0,
                showBooks: false,
                isSwitched: false,
                testData: [
                    { title: '1985', duration: '3:15', artist: 'Bowling For Soup', rating: Math.round(Math.random()*50)/10 },
                    { title: '365', duration: '1:26', artist: 'Amaranthe', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Alles auf Rausch', duration: '6:11', artist: 'Feine Sahne Fischfilet', rating: Math.round(Math.random()*50)/10 },
                    { title: 'American Idiot', duration: '3:12', artist: 'Green Day', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Animal', duration: '2:45', artist: 'Smash into Pieces', rating: Math.round(Math.random()*50)/10 },
                    { title: 'The Anthem', duration: '2:12', artist: 'Good Charlotte', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Armut treibt Jugendliche in die Popmusik', duration: '3:15', artist: 'Trailerpark', rating: Math.round(Math.random()*50)/10 },
                    { title: 'The Ballad Of Chasey Lain', duration: '3:15', artist: 'Bloodhound Gang', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Basket Case', duration: '4:49', artist: 'Green Day', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Behind Blue Eyes', duration: '3:52', artist: 'Limp Bizkit', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Blame It On The Boom Boom', duration: '3:20', artist: 'Black Stone Cherry', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Blank Space', duration: '1:59', artist: 'I Prevail', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Bored To Death', duration: '20:31', artist: 'Blink-182', rating: Math.round(Math.random()*50)/10 },
                    { title: 'The Boys of Summer', duration: '2:50', artist: 'The Ataris', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Broken Lives', duration: '4:24', artist: 'Our Last Night', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Coming for You', duration: '2:33', artist: 'The Offspring', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Crazy Train', duration: '4:27', artist: 'Ozzy Osbourne', rating: Math.round(Math.random()*50)/10 },
                    { title: '1985', duration: '3:15', artist: 'Bowling For Soup', rating: Math.round(Math.random()*50)/10 },
                    { title: '365', duration: '1:26', artist: 'Amaranthe', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Alles auf Rausch', duration: '6:11', artist: 'Feine Sahne Fischfilet', rating: Math.round(Math.random()*50)/10 },
                    { title: 'American Idiot', duration: '3:12', artist: 'Green Day', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Animal', duration: '2:45', artist: 'Smash into Pieces', rating: Math.round(Math.random()*50)/10 },
                    { title: 'The Anthem', duration: '2:12', artist: 'Good Charlotte', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Armut treibt Jugendliche in die Popmusik', duration: '3:15', artist: 'Trailerpark', rating: Math.round(Math.random()*50)/10 },
                    { title: 'The Ballad Of Chasey Lain', duration: '3:15', artist: 'Bloodhound Gang', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Basket Case', duration: '4:49', artist: 'Green Day', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Behind Blue Eyes', duration: '3:52', artist: 'Limp Bizkit', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Blame It On The Boom Boom', duration: '3:20', artist: 'Black Stone Cherry', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Blank Space', duration: '1:59', artist: 'I Prevail', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Bored To Death', duration: '20:31', artist: 'Blink-182', rating: Math.round(Math.random()*50)/10 },
                    { title: 'The Boys of Summer', duration: '2:50', artist: 'The Ataris', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Broken Lives', duration: '4:24', artist: 'Our Last Night', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Coming for You', duration: '2:33', artist: 'The Offspring', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Crazy Train', duration: '4:27', artist: 'Ozzy Osbourne', rating: Math.round(Math.random()*50)/10 },
                ]
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