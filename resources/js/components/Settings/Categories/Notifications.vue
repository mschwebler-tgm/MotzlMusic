<template>
    <div>
        <h3 class="headline">Receive Notifications</h3>
        <v-divider class="mb-3 mt-3"></v-divider>
        <v-switch v-model="settings.uploads" label="New tracks available (from other users)"></v-switch>
        <v-switch v-model="settings.messages" label="Chat messages"></v-switch>
        <v-switch v-model="settings.concerts" label="Nearby concert announcements"></v-switch>
        <v-divider class="mb-3 mt-3"></v-divider>
        <v-btn color="accent" @click="save">Save</v-btn>
    </div>
</template>

<script>
    export default {
        name: "Notifications",
        data() {
            return {
                settings: {
                    uploads: true,
                    messages: true,
                    concerts: true,
                }
            }
        },
        methods: {
            save() {
                axios.post('/api/settings/notifications', this.settings);
            }
        },
    }
</script>

<style scoped>

</style>