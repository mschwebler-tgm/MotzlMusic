<template>
    <v-flex lg4 md8 sm8 xs12>
        <div class="item elevation-24 pa-4 login-card grey darken-4 login-panel">
            <h1 class="display-2 font-weight-light text-xs-center">Login</h1>
            <v-divider class="mb-3 mt-3"></v-divider>
            <auth-login-form v-show="!showForgotPassword"
                             :csrf="csrf"
                             :errors="errors"
                             :showForgotPassword.sync="showForgotPassword"></auth-login-form>
        </div>
        <v-layout justify-center row class="mt-4">
            <v-btn depressed
                   tag="a"
                   color="spotify grey darken-4"
                   class="elevation-2"
                   href="/spotify/authorize">
                Use Spotify to login
            </v-btn>
        </v-layout>
    </v-flex>
</template>

<script>
    import AuthLoginForm from "./LoginForm";
    export default {
        name: "AuthLogin",
        components: {AuthLoginForm},
        props: ['csrf', 'errors'],
        data() {
            return {
                showForgotPassword: false,
            }
        }
    }
</script>

<style scoped>

</style>
