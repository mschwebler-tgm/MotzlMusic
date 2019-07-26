<template>
    <v-layout row wrap>
        <v-flex v-for="playlist in playlists"
                :key="playlist.id"
                xs6 sm4 md4 lg3 xl2 d-block justify-center>
            <base-playable-item-card :item="playlist"></base-playable-item-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import BasePlayableItemCard from "../../_BaseComponents/BasePlayableItemCard";

    export default {
        name: "PlaylistItemList",
        components: {BasePlayableItemCard},
        props: {
            playlists: {
                type: Array,
                default: () => [],
            }
        }
    }
</script>
