<template>
    <component :is="component" v-bind="$attrs"
            v-model="showMenu"
            offset-x
            absolute>
        <v-list light :dense="dense">
            <v-list-tile @click="">
                <v-list-tile-avatar>
                    <v-icon small>add_to_queue</v-icon>
                </v-list-tile-avatar>
                <v-list-tile-title>
                    Add to Queue
                </v-list-tile-title>
            </v-list-tile>
            <v-list-tile @click="">
                <v-list-tile-avatar>
                    <v-icon small>playlist_add</v-icon>
                </v-list-tile-avatar>
                <v-list-tile-title>
                    Add to Playlist
                </v-list-tile-title>
            </v-list-tile>
            <v-divider></v-divider>
            <v-list-tile @click="">
                <v-list-tile-avatar>
                    <v-icon small>delete</v-icon>
                </v-list-tile-avatar>
                <v-list-tile-title>
                    Remove from your Library
                </v-list-tile-title>
            </v-list-tile>
            <v-list-tile @click="">
                <v-list-tile-avatar>
                    <v-icon small>edit</v-icon>
                </v-list-tile-avatar>
                <v-list-tile-title>
                    Edit
                </v-list-tile-title>
            </v-list-tile>
        </v-list>
    </component>
</template>

<script>
    export default {
        name: "TrackTableContextMenu",
        props: ['show', 'track', 'component', 'dense'],
        computed: {
            showMenu: {
                get() {
                    return this.show;
                },
                set(show) {
                    this.$emit('update:show', show);
                }
            }
        }
    }
</script>
