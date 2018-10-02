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
                        <div class="buttons">
                            <a class="button is-primary">
                                <strong>Sign up</strong>
                            </a>
                            <a class="button is-light">
                                Log in
                            </a>
                        </div>
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
            <div class="content">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
    import Index from "./Ideas/Gauss/Index";

    export default {
        components: {Index},
        name: "master",
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
    .content-wrapper > .content {
        flex: 1;
        padding: 20px;
    }

    .menu {
        padding: 15px;
        border-right: 1px solid $turquoise;
    }
    #upload-button {
        width: $menu-width - 30px;
        position: absolute;
        bottom: 15px;
    }
</style>
