<template>
    <v-form lazy-validation method="POST" action="/login" id="login-form">
        <input type="hidden" name="_token" :value="csrf">
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
        <v-checkbox
                dark
                name="remember"
                id="remember"
                label="'member me">
        </v-checkbox>
        <v-layout justify-space-between align-center row class="pa-3">
            <v-progress-linear :indeterminate="true" v-show="loading"></v-progress-linear>
            <div v-show="!loading">
                <v-btn color="primary"
                       type="submit"
                       aria-label="Login"
                       @click="loading = true">Login</v-btn>
                <v-btn tag="a"
                       color="primary"
                       href="/register"
                       aria-label="Register"
                       outlined>Register
                </v-btn>
            </div>
            <v-btn v-show="!loading"
                   text right
                   :ripple="false"
                   @click="$emit('update:showForgotPassword', true)"
                   color="primary">
                Forgot your password?
            </v-btn>
        </v-layout>
    </v-form>
</template>

<script>
    export default {
        name: "AuthLoginForm",
        props: ['csrf', 'errors', 'showForgotPassword'],
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