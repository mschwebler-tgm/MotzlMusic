<template>
    <v-slide-group show-arrows>
        <v-slide-item
            v-for="item in items"
            :key="item.id"
            v-slot:default="{ active, toggle }"
        >
            <base-playable-item-card :item="item" width="150px" class="ma-3"></base-playable-item-card>
        </v-slide-item>
    </v-slide-group>
</template>

<script>
    import BasePlayableItemCard from "$scripts/components/_BaseComponents/BasePlayableItemCard";
    export default {
        name: "BaseCardSlider",
        components: {BasePlayableItemCard},
        props: {
            items: Array,
        }
    }
</script>
