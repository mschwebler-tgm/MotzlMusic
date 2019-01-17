<template>
    <div id="master">
        <player></player>
        <b-modal v-if="user && !user.spotify_import_complete || $root.showSpotifyImport"
                :active.sync="$root.showSpotifyImport" has-modal-card>
            <spotify-importer></spotify-importer>
        </b-modal>
        <nav-bar></nav-bar>
        <div class="content-wrapper">
            <aside class="menu">
                <p class="menu-label">
                    General
                </p>
                <ul class="menu-list">
                    <li><router-link to="/my-library">My Library</router-link></li>
                    <li><router-link to="/global-library">Global Library</router-link></li>
                    <li><router-link to="/create-smart-playlist">Create smart playlist</router-link></li>
                </ul>
                <!--<p class="menu-label">-->
                    <!--Administration-->
                <!--</p>-->
                <!--<ul class="menu-list">-->
                    <!--<li><a>Team Settings</a></li>-->
                <!--</ul>-->
                <p class="menu-label">
                    Player
                </p>
                <ul class="menu-list">
                    <li><a>Player+</a></li>
                </ul>
                <button class="button is-danger is-large is-fullwidth is-outlined" id="upload-button">Upload</button>
            </aside>
            <div class="my-content">
                <router-view></router-view>
            </div>
            <div class="my-sub-content is-hidden-touch pad" style="padding-top: 60px;">
                <div class="box flex space-around">
                    <div class="image" style="width: 350px; height: 300px;">
                        <img src="https://camo.githubusercontent.com/c0224976d49b4712dfeb10d4d9e804bab5379b4e/687474703a2f2f7777342e73696e61696d672e636e2f6d773639302f3639333237363337677731663178633363306b65616a323063623061397133682e6a7067">
                    </div>
                </div>
                <div class="box">
                    <!--<box-player></box-player>-->
                </div>
                <div class="box">
                    Queued tracks
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Tracks from "../MyLibrary/Tracks";
    import NavBar from "./Navbar";
    import SpotifyImporter from "../SpotifyImport/Importer";
    import BModal from "buefy/src/components/modal/Modal";
    import Player from "../Player/Player";

    export default {
        components: {Player, BModal, Tracks, NavBar, SpotifyImporter},
        name: "master",
        props: ['user'],
        created() {
            this.$root.showSpotifyImport = this.user && !this.user.spotify_import_complete;
        },
        mounted() {
            this.initMobileNav();
        },
        methods: {
            initMobileNav() {
                const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
                if ($navbarBurgers.length > 0) {
                    $navbarBurgers.forEach(el => {
                        el.addEventListener('click', () => {
                            const target = el.dataset.target;
                            const $target = document.getElementById(target);
                            el.classList.toggle('is-active');
                            $target.classList.toggle('is-active');
                        });
                    });
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    @import "~bulma/sass/utilities/initial-variables";
    @import "../../../sass/_variables.scss";

    #master {
        width: 100vw;
        height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .content-wrapper {
        flex: 1;
        display: flex;
    }
    .content-wrapper > aside {
        width: $menu-width;
    }
    .content-wrapper > .my-content {
        overflow-y: scroll;
        display: flex;
        height: calc(100vh - 52px);
        /*flex: 1;*/
        width: 1172px;
        padding: 20px 20px 0;
    }
    .my-content::-webkit-scrollbar, .my-content::-webkit-scrollbar-track,
    .my-content::-webkit-scrollbar-thumb, .my-content::-webkit-scrollbar-thumb:hover {
        display: none;
    }

    .menu {
        padding: 15px;
        border-right: 1px solid $grey-lighter;
    }
    #upload-button {
        width: $menu-width - 30px;
        position: absolute;
        bottom: 15px;
    }
</style>
