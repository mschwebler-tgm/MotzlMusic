<template>
    <div>
        <section>
            <b-tabs v-model="activeTab">
                <b-tab-item label="Playlists">
                    Lorem <br>
                    ipsum <br>
                    dolor <br>
                    sit <br>
                    amet.
                </b-tab-item>
                <b-tab-item label="Tracks">
                    Lorem <br>
                    ipsum <br>
                    dolor <br>
                    sit <br>
                    amet.
                </b-tab-item>
                <b-tab-item label="Artists">
                    Lorem <br>
                    ipsum <br>
                    dolor <br>
                    sit <br>
                    amet.
                </b-tab-item>
                <b-tab-item label="Albums">
                    Lorem <br>
                    ipsum <br>
                    dolor <br>
                    sit <br>
                    amet.
                </b-tab-item>
            </b-tabs>
        </section>
    </div>
</template>

<script>
    import BSwitch from "buefy/src/components/switch/Switch";

    export default {
        components: {BSwitch},
        name: "index",
        data() {
            return {
                activeTab: 0,
                showBooks: false,
                isSwitched: false,
            }
        }
    }
</script>

<style scoped>

</style>