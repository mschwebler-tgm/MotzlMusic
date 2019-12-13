<template>
    <v-container>
        <base-playable-item-view
            :id="id"
            :only-own-tracks="onlyOwnTracks"
            rounded-image
            type="artist"
            related-items-key="albums"
        ></base-playable-item-view>
    </v-container>
</template>

<script>
    import BasePlayableItemView from "$scripts/components/_BaseComponents/BasePlayableItemView";

    export default {
        name: "Artist",
        components: {BasePlayableItemView},
        props: {
            id: [String, Number],
            onlyOwnTracks: Boolean,
        },
    }
</script>
