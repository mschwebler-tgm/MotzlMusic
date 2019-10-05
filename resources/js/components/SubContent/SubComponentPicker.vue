<template>
    <v-flex class="sub-component-picker h-100">
        <div class="main-content-header-spacer"></div>
        <v-container class="sub-components relative pl-5">
            <div class="sub-component-picker-buttons mr-2">
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
                       color="primary lighten-2">
                    <v-icon left>save</v-icon>
                    Save
                </v-btn>
            </div>
            <div v-for="contentGroup in availableComponents" :key="contentGroup.label">
                <div class="display-1 mb-2 mt-2">{{ contentGroup.label }}</div>
                <div class="d-flex flex-wrap">
                    <div class="mb-5 mr-5" v-for="contentItem in contentGroup.items" :key="contentItem.label">
                        <v-card class="elevation-10">
                            <component :is="contentItem.component" v-once class="content-component"></component>
                            <v-divider></v-divider>
                            <v-system-bar lights-out window>
                                <div class="w-100 text-sm-center font-weight-regular">{{ contentItem.label }}</div>
                            </v-system-bar>
                        </v-card>
                    </div>
                </div>
            </div>
        </v-container>
    </v-flex>
</template>

<script>
    import AudioFeatures from "$scripts/components/SubContent/Components/AudioFeatures";
    import PlayerControls from "$scripts/components/SubContent/Components/PlayerControls";
    import TrackInfo from "$scripts/components/SubContent/Components/TrackInfo";

    export default {
        name: "SubComponentPicker",
        components: {AudioFeatures, PlayerControls, TrackInfo},
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
            },
            availableComponents() {
                return this.$store.getters['subContent/availableSubContent'];
            }
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";


    .sub-component-picker {
        position: absolute;
        z-index: 10;
        width: 75%;
        overflow-y: scroll;
        display: flex;
        flex-direction: column;

        &::-webkit-scrollbar {
            display: none;
        }
    }

    .main-content-header-spacer {
        min-height: $main-content-header-height;
    }

    .sub-components {
        flex: 1;
        overflow-y: scroll;

        &::-webkit-scrollbar {
            display: none;
        }
    }

    .sub-component-picker-buttons {
        position: sticky;
        float: right;
        top: 5px;
    }

    .content-component {
        min-width: 380px;
        pointer-events: none;
    }

</style>