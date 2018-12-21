<template>
    <div>
        <h2 class="has-text-weight-light title is-9">Tracks</h2>

        <b-table
                :data="tracks"
                :bordered="false"
                :striped="true"
                :narrowed="true"
                :hoverable="true"
                :loading="false"
                :focusable="false"
                :mobile-cards="false"
                :selected.sync="selected"
                :checkable="checkable"
                :default-sort-direction="'asc'"
                default-sort="title">

            <template slot-scope="props" slot="header">
                <template v-if="props.column.label && props.column.label.startsWith('icon')">
                    <b-icon :icon="props.column.label.substr(5, props.column.label.length)"></b-icon>
                </template>
                <template v-else>
                    {{ props.column.label }}
                </template>
            </template>
            <template slot-scope="props">
                <b-table-column>
                    <figure class="image is-24x24">
                        <img src="https://t3.ftcdn.net/jpg/01/00/13/64/240_F_100136429_HP2NJnj6FDdn3XnrrsGxqxoMED7K8ENG.jpg"
                             alt="Placeholder image">
                    </figure>
                </b-table-column>

                <b-table-column field="title" label="Title" sortable>
                    {{ props.row.name }}
                </b-table-column>

                <b-table-column field="duration" label="icon:clock-outline" sortable>
                    {{ props.row.duration_formatted }}
                </b-table-column>

                <b-table-column field="artist" label="Artist" sortable>
                    {{ props.row.artist.name }}
                </b-table-column>

                <b-table-column field="rating" label="Rating" sortable>
                    {{ props.row.rating }}
                </b-table-column>
            </template>

            <template slot="empty">
                <section class="section">
                    <div class="content has-text-grey has-text-centered">
                        <p>
                            <b-icon
                                    icon="emoticon-sad"
                                    size="is-large">
                            </b-icon>
                        </p>
                        <p>Nothing here.</p>
                    </div>
                </section>
            </template>
        </b-table>
    </div>
</template>

<script>
    import BSwitch from "buefy/src/components/switch/Switch";
    import BIcon from "buefy/src/components/icon/Icon";

    export default {
        components: {
            BIcon,
            BSwitch
        },
        name: "tracks",
        data() {
            return {
                selected: null,
                checkable: false
            }
        },
        computed: {
            tracks() {
                return this.$store.getters['myLibrary/tracks'];
            }
        }
    }
</script>

<style scoped>

</style>