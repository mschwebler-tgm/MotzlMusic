<template>
    <div class="box" v-if="show">
        <h3 class="title is-6">New tracks incoming! 😎
            <!--<b-icon icon="emoticon-cool-outline" type="is-primary"></b-icon>-->
        </h3>
        {{ doneFilesCount }}/{{ totalFilesCount }} Files
        <div class="flex-center">
            <progress class="flex-1 progress is-primary is-small custom-progress"
                      :value="doneFilesCount"
                      :max="totalFilesCount"></progress>
            <b-icon icon="loading" custom-class="fa-spin" type="is-primary"></b-icon>
        </div>
    </div>
</template>

<script>
    import BIcon from "buefy/src/components/icon/Icon";

    export default {
        name: "UploadInfoBox",
        components: {BIcon},
        computed: {
            show() {
                return this.$store.getters['fileUpload/uploadInProgress'] &&
                    this.totalFilesCount;
            },
            doneFilesCount() {
                return this.totalFilesCount - this.$store.getters['fileUpload/remainingFilesCount'];
            },
            totalFilesCount() {
                return this.$store.getters['fileUpload/totalFilesCount'];
            }
        }
    }
</script>

<style scoped>
    .custom-progress {
        margin: 0 10px 0 0;
    }
</style>