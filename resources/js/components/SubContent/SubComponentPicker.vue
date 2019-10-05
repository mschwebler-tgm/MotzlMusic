<template>
    <v-flex class="sub-component-picker">
        <div class="justify-end d-flex">
            <v-btn text outlined
                   @click="cancelEdit"
                   class="mt-2 mb-3 mr-2">
                <v-icon left>close</v-icon>
                Cancel
            </v-btn>
            <v-btn text outlined
                   :loading="isLoading"
                   @click="save"
                   class="mt-2 mb-3"
                   color="primary lighten-2" >
                <v-icon left>save</v-icon>
                Save
            </v-btn>
        </div>
        <v-container>
            <div class="display-2">
                Visualization
            </div>
            <div class="display-2">
                Player controls
            </div>
        </v-container>
    </v-flex>
</template>

<script>
    export default {
        name: "SubComponentPicker",
        methods: {
            cancelEdit() {
                this.$store.commit('subContent/cancelEditMode');
            },
            save() {
                this.$store.dispatch('subContent/saveEdit');
            },
        },
        computed: {
            isLoading() {
                return this.$store.getters['subContent/subContentIsSaving'];
            }
        },
    }
</script>

<style scoped>
    .sub-component-picker {
        position: absolute;
        z-index: 10;
        width: 75%;
    }
</style>