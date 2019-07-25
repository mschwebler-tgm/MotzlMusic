<template>
    <div>
        <h3 class="headline">General Information</h3>
        <v-divider class="mb-3 mt-3"></v-divider>
        <v-alert type="success" border="left" v-show="success">
            Privacy settings updated!
        </v-alert>
        <v-alert type="error" border="left" v-show="error">
            {{ error.message }}
            <ul>
                <li v-for="errorMessage in error.errors" class="caption">{{ errorMessage[0] }}</li>
            </ul>
        </v-alert>
        <v-text-field filled
                      v-model="user.name"
                      :disabled="loading"
                      class="nickname"
                      label="Nickname"></v-text-field>
        <v-text-field class="email" filled label="Email" :value="user.email" disabled></v-text-field>
        <v-chip class="mb-2" color="spotify" v-if="user.spotify_id" title="You are linked with your spotify account">
            <v-icon left>check_circle</v-icon>
            Spotify connected
        </v-chip>
        <v-divider class="mb-3 mt-3"></v-divider>
        <v-btn color="accent" @click="save" :loading="loading">Save</v-btn>
    </div>
</template>

<script>
    export default {
        name: "General",
        data() {
            return {
                user: {...this.$root.user},
                loading: false,
                success: false,
                error: false,
            }
        },
        methods: {
            save() {
                this.loading = true;
                axios.post('/api/settings/nickname', {name: this.user.name})
                    .then(res => {
                        this.success = true;
                        this.error = false;
                        this.$root.user.name = res.data;
                        setTimeout(() => this.success = false, 5000);
                    })
                    .catch(err => {
                        this.success = false;
                        this.error = err.response.data;
                    })
                    .finally(() => this.loading = false);
            }
        }
    }
</script>

<style scoped>
    .nickname {
        max-width: 250px;
    }

    .email {
        max-width: 400px;
    }
</style>
