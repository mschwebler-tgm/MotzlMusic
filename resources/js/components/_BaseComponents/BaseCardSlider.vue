<template>
    <div class="d-flex pl-12 pr-12" v-if="loading">
        <v-skeleton-loader type="card" width="150px" class="ma-3"></v-skeleton-loader>
        <v-skeleton-loader type="card" width="150px" class="ma-3"></v-skeleton-loader>
        <v-skeleton-loader type="card" width="150px" class="ma-3"></v-skeleton-loader>
        <v-skeleton-loader type="card" width="150px" class="ma-3"></v-skeleton-loader>
        <v-skeleton-loader type="card" width="150px" class="ma-3"></v-skeleton-loader>
        <v-skeleton-loader type="card" width="150px" class="ma-3"></v-skeleton-loader>
    </div>
    <v-slide-group v-else :show-arrows="!$root.isTouch">
        <v-slide-item
            v-for="item in items"
            :key="item.id"
            v-slot:default="{ active, toggle }"
        >
            <base-playable-item-card :item="item" width="150px" class="ma-3" v-bind="$attrs"></base-playable-item-card>
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
            loading: Boolean,
        }
    }
</script>
