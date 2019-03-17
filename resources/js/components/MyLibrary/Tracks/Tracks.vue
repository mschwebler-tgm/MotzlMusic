<template>
    <div>
        <v-card-title class="headline">Tracks</v-card-title>
        <v-container>
            <v-layout column class="clusterize">
                <track-table :tracks="tracks" :render-function="renderFunction" height="691px"></track-table>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
    import TrackTable from "../../TrackTable";
    import renderFunction from '../../../store/modules/myLibrary/helpers/clusterizeTracks';

    export default {
        name: "Tracks",
        components: {TrackTable},
        data() {
            return {
                scrollContainerHeight: '691px',
                renderFunction,
            }
        },
        computed: {
            tracks() {
                return this.$store.getters['myLibrary/tracks'];
            },
        }
    }
</script>

<style lang="scss">

</style>
