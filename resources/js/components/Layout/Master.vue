<template>
    <div id="master">
        <v-app :dark="$root.isDarkTheme">
            <v-navigation-drawer v-model="showDrawer" app></v-navigation-drawer>
            <v-toolbar app color="info">
                <v-toolbar-side-icon @click="showDrawer = !showDrawer"></v-toolbar-side-icon>
                <v-toolbar-title>MotzlMusic</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items class="hidden-sm-and-down">
                    <v-btn flat>Link One</v-btn>
                    <v-btn flat>Link Two</v-btn>
                    <v-btn flat>{{ user.name }}</v-btn>
                </v-toolbar-items></v-toolbar>
            <v-content>
                <v-container fluid>
                    <router-view></router-view>
                </v-container>
            </v-content>
            <v-footer app></v-footer>
        </v-app>
    </div>
</template>

<script>
    export default {
        name: "master",
        props: ['user'],
        data() {
            return {
                showDrawer: false,
            }
        },
        created() {
            this.$root.showSpotifyImport = this.user && !this.user.spotify_import_complete;
        },
    }
</script>

<style scoped lang="scss">
</style>
