<template>
    <div class="item elevation-5 pa-4">
        <h1 class="display-2 font-weight-light">Login</h1>
        <v-divider class="mb-3 mt-3"></v-divider>
        <v-form lazy-validation method="POST" action="/login" id="login-form">
            <input type="hidden" name="_token" :value="csrf">
            <v-text-field box required
                          id="email"
                          name="email"
                          label="E-mail"
                          autocomplete="off">
            </v-text-field>
            <v-text-field box required
                          id="password"
                          type="password"
                          name="password"
                          label="Password"
                          autocomplete="off">
            </v-text-field>
            <v-checkbox
                    name="remember"
                    id="remember"
                    label="'member me"
            ></v-checkbox>
            <v-layout justify-space-between align-center row>
                <div>
                    <v-btn class="primary" type="submit">Login</v-btn>
                    <v-btn tag="a"
                           class="primary"
                           href="/register"
                           outline>Register</v-btn>
                </div>
                <v-btn flat right
                       :ripple="false"
                       tag="a"
                       href="/password/reset"
                       color="primary">
                    Forgot your password?
                </v-btn>
            </v-layout>
        </v-form>
    </div>
</template>

<script>
    export default {
        name: "Login",
        props: ['csrf'],
        data() {
            return {
                emailRules: [
                    email => !!email || 'E-mail is required',
                    email => /.+@.+/.test(email) || 'E-mail must be valid'
                ]
            }
        }
    }
</script>

<style scoped>

</style>