<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <v-data-table
            id="spotify-track-import-smaller-rows"
            color="spotify"
            v-model="selected"
            :headers="headers"
            :loading="loading"
            :items="tracks.items"
            :total-items="tracks.total"
            :pagination.sync="pagination"
            :rows-per-page-items="[5]">
        <template v-slot:items="props">
            <td>{{ props.item.name }}</td>
            <td>{{ getFormattedDuration(props.item) }}</td>
            <td>{{ props.item.artist }}</td>
        </template>
    </v-data-table>
</template>

<script>
    export default {
        name: "ImportTracks",
        data() {
            return {
                headers: [
                    {
                        text: 'Title',
                        value: 'name',
                        align: 'left',
                        sortable: false,
                    },
                    {
                        text: 'Duration',
                        value: 'duration',
                        align: 'left',
                        sortable: false,
                    },
                    {
                        text: 'Artist',
                        value: 'artist',
                        align: 'left',
                        sortable: false,
                    },
                ],
                tracks: {
                    items: [],
                    total: 0,
                },
                pagination: {},
                selected: [],
                loading: false,
                cancelToken: null,
            }
        },
        watch: {
            'pagination': {
                handler() {
                    this.cancelOldRequests();
                    this.loadPage();
                },
                deep: true
            }
        },
        created() {
            this.loadPage();
        },
        methods: {
            loadPage() {
                if (_.isEmpty(this.pagination)) {
                    return;
                }
                this.loading = true;
                this.makeRequest().then(res => {
                    this.tracks = res.data;
                    this.loading = false;
                });
            },
            makeRequest() {
                const CancelToken = axios.CancelToken;
                this.cancelToken = CancelToken.source();
                return axios.get('/api/spotify/tracks/my', {
                    params: {
                        page: this.pagination.page,
                        limit: this.pagination.rowsPerPage,
                    },
                    cancelToken: this.cancelToken.token,
                });
            },
            cancelOldRequests() {
                if (this.cancelToken) {
                    this.cancelToken.cancel('Canceled by the user');
                }
            },
            getFormattedDuration(track) {
                const durationSec = track.duration / 1000;
                let minutes = Math.floor(durationSec / 60);
                let seconds = Math.floor(durationSec - minutes * 60);
                seconds = seconds < 10 ? `0${seconds}` : seconds;

                return `${minutes}:${seconds}`;
            }
        }
    }
</script>

<style>
    #spotify-track-import-smaller-rows tr,
    #spotify-track-import-smaller-rows td {
        height: 30px !important;
    }

    #spotify-track-import-smaller-rows .v-datatable__progress {
        height: 3px !important;
    }
</style>