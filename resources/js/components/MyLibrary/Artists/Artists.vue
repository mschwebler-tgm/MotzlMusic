<template>
    <div>
        <v-progress-circular
                v-if="!$parent.artistsInitialized"
                color="primary"
                indeterminate>
        </v-progress-circular>
        <span class="headline">Artists</span>
    </div>
</template>

<script>
    export default {
        name: "Artists"
    }
</script>

<style scoped>

</style>