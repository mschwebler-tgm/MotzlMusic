<template>
    <v-flex class="sub-component-picker">
        <div class="justify-end d-flex">
            <v-btn text class="mt-2 mb-3 mr-2" outlined>
                <v-icon left>close</v-icon>
                Cancel
            </v-btn>
            <v-btn text class="mt-2 mb-3" outlined color="primary lighten-2">
                <v-icon left>save</v-icon>
                Save
            </v-btn>
        </div>
        <div class="display-2">
            Visualization
        </div>
        <div class="display-2">
            Player controls
        </div>
    </v-flex>
</template>

<script>
    export default {
        name: "SubComponentPicker"
    }
</script>

<style scoped>
    .sub-component-picker {
        position: absolute;
        z-index: 10;
        width: 75%;
    }
</style>