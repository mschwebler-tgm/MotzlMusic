<template>
    <div id="master">
        <nav class="navbar is-fixed-top is-primary" role="navigation" aria-label="main navigation">
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
    </div>
</template>

<script>
    export default {
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

<style scoped>
    #master {
        width: 100vw;
        height: 100vh;
    }
    .navbar-search {
        display: flex;
        align-items: center;
        flex: 1;
        padding-left: 10%;
        padding-right: 10%;
    }
    .navbar-search > input {
        width: 100%;
        background-color: rgba(0, 0, 0, 0.3);
        font-size: 20px;
        color: white;
        border: none;
        border-radius: 40px;
        padding: 8px 8px 8px 25px;
        outline: none;
    }
    .navbar-search > input::placeholder {
        color: rgba(255, 255, 255, 0.68);
    }
</style>
