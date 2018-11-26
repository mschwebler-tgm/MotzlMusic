<template>
    <div class="modal-card spotify">
        <header class="modal-card-head">
            <img src="/images/spotify_black.png" width="50px">
            <p class="modal-card-title">&nbsp;&nbsp;Import from Spotify</p>
        </header>
        <section class="modal-card-body">
            You can import your favourite tracks, albums and playlists from spotify.<br><br>
            <div class="field">
                <b-checkbox>Import saved tracks</b-checkbox>
            </div>
            <div class="field">
                <b-checkbox>Import albums</b-checkbox>
            </div>
            <div class="field">
                <b-checkbox>Import playlists</b-checkbox>
            </div>
        </section>
        <footer class="modal-card-foot">
            <button class="button is-success">Import</button>
            <button class="button">Cancel</button>
        </footer>
    </div>
</template>

<script>
    export default {
        name: "Importer"
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/_variables.scss";

</style>
