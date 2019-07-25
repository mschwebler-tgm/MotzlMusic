<template>
    <div>
        <div class="relative">
            <h3 class="headline">Visibility to other users</h3>
            <v-switch v-model="settings.incognito" class="incognito" :disabled="loading">
                <template slot="label">
                    I want to be a ghost&nbsp;&nbsp;
                    <v-icon disabled>perm_identity</v-icon>
                </template>
            </v-switch>
        </div>
        <v-divider class="mb-3 mt-3"></v-divider>
        <v-alert type="success" border="left" v-show="success">
            Privacy settings updated!
        </v-alert>
        <v-alert type="error" border="left" v-show="error">
            {{ error }}
        </v-alert>
        <v-switch v-model="settings.like_activity"
                  :disabled="settings.incognito || loading"
                  label="Other people see my likes"></v-switch>
        <v-switch v-model="settings.online_status"
                  :disabled="settings.incognito || loading"
                  label="Online status"></v-switch>
        <v-switch v-model="settings.post_uploads"
                  :disabled="settings.incognito || loading"
                  label="Post my uploads"></v-switch>
        <v-switch v-model="settings.show_name_on_posts"
                  :disabled="settings.incognito || loading"
                  label="Show my nickname on posts"></v-switch>
        <v-select v-model="settings.profile_visibility"
                  :items="profileVisibilities"
                  :disabled="settings.incognito || loading"
                  label="Profile visibility"
                  class="profile-visibility"
                  filled></v-select>
        <v-divider class="mb-3 mt-3"></v-divider>
        <v-btn color="accent" @click="save" :loading="loading">Save</v-btn>
    </div>
</template>

<script>
    export default {
        name: "Privacy",
        data() {
            return {
                settings: {...this.$root.user.settings.privacy},
                profileVisibilities: [
                    {text: 'Everybody', value: 'everybody'},
                    {text: 'Friends only', value: 'friends'},
                    {text: 'Nobody', value: 'nobody'},
                ],
                loading: false,
                success: false,
                error: false,
            }
        },
        methods: {
            save() {
                this.loading = true;
                axios.post('/api/settings/privacy', this.settings)
                    .then(res => {
                        this.success = true;
                        this.error = false;
                        this.$root.user.settings = res.data;
                        setTimeout(() => this.success = false, 5000);
                    })
                    .catch(err => this.error = err.message)
                    .finally(() => this.loading = false);
            }
        },
    }
</script>

<style scoped>
    .profile-visibility {
        max-width: 200px;
    }

    .incognito {
        position: absolute;
        top: 0;
        right: 0;
        margin-top: 0;
    }
</style>
