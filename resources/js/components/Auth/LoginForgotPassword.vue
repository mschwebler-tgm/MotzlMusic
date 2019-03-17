<template>
    <div>
        <h2 class="headline font-weight-thin text-xs-center mb-5">Reset Your Password</h2>
        <v-text-field solo required single-line light
                      v-model="email"
                      :loading="loading"
                      :rules="emailRules"
                      :disabled="emailWasSent"
                      id="forgot_email"
                      label="E-mail"
                      name="email"
                      browser-autocomplete="off">
        </v-text-field>
        <v-btn block
               :loading="loading"
               :disabled="emailWasSent"
               class="primary"
               @click="resetPassword">
            {{ emailWasSent ? 'Email was sent' : 'Send Password Reset Link' }}
        </v-btn>
    </div>
</template>

<script>
    export default {
        name: "LoginForgotPassword",
        props: {
            showBackButton: Boolean,
        },
        data() {
            return {
                email: 'asdaasdas@asdad.asd',
                emailRules: [
                    email => !!email || 'E-mail is required',
                    email => /.+@.+\..+/.test(email) || 'E-mail must be valid'
                ],
                loading: false,
                emailWasSent: false,
            }
        },
        methods: {
            resetPassword() {
                const emailIsValid = this.emailRules[1](this.email);
                if (emailIsValid !== true) {
                    return;
                }

                this.loading = true;
                const formData = new FormData();
                formData.append('email', this.email);
                axios.post('/password/email', formData)
                    .then(() => {
                        this.loading = false;
                        this.emailWasSent = true;
                        this.$emit('update:showBackButton', true);
                    })
                    .catch(() => {
                        this.loading = false;
                    })
            }
        }
    }
</script>

<style scoped>

</style>
