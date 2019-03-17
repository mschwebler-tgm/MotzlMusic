<template>
    <div class="item elevation-5 pa-4">
        <h1 class="display-2 font-weight-light">Login</h1>
        <v-divider class="mb-3 mt-3"></v-divider>
        <v-form lazy-validation method="POST" action="/login" id="login-form">
            <input type="hidden" name="_token" :value="csrf">
            <v-text-field box required
                          id="email"
                          name="email"
                          label="E-mail">
            </v-text-field>
            <v-text-field box required
                          id="password"
                          type="password"
                          name="password"
                          label="Password">
            </v-text-field>
            <input type="hidden" name="_token" :value="csrf">
            <v-btn class="primary" type="submit">Login</v-btn>
            <v-btn tag="a"
                   class="primary"
                   href="/register"
                   outline>Register</v-btn>
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