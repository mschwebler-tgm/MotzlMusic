<template>
    <component v-if="$root.statusInfo.show" :is="$root.statusInfo.component" v-bind="$root.statusInfo.data"></component>
</template>

<script>
    import StatusInfoFileUpload from "./StatusInfoFileUpload";
    import StatusInfoGeneric from "./StatusInfoGeneric";

    export default {
        name: "StatusInfo",
        components: {StatusInfoGeneric, StatusInfoFileUpload}
    }
</script>

<style scoped>

</style>
