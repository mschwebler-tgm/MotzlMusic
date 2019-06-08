<template>
    <component v-if="$root.statusInfoComponent" :is="$root.statusInfoComponent"></component>
</template>

<script>
    import StatusInfoFileUpload from "./StatusInfoFileUpload";
    export default {
        name: "StatusInfo",
        components: {StatusInfoFileUpload}
    }
</script>

<style scoped>

</style>