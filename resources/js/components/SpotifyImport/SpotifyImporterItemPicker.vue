<template>
    <div class="item-picker" v-show="show && itemsToImport.length !== 0">
        <div v-for="item in items" :key="item.id"
             :class="{selected: isItemSelected(itemsToImport, item)}">
            <div class="item"
                 :style="{backgroundImage: 'url(' + item.image + ')'}"
                 @click="handleItemClick(itemsToImport, item, $parent.$refs[checkboxReference])">
                <div class="is-overlay select-check">
                    <div class="check">
                        <b-icon icon="check" size="is-large" type="is-white"
                                v-if="isItemSelected(itemsToImport, item)"></b-icon>
                        <span class="has-text-white">{{ item.tracks }} tracks</span>
                    </div>
                </div>
            </div>
            <div class="has-text-centered has-text-wrapped item-name"
                 @click="handleItemClick(itemsToImport, item, $parent.$refs[checkboxReference])">
                {{ item.name }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SpotifyImporterItemPicker",
        props: ['show', 'items', 'itemsToImport', 'checkboxReference'],
        methods: {
            isItemSelected(items, paramItem) {
                return !!items.filter(item => item.id === paramItem.id).length;
            },
            handleItemClick(toImport, item, checkbox) {
                if (this.isItemSelected(toImport, item)) {
                    toImport.splice(toImport.map(a => a.id).indexOf(item.id), 1);
                } else {
                    toImport.push(item);
                }
                checkbox.newValue = toImport.length !== 0;
            },
        }
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/_variables.scss";

    .item-picker {
        display: flex;
        flex-wrap: wrap;
        padding: 3px 15px 15px;
    }

    .item-picker > div {
        width: 150px;
        margin-right: 30px;
        margin-bottom: 10px;
        cursor: pointer;
    }

    .item {
        position: relative;
        width: 150px;
        height: 150px;
        background-position: center center;
        background-size: cover;
    }

    .select-check {
        display: none;
        background-color: transparentize($spotify-primary, .7);
    }

    .select-check .check {
        padding: 5px;
        background-color: $spotify-secondary;
        display: flex;
        align-items: center;
    }

    .item-picker > div.selected .select-check {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .item-picker > div:hover .item-name, .item-picker > div.selected .item-name {
        color: $spotify-primary;
    }
</style>