<template>
    <div>
        <span class="headline">{{ name }}</span>
    </div>
</template>

<script>
    export default {
        name: "Playlist",
        props: {
            name: String,
            id: String,
        },
        created() {
            if (!this.cachedPlaylist) {
                this.$store.dispatch('cache/fetchSelectedPlaylist', this.id);
            }
        },
        computed: {
            cachedPlaylist() {
                let cachedPlaylist = this.$store.getters['cache/selectedPlaylist'];
                if (cachedPlaylist && cachedPlaylist.id === parseInt(this.id)) {
                    return cachedPlaylist;
                }

                return null;
            }
        }
    }
</script>

<style scoped>

</style>