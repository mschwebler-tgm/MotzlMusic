<template>
    <div class="wrapper"
         :class="{active: show && itemsToImport.length !== 0}">
        <div class="item-picker">
            <!--v-show="show && itemsToImport.length !== 0">-->
            <div v-for="item in pageItems" :key="item.id"
                 class="item-wrapper"
                 :class="{selected: isItemSelected(itemsToImport, item)}">
                <div class="item"
                     :style="{background: 'black url(' + item.image + ')'}"
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
            <div style="height: 100%;"></div>
            <div class="level flex-1" style="flex-basis: 100%;"
                 v-if="items && items.length > perPage">
                <div class="level-left"></div>
                <b-pagination
                        :total="items.length"
                        :per-page="perPage"
                        :simple="true"
                        :current.sync="currentPage"></b-pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import BPagination from "buefy/src/components/pagination/Pagination";

    export default {
        name: "SpotifyImporterItemPicker",
        components: {BPagination},
        props: ['show', 'items', 'itemsToImport', 'checkboxReference'],
        data() {
            return {
                currentPage: 1,
                perPage: 6
            }
        },
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
        },
        computed: {
            pageItems() {
                if (!this.items) {
                    return [];
                }
                const offset = (this.currentPage - 1) * this.perPage;
                return this.items.slice(offset, offset + this.perPage);
            }
        }
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/_variables.scss";

    .wrapper {
        max-height: 0;
        overflow: hidden;
        transition: max-height 1.0s ease-in-out, opacity .3s ease-out;
        padding: 0 15px;
        opacity: 0;
        position: relative;
    }

    .wrapper.active {
        max-height: 10000px;
        padding: 3px 15px 15px;
        opacity: 1;
        overflow: hidden;
    }

    .wrapper:not(.active) > .item-picker {
        position: absolute;
    }

    .item-picker {
        display: flex;
        flex-wrap: wrap;
    }

    .item-picker > div {
        width: 150px;
        margin-right: 30px;
        margin-bottom: 10px;
        cursor: pointer;
    }

    .item-wrapper {
        height: 200px;
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