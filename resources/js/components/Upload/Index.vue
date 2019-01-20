<template>
    <div>
        <form id="file-upload" @submit="submit">
            <label class="file-label">
                <input class="file-input" type="file" id="file-input" ref="file-input" webkitdirectory directory multiple>
                <span class="file-cta">
                    <b-icon icon="cloud-upload"></b-icon>
                    <span class="file-label">
                        &nbsp;&nbsp;Choose mp3 files...
                    </span>
                </span>
            </label>
            <button type="submit" class="button is-primary">
                Submit
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
                console.log(this.$store.getters['fileUpload/files']);
            }
        }
    }
</script>

<style scoped>

</style>