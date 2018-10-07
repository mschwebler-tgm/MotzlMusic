<template>
    <div>
        <button class="button is-white" @click="checkable = !checkable">Edit</button>
        <b-table
                :data="data"
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
                        <img src="https://t3.ftcdn.net/jpg/01/00/13/64/240_F_100136429_HP2NJnj6FDdn3XnrrsGxqxoMED7K8ENG.jpg" alt="Placeholder image">
                    </figure>
                </b-table-column>

                <b-table-column field="title" label="Title" sortable>
                    {{ props.row.title }}
                </b-table-column>

                <b-table-column field="duration" label="icon:clock-outline" sortable>
                    {{ props.row.duration }}
                </b-table-column>

                <b-table-column field="artist" label="Artist" sortable>
                    {{ props.row.artist }}
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
            BSwitch},
        name: "tracks",
        data() {
            return {
                data: [
                    { title: '1985', duration: '3:15', artist: 'Bowling For Soup', rating: Math.round(Math.random()*50)/10 },
                    { title: '365', duration: '1:26', artist: 'Amaranthe', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Alles auf Rausch', duration: '6:11', artist: 'Feine Sahne Fischfilet', rating: Math.round(Math.random()*50)/10 },
                    { title: 'American Idiot', duration: '3:12', artist: 'Green Day', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Animal', duration: '2:45', artist: 'Smash into Pieces', rating: Math.round(Math.random()*50)/10 },
                    { title: 'The Anthem', duration: '2:12', artist: 'Good Charlotte', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Armut treibt Jugendliche in die Popmusik', duration: '3:15', artist: 'Trailerpark', rating: Math.round(Math.random()*50)/10 },
                    { title: 'The Ballad Of Chasey Lain', duration: '3:15', artist: 'Bloodhound Gang', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Basket Case', duration: '4:49', artist: 'Green Day', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Behind Blue Eyes', duration: '3:52', artist: 'Limp Bizkit', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Blame It On The Boom Boom', duration: '3:20', artist: 'Black Stone Cherry', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Blank Space', duration: '1:59', artist: 'I Prevail', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Bored To Death', duration: '20:31', artist: 'Blink-182', rating: Math.round(Math.random()*50)/10 },
                    { title: 'The Boys of Summer', duration: '2:50', artist: 'The Ataris', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Broken Lives', duration: '4:24', artist: 'Our Last Night', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Coming for You', duration: '2:33', artist: 'The Offspring', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Crazy Train', duration: '4:27', artist: 'Ozzy Osbourne', rating: Math.round(Math.random()*50)/10 },
                    { title: '1985', duration: '3:15', artist: 'Bowling For Soup', rating: Math.round(Math.random()*50)/10 },
                    { title: '365', duration: '1:26', artist: 'Amaranthe', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Alles auf Rausch', duration: '6:11', artist: 'Feine Sahne Fischfilet', rating: Math.round(Math.random()*50)/10 },
                    { title: 'American Idiot', duration: '3:12', artist: 'Green Day', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Animal', duration: '2:45', artist: 'Smash into Pieces', rating: Math.round(Math.random()*50)/10 },
                    { title: 'The Anthem', duration: '2:12', artist: 'Good Charlotte', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Armut treibt Jugendliche in die Popmusik', duration: '3:15', artist: 'Trailerpark', rating: Math.round(Math.random()*50)/10 },
                    { title: 'The Ballad Of Chasey Lain', duration: '3:15', artist: 'Bloodhound Gang', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Basket Case', duration: '4:49', artist: 'Green Day', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Behind Blue Eyes', duration: '3:52', artist: 'Limp Bizkit', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Blame It On The Boom Boom', duration: '3:20', artist: 'Black Stone Cherry', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Blank Space', duration: '1:59', artist: 'I Prevail', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Bored To Death', duration: '20:31', artist: 'Blink-182', rating: Math.round(Math.random()*50)/10 },
                    { title: 'The Boys of Summer', duration: '2:50', artist: 'The Ataris', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Broken Lives', duration: '4:24', artist: 'Our Last Night', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Coming for You', duration: '2:33', artist: 'The Offspring', rating: Math.round(Math.random()*50)/10 },
                    { title: 'Crazy Train', duration: '4:27', artist: 'Ozzy Osbourne', rating: Math.round(Math.random()*50)/10 },
                ],
                selected: null,
                checkable: false
            }
        }
    }
</script>

<style scoped>

</style>