<template>
    <div>
        <h3 class="headline">Receive Notifications</h3>
        <v-divider class="mb-3 mt-3"></v-divider>
        <v-alert type="success" border="left" v-show="success">
            Notification settings updated!
        </v-alert>
        <v-alert type="error" border="left" v-show="error">
            {{ error.message }}
            <ul>
                <li v-for="errorMessage in error.errors" class="caption">{{ errorMessage[0] }}</li>
            </ul>
        </v-alert>
        <v-switch v-model="settings.uploads" :disabled="loading" label="New tracks available (from other users)"></v-switch>
        <v-switch v-model="settings.messages" :disabled="loading" label="Chat messages"></v-switch>
        <v-switch v-model="settings.concerts" :disabled="loading" label="Nearby concert announcements"></v-switch>
        <v-divider class="mb-3 mt-3"></v-divider>
        <v-btn color="accent" @click="save" :loading="loading">Save</v-btn>
    </div>
</template>

<script>
    export default {
        name: "Notifications",
        data() {
            return {
                settings: {...this.$root.user.settings.notifications},
                loading: false,
                success: false,
                error: false,
            }
        },
        methods: {
            save() {
                this.loading = true;
                axios.post('/api/settings/notifications', this.settings)
                    .then(res => {
                        this.success = true;
                        this.error = false;
                        this.$root.user.settings = res.data;
                        setTimeout(() => this.success = false, 5000);
                    })
                    .catch(err => {
                        this.success = false;
                        this.error = err.response.data;
                    })
                    .finally(() => this.loading = false);
            }
        },
    }
</script>

<style scoped>

</style>