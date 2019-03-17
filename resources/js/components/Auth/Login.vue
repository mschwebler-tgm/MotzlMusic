<template>
    <v-flex lg4 md8 sm8 xs12>
        <div class="item elevation-5 pa-4">
            <h1 class="display-2 font-weight-light">Login</h1>
            <v-divider class="mb-3 mt-3"></v-divider>
            <v-form lazy-validation method="POST" action="/login" id="login-form">
                <input type="hidden" name="_token" :value="csrf">
                <v-text-field solo required single-line
                              id="email"
                              name="email"
                              label="E-mail"
                              :rules="emailRules"
                              :error-messages="errors.email"
                              browser-autocomplete="off">
                </v-text-field>
                <v-text-field solo required single-line
                              id="password"
                              name="password"
                              label="Password"
                              browser-autocomplete="off"
                              :append-icon="showPassword ? 'visibility' : 'visibility_off'"
                              :type="showPassword ? 'text' : 'password'"
                              :error-messages="errors.password"
                              @click:append="showPassword = !showPassword">
                </v-text-field>
                <v-checkbox
                        name="remember"
                        id="remember"
                        label="'member me">
                </v-checkbox>
                <v-layout justify-space-between align-center row>

                    <v-progress-linear :indeterminate="true" v-show="loading"></v-progress-linear>
                    <div v-show="!loading">
                        <v-btn class="primary"
                               type="submit"
                               @click="loading = true">Login</v-btn>
                        <v-btn tag="a"
                               class="primary"
                               href="/register"
                               outline>Register
                        </v-btn>
                    </div>
                    <v-btn v-show="!loading"
                           flat right
                           :ripple="false"
                           tag="a"
                           href="/password/reset"
                           color="primary">
                        Forgot your password?
                    </v-btn>
                </v-layout>
            </v-form>
        </div>
        <v-layout justify-center row class="mt-4">
            <v-btn flat
                   tag="a"
                   color="spotify"
                   class="text--spotify"
                   href="/spotify/authorize">
                Use Spotify to login
            </v-btn>
        </v-layout>
    </v-flex>
</template>

<script>
    export default {
        name: "Login",
        props: ['csrf', 'errors'],
        data() {
            return {
                emailRules: [
                    email => !!email || 'E-mail is required',
                    email => /.+@.+/.test(email) || 'E-mail must be valid'
                ],
                showPassword: false,
                loading: false,
            }
        }
    }
</script>

<style scoped>

</style>
