<template>
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
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        {{ $parent.user.name }}
                    </a>

                    <div class="navbar-dropdown">
                        <a class="navbar-item">
                            Settings
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" @click="$root.showSpotifyImport = true">
                            <img src="/images/spotify_black.png" height="20"/>
                            &nbsp;&nbsp;Import
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "Navbar"
    }
</script>

<style scoped lang="scss">
    @import "~bulma/sass/utilities/initial-variables";
    @import "../../../sass/_variables.scss";

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
</style>