<template>
    <div class="d-flex align-center">
        <div class="caption mr-2 grey--text">{{ text }}</div>
        <v-progress-circular indeterminate
                             color="primary darken-3"
                             size="20"
                             width="2"></v-progress-circular>
    </div>
</template>

<script>
    export default {
        name: "StatusInfoGeneric",
        props: {
            text: String,
        }
    }
</script>

<style scoped>

</style>
