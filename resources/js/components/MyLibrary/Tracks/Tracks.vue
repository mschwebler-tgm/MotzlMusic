<template>
    <div>
        <v-progress-circular
                v-if="!$parent.tracksInitialized"
                color="primary"
                indeterminate>
        </v-progress-circular>
        <span class="headline">Tracks</span>
    </div>
</template>

<script>
    export default {
        name: "Tracks"
    }
</script>

<style scoped>

</style>