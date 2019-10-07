<template>
    <div class="pa-3">
        <v-simple-table dense height="300px" class="current-tracks-table">
            <tbody>
                <tr v-for="track in tracks" :key="track.id">
                    <td></td>
                    <td>
                        <div class="track-title text-truncate">
                        {{ track.name }}
                        </div>
                    </td>
                    <td class="text-truncate">{{ track.artists[0].name }}</td>
                </tr>
            </tbody>
        </v-simple-table>
    </div>
</template>

<script>
    export default {
        name: "CurrentTracks",
        computed: {
            tracks() {
                return this.$store.getters['player/trackList'];
            }
        }
    }
</script>

<style lang="scss">
    .current-tracks-table {
        .v-data-table__wrapper::-webkit-scrollbar {
            display: none;
        }

        .track-title {
            width: 100px;
        }
    }
</style>
