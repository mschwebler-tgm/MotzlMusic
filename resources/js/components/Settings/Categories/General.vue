<template>
    <div>
        <h3 class="headline">General Information</h3>
        <v-divider class="mb-3 mt-3"></v-divider>
        <v-text-field class="nickname" box label="Nickname" v-model="user.name"></v-text-field>
        <v-text-field class="email" box label="Email" :value="user.email" disabled></v-text-field>
        <v-chip class="mb-2" outline color="spotify" v-if="user.spotify_id" title="You are linked with your spotify account">
            <v-avatar>
                <v-icon>check_circle</v-icon>
            </v-avatar>
            Spotify connected
        </v-chip>
        <v-divider class="mb-3 mt-3"></v-divider>
        <v-btn color="accent" @click="save">Save</v-btn>
    </div>
</template>

<script>
    export default {
        name: "General",
        data() {
            return {
                user: {...this.$root.user}
            }
        },
        methods: {
            save() {
                alert('Coming soon');
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
