<template>
    <div>
        <div class="justify-space-between pa-0 d-flex align-center">
            <v-btn text @click="$router.go(-1)" class="mt-2 mb-2">
                <v-icon dark left>arrow_back</v-icon>
                Back
            </v-btn>
            <v-divider class="mt-4 mb-4 ml-3" inset vertical></v-divider>
            <v-breadcrumbs :items="breadcrumbs" divider="-" class="pa-0 pl-3 mr-auto"></v-breadcrumbs>
            <div class="d-flex align-center justify-content-end ma-1">
                <status-info></status-info>
            </div>
        </div>
    </div>
</template>

<script>
    import StatusInfo from "../StatusInfo/StatusInfo";

    export default {
        name: "MainContentHeaderDefault",
        components: {StatusInfo},
        computed: {
            breadcrumbs() {
                return this.$route.meta.breadcrumb;
            }
        }
    }
</script>

<style scoped>

</style>
