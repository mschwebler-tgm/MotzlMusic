<template>
    <div class="box position-relative" v-if="show">
        <div class="title is-6 position-relative">
            <template v-if="uploadInProgress">New tracks incoming! 😎</template>
            <template v-else>Upload complete<template v-if="!uploadSuccessful">d with failures</template>!</template>
            <div class="close-button delete" @click="close()" v-if="!uploadInProgress"></div>
            <b-icon icon="cloud-upload" custom-class="upload-icon-top-right" type="is-grey" v-else></b-icon>
        </div>
        <div class="loader-wrapper">
            <!-- UPLOAD IN PROGRESS -->
            <template v-if="uploadInProgress">
                {{ doneFilesCount }}/{{ totalFilesCount }} Files
                <div class="flex-center">
                    <progress class="flex-1 progress is-primary is-small custom-upload-progress"
                              :value="doneFilesCount"
                              :max="totalFilesCount"></progress>
                    <b-icon icon="loading" custom-class="fa-spin" type="is-primary"></b-icon>
                </div>
            </template>
            <!-- UPLOAD COMPLETED SUCCESSFULLY -->
            <template v-else-if="uploadSuccessful">
                <div class="upload-complete">
                    <div class="line"></div>
                    <div class="checkmark draw" :class="{show: !uploadInProgress}"></div>
                    <div class="line"></div>
                </div>
            </template>
            <!-- UPLOAD COMPLETED WITH FAILURES -->
            <template v-else>
                {{ corruptFiles.length }} files failed to upload.
                <br>
                <br>
                <a class="button is-danger" @click="showFailedFiles = true">
                    <b-icon icon="magnify"></b-icon>
                    <span>View failed files</span>
                </a>

                <b-modal :active.sync="showFailedFiles">
                    <article class="message is-danger">
                        <div class="message-header">
                            Failed files
                            <button class="delete" @click="showFailedFiles = false"></button>
                        </div>
                        <div class="message-body">
                            Following files were not able to be uploaded and parsed.
                            <br>
                            <br>
                            <div class="panel">
                                <a class="panel-block" v-for="file in corruptFiles">
                                    {{ file.name }}
                                </a>
                            </div>
                            <div class="level">
                                <div class="level-left"></div>
                                <div class="level-right">
                                    <a class="button is-danger" @click="showFailedFiles = false">
                                        Close
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                </b-modal>
            </template>
        </div>
    </div>
</template>

<script>
    import BIcon from "buefy/src/components/icon/Icon";
    import BModal from "buefy/src/components/modal/Modal";

    export default {
        name: "UploadInfoBox",
        components: {BIcon, BModal},
        data() {
            return {
                showFailedFiles: false,
            }
        },
        methods: {
            close() {
                this.$store.commit('fileUpload/setShowInfoBox', false);
            },
        },
        computed: {
            show() {
                return this.$store.getters['fileUpload/showInfoBox'];
            },
            doneFilesCount() {
                return this.totalFilesCount - this.$store.getters['fileUpload/remainingFilesCount'];
            },
            totalFilesCount() {
                return this.$store.getters['fileUpload/totalFilesCount'];
            },
            corruptFiles() {
                return this.$store.getters['fileUpload/filesUnableToUpload'];
            },
            uploadInProgress() {
                return this.$store.getters['fileUpload/uploadInProgress'];
            },
            uploadSuccessful() {
                return !this.uploadInProgress && this.corruptFiles.length === 0;
            },
        }
    }
</script>

<style lang="scss">
    @import "../../../sass/components/uploadInfoBox.scss";

    .custom-upload-progress {
        margin: 0 10px 0 0 !important;
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

    .upload-icon-top-right {
        position: absolute;
        top: 3px;
        right: 0;
    }

</style>