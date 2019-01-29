<template>
    <div class="box position-relative" v-if="show || true">
        <h3 class="title is-6 position-relative">
            <template v-if="uploadInProgress">New tracks incoming! 😎</template>
            <template v-else>Upload complete!</template>
            <b-icon icon="close" size="is-small" custom-class="close-button" v-if="!uploadInProgress"></b-icon>
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
                <div class="upload-complete">
                    <div class="line"></div>
                    <div class="checkmark draw" :class="{show: !uploadInProgress}"></div>
                    <div class="line"></div>
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

<style lang="scss">
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

    .close-button {
        position: absolute;
        top: 2px;
        right: 0;
        cursor: pointer;
    }

</style>