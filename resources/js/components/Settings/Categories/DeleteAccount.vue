<template>
    <div>
        <h3 class="headline">Delete your account</h3>
        <v-divider class="mb-3 mt-3"></v-divider>
        <v-text-field label="Confirm your password" type="password" filled class="password"></v-text-field>
        <v-btn class="error">Delete account</v-btn>
    </div>
</template>

<script>
    export default {
        name: "DeleteAccount"
    }
</script>

<style scoped>
    .password {
        max-width: 250px;
    }
</style>
