<template>
    <div>
        <h2 class="has-text-weight-light title is-9">Upload mp3 files</h2>
        <form id="file-upload" @submit="submit">
            <label class="file-label">
                <input class="file-input" type="file" id="file-input" ref="file-input" webkitdirectory directory multiple>
                <span class="file-cta">
                    <b-icon icon="cloud-upload"></b-icon>
                    <span class="file-label">
                        &nbsp;&nbsp;Choose mp3 files...
                    </span>
                </span>
                <span class="is-size-7 has-text-grey file-hint">&nbsp;&nbsp;{{ fileCountText }}</span>
            </label>
            <br>
            <button type="submit" class="button is-primary">
                <template v-if="uploadInProgress">
                    <b-icon icon="loading" custom-class="fa-spin"></b-icon>
                    <span>&nbsp;Uploading...</span>
                </template>
                <template v-else>
                    Submit
                </template>
            </button>
        </form>
    </div>
</template>

<script>
    import BIcon from "buefy/src/components/icon/Icon";
    export default {
        name: "Upload",
        components: {BIcon},
        mounted() {
            this.initFileListener();
        },
        methods: {
            initFileListener() {
                const $fileInput = this.$refs['file-input'];
                $fileInput.addEventListener('change', _ => {
                    let files = [];
                    for (let i = 0; i < $fileInput.files.length; i++) {
                        const file = $fileInput.files[i];
                        if (file.type === 'audio/mp3') {
                            files.push(file);
                        }
                    }
                    this.$store.commit('fileUpload/setFiles', files);
                });
            },
            submit(event) {
                event.preventDefault();
                this.$store.dispatch('fileUpload/submit');
            }
        },
        computed: {
            fileCountText() {
                if (!this.fileCount || this.uploadInProgress) {
                    return '';
                }

                return this.fileCount + ' files selected';
            },
            fileCount() {
                return this.$store.getters['fileUpload/remainingFilesCount'];
            },
            uploadInProgress() {
                return this.$store.getters['fileUpload/uploadInProgress'];
            }
        }
    }
</script>

<style scoped>
    .file-hint {
        display: flex;
        align-items: center;
    }
</style>