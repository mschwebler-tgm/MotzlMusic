<template functional>
    <div>
        <v-tabs centered>
            <v-tab ripple to="/my-library/playlists">
                Playlists
                <!--                <v-icon>playlist_play</v-icon>-->
            </v-tab>
            <v-tab ripple to="/my-library/tracks">
                Tracks
                <!--                <v-icon>music_note</v-icon>-->
            </v-tab>
            <v-tab ripple to="/my-library/albums">
                Albums
                <!--                <v-icon>album</v-icon>-->
            </v-tab>
            <v-tab ripple to="/my-library/artists">
                Artists
                <!--                <v-icon>account_box</v-icon>-->
            </v-tab>
        </v-tabs>
        <v-divider></v-divider>
    </div>
</template>

<script>
    export default {
        name: "MainContentHeaderMyLibraryNav"
    }
</script>

<style scoped lang="scss">
    .menu-scroll {
        overflow-x: scroll;

        &::-webkit-scrollbar {
            display: none;
        }
    }
</style>
