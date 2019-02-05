<template>
    <div id="master">

    </div>
</template>

<script>
    export default {
        name: "master",
        props: ['user'],
        created() {
            this.$root.showSpotifyImport = this.user && !this.user.spotify_import_complete;
        },
    }
</script>

<style scoped lang="scss">
</style>
