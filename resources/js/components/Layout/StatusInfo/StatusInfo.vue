<template>
    <component v-if="$root.statusInfo.show" :is="$root.statusInfo.component" v-bind="$root.statusInfo.data"></component>
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