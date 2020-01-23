<template>
    <div>
        <div class="header d-flex align-center">
            <div v-for="(column, index) in columns"
                 :key="index"
                 :class="column.header.classes"
                 @click="sortBy(column.sortIdentifier)"
                 class="grey--text d-flex align-center">
                <v-icon v-if="column.header.icon" small color="grey">{{ column.header.icon }}</v-icon>
                <template v-else>{{ column.header.label }}</template>
                <v-icon v-if="column.sortIdentifier && isSortActive(column.sortIdentifier)"
                        small
                        class="sortArrow ml-2"
                        :class="getSortDirection(column.sortIdentifier)"
                        color="grey">
                    mdi-arrow-up
                </v-icon>
            </div>
        </div>
        <v-scale-transition>
            <v-progress-linear v-if="loading"
                               indeterminate
                               color="primary"
                               height="2"></v-progress-linear>
        </v-scale-transition>
    </div>
</template>

<script>
    class Sort {
        constructor(identifier, direction = 'asc') {
            this.identifier = identifier;
            this.direction = direction;
        }
    }

    export default {
        name: "BaseTrackTableHeaders",
        props: {
            columns: Array,
            loading: Boolean,
        },
        data() {
            return {
                sorting: [],
            }
        },
        methods: {
            sortBy(identifier) {
                if (!identifier) {
                    return;
                }

                const existingSortIndex = this.sorting.findIndex(sort => sort.identifier === identifier);
                const existingSort = this.sorting[existingSortIndex];
                if (existingSort) {
                    if (existingSort.direction === 'desc') {
                        this.sorting.splice(existingSortIndex, 1);
                    } else {
                        existingSort.direction = 'desc';
                    }
                } else {
                    this.sorting.push(new Sort(identifier));
                }

                this.$emit('input', this.sorting);
            },
            isSortActive(sortIdentifier) {
                return this.sorting.findIndex(sort => sort.identifier === sortIdentifier) !== -1;
            },
            getSortDirection(sortIdentifier) {
                return this.sorting.find(sort => sort.identifier === sortIdentifier).direction;
            }
        }
    }
</script>

<style>
    .sortArrow.desc {
        transform: rotate(180deg);
    }

    .header .grey--text:hover {
        opacity: 1;
    }
</style>
