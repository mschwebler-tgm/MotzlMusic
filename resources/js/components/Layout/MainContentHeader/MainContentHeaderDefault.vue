<template>
    <div class="justify-space-between pa-0 d-flex align-center">
        <v-btn text @click="$router.go(-1)" class="mt-2 mb-3">
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
