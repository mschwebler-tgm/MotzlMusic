<template>
    <div class="box" v-if="show || true">
        <h3 class="title is-6">New tracks incoming! 😎
            <!--<b-icon icon="emoticon-cool-outline" type="is-primary"></b-icon>-->
        </h3>
        <div class="loader-wrapper">
            <template v-if="uploadInProgress">
                {{ doneFilesCount }}/{{ totalFilesCount }} Files
                <div class="flex-center">
                    <progress class="flex-1 progress is-primary is-small custom-progress"
                              :value="doneFilesCount"
                              :max="totalFilesCount"></progress>
                    <b-icon icon="loading" custom-class="fa-spin" type="is-primary"></b-icon>
                </div>
            </template>
            <template v-else>
                <div class="position-relative flex-center w-100">
                    <div class="checkmark draw" :class="{show: !uploadInProgress}"></div>
                </div>
            </template>
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
            },
            uploadInProgress() {
                return this.$store.getters['fileUpload/uploadInProgress'];
            }
        }
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/components/uploadInfoBox.scss";

    .custom-progress {
        margin: 0 10px 0 0;
    }

    .loader-wrapper {
        height: $loader-size;
    }

    .show {
        display: block;
    }

</style>