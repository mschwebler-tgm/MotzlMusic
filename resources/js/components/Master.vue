<template>
    <div id="master">
        <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <router-link class="navbar-item" to="/">
                    <img src="https://bulma.io/images/bulma-logo-white.png" width="112" height="28">
                </router-link>

                <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false"
                   data-target="navbarMain">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>
            <div id="navbarMain" class="navbar-menu">
                <div class="navbar-start">
                    <router-link class="navbar-item" to="new">New Uploads</router-link>
                </div>

                <div class="navbar-search">
                    <input type="text" placeholder="Search"/>
                </div>

                <div class="navbar-end">
                    <div class="navbar-item">
                        {{ user.name }}
                        <!--<div class="buttons">-->
                            <!--<a class="button is-primary">-->
                                <!--<strong>Sign up</strong>-->
                            <!--</a>-->
                            <!--<a class="button is-light">-->
                                <!--Log in-->
                            <!--</a>-->
                        <!--</div>-->
                    </div>
                </div>
            </div>
        </nav>
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
            <div class="my-sub-content is-hidden-mobile-only is-hidden-tablet-only pad" style="padding-top: 60px;">
                <div class="box flex space-around">
                    <div class="image" style="width: 350px; height: 300px;">
                        <img src="https://camo.githubusercontent.com/c0224976d49b4712dfeb10d4d9e804bab5379b4e/687474703a2f2f7777342e73696e61696d672e636e2f6d773639302f3639333237363337677731663178633363306b65616a323063623061397133682e6a7067">
                    </div>
                </div>
                <div class="box">
                    <div class="flex space-between">
                        <span>365 - Amaranthe</span>
                        <span>0:59</span>
                    </div>
                    <div class="flex space-around pad">
                        <b-icon size="is-large" icon="skip-previous"></b-icon>
                        <b-icon size="is-large" icon="pause-circle-outline"></b-icon>
                        <b-icon size="is-large" icon="skip-next"></b-icon>
                    </div>
                </div>
                <div class="box">
                    <tracks :data="[
                    { title: 'Broken Lives', duration: '4:24', artist: 'Our Last Night', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Coming for You', duration: '2:33', artist: 'The Offspring', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Crazy Train', duration: '4:27', artist: 'Ozzy Osbourne', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Animal', duration: '2:45', artist: 'Smash into Pieces', rating: Math.round(Math.random()*50)/10 },
                    { title: 'The Anthem', duration: '2:12', artist: 'Good Charlotte', rating: Math.round(Math.random()*50)/10 },
                    ]"></tracks>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Tracks from "./MyLibrary/Tracks";

    export default {
        components: {Tracks},
        name: "master",
        props: ['user'],
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
    @import "../../sass/_variables.scss";

    #master {
        width: 100vw;
        height: 100vh;
        display: flex;
        flex-direction: column;
    }
    .navbar-search {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 1;
        padding-left: 10%;
        padding-right: 10%;
    }
    .navbar-search > input {
        width: 100%;
        max-width: 550px;
        background-color: mix($observatory, black, 70);
        font-size: 20px;
        color: white;
        border: none;
        border-radius: 40px;
        padding: 8px 8px 8px 25px;
        outline: none;
        -webkit-transition: background-color .3s;
        -moz-transition: background-color .3s;
        -ms-transition: background-color .3s;
        -o-transition: background-color .3s;
        transition: background-color .3s;
    }
    .navbar-search > input:focus {
        background-color: mix($observatory, black, 50);
    }
    .navbar-search > input::placeholder {
        color: rgba(255, 255, 255, 0.68);
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
        padding: 20px;
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
