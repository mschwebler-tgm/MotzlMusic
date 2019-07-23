<template>
    <div class="justify-space-between pa-0" style="display: flex;">
        <v-btn flat @click="$router.go(-1)" class="ml-0" style="flex: 0 !important;">
            <v-icon dark left>arrow_back</v-icon>
            Back
        </v-btn>
        <div class="d-flex align-center justify-content-end ma-1">
            <status-info></status-info>
        </div>
    </div>
</template>

<script>
    import StatusInfo from "../StatusInfo/StatusInfo";

    export default {
        name: "MainContentHeaderDefault",
        components: {StatusInfo}
    }
</script>

<style scoped>

</style>
