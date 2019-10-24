<template>
    <v-flex lg4 md8 sm8 xs12 class="white--text">
        <div class="item elevation-24 pa-4 login-card grey darken-4 login-panel">
            <v-btn text icon absolute dark v-if="showForgotPassword" @click="showForgotPassword = false" aria-label="Back">
                <v-icon>arrow_back</v-icon>
            </v-btn>
            <h1 class="display-2 font-weight-light text-center">Login</h1>
            <v-divider class="mb-3 mt-3"></v-divider>
            <auth-login-form v-show="!showForgotPassword"
                             ref="loginForm"
                             :csrf="csrf"
                             :errors="errors"
                             :showForgotPassword.sync="showForgotPassword"></auth-login-form>
            <login-forgot-password v-show="showForgotPassword"
                                   @emailSent="resetEmailWasSent"></login-forgot-password>
        </div>
        <v-layout justify-center row class="mt-4">
            <v-btn depressed
                   tag="a"
                   aria-label="Use Spotify to login"
                   color="spotify"
                   class="elevation-2 black--text"
                   href="/spotify/authorize">
                Use Spotify to login
            </v-btn>
        </v-layout>
    </v-flex>
</template>

<script>
    import AuthLoginForm from "./LoginForm";
    import LoginForgotPassword from "./LoginForgotPassword";

    export default {
        name: "AuthLogin",
        components: {LoginForgotPassword, AuthLoginForm},
        props: ['csrf', 'errors', 'oldEmail'],
        data() {
            return {
                showForgotPassword: false,
            }
        },
        mounted() {
            this.$refs.loginForm.email = this.oldEmail || '';
        },
        methods: {
            resetEmailWasSent(email) {
                this.$refs.loginForm.email = email;
            },
        }
    }
</script>

<style scoped>

</style>
