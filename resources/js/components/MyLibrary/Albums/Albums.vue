<template>
    <div>
        <v-progress-circular
                v-if="!$parent.albumsInitialized"
                color="primary"
                indeterminate>
        </v-progress-circular>
        <span class="headline">Albums</span>
    </div>
</template>

<script>
    export default {
        name: "Albums"
    }
</script>

<style scoped>

</style>