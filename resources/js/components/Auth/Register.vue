<template>
    <v-flex lg4 md8 sm8 xs12>
        <div class="item elevation-24 pa-4 login-card grey darken-4 register-panel">
            <h1 class="display-2 font-weight-light text-xs-center">Register</h1>
            <v-divider class="mb-3 mt-3"></v-divider>
            <v-form lazy-validation method="POST" action="/register" id="register-form">
                <input type="hidden" name="_token" :value="csrf">
                <v-text-field solo required single-line light
                              id="name"
                              name="name"
                              label="Name"
                              :error-messages="errors.name"
                              browser-autocomplete="off">
                </v-text-field>
                <v-text-field solo required single-line light
                              v-model="email"
                              id="email"
                              name="email"
                              label="E-mail"
                              :rules="emailRules"
                              :error-messages="errors.email"
                              browser-autocomplete="off">
                </v-text-field>
                <v-text-field solo required single-line light
                              id="password"
                              name="password"
                              label="Password"
                              browser-autocomplete="off"
                              :append-icon="showPassword ? 'visibility' : 'visibility_off'"
                              :type="showPassword ? 'text' : 'password'"
                              :error-messages="errors.password"
                              @click:append="showPassword = !showPassword">
                </v-text-field>
                <v-text-field solo required single-line light
                              id="password-confirm"
                              name="password_confirmation"
                              label="Confirm Password"
                              browser-autocomplete="off"
                              :append-icon="showPassword ? 'visibility' : 'visibility_off'"
                              :type="showPassword ? 'text' : 'password'"
                              :error-messages="errors.password"
                              @click:append="showPassword = !showPassword">
                </v-text-field>
                <v-progress-linear :indeterminate="true" v-show="loading" color="success"></v-progress-linear>
                <div v-show="!loading">
                    <v-btn class="success"
                           type="submit"
                           @click="loading = true">Register
                    </v-btn>
                    <v-btn tag="a"
                           class="success"
                           href="/login"
                           outline>Already have an account?
                    </v-btn>
                </div>
            </v-form>
        </div>
        <v-layout justify-center row class="mt-4">
            <v-btn depressed
                   tag="a"
                   color="spotify grey darken-4"
                   class="elevation-2"
                   href="/spotify/authorize">
                Use Spotify to create an account
            </v-btn>
        </v-layout>
    </v-flex>
</template>

<script>
    export default {
        name: "Register",
        props: ['csrf', 'errors'],
        data() {
            return {
                email: '',
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
