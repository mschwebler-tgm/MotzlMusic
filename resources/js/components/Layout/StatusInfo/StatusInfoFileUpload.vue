<template>
    <div class="d-flex align-center">
        <div class="caption mr-2 grey--text text--darken-1">{{ uploadText }} {{ totalFilesCount - remainingFilesCount }}/{{ totalFilesCount }}</div>
        <v-progress-circular :value="progressInPercent"
                             color="primary darken-3"
                             size="20"
                             width="2"></v-progress-circular>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        name: "StatusInfoFileUpload",
        data() {
            return {
                uploadText: 'Uploading tracks...',
            }
        },
        watch: {
            uploadInProgress(isInProgress) {
                this.uploadText = isInProgress ? 'Uploading tracks...' : 'Upload done';
            }
        },
        computed: {
            ...mapGetters('fileUpload', [
                'files',
                'totalFilesCount',
                'remainingFilesCount',
                'filesUnableToUpload',
                'uploadInProgress',
                'showInfoBox',
                'progressInPercent',
            ]),
        },
    }
</script>

<style scoped>

</style>