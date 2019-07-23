<template>
    <div>
        <div class="relative">
            <h3 class="headline">Visibility to other users</h3>
            <v-switch v-model="settings.incognito" class="incognito">
                <template slot="label">
                    I want to be a ghost&nbsp;&nbsp;
                    <v-icon disabled>perm_identity</v-icon>
                </template>
            </v-switch>
        </div>
        <v-divider class="mb-3 mt-3"></v-divider>
        <v-switch v-model="settings.like_activity"
                  :disabled="settings.incognito"
                  label="Other people see my likes"></v-switch>
        <v-switch v-model="settings.online_status"
                  :disabled="settings.incognito"
                  label="Online status"></v-switch>
        <v-switch v-model="settings.post_uploads"
                  :disabled="settings.incognito"
                  label="Post my uploads"></v-switch>
        <v-switch v-model="settings.show_name_on_posts"
                  :disabled="settings.incognito"
                  label="Show my nickname on posts"></v-switch>
        <v-select v-model="settings.profile_visibility"
                  :items="profileVisibilities"
                  :disabled="settings.incognito"
                  label="Profile visibility"
                  class="profile-visibility"
                  box></v-select>
        <v-divider class="mb-3 mt-3"></v-divider>
        <v-btn color="accent" @click="save">Save</v-btn>
    </div>
</template>

<script>
    export default {
        name: "Privacy",
        data() {
            return {
                settings: {
                    incognito: false,
                    like_activity: true,
                    online_status: true,
                    post_uploads: true,
                    show_name_on_posts: false,
                    profile_visibility: 'friends',
                },
                profileVisibilities: [
                    {text: 'Everybody', value: 'everybody'},
                    {text: 'Friends only', value: 'friends'},
                    {text: 'Nobody', value: 'nobody'},
                ]
            }
        },
        methods: {
            save() {
                alert('Coming soon');
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
