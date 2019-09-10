<template>
    <div>
        <spotify-player></spotify-player>
    </div>
</template>

<script>
    import SpotifyPlayer from "./Spotify/SpotifyPlayer";

    export default {
        name: "Player",
        components: {SpotifyPlayer},
    }
</script>

<style scoped>

</style>
