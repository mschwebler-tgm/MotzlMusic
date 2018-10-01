<template>
    <div>
        <button type="button" class="btn btn-primary btn-block">Shuffle</button>
        <div class="row">
            <div class="col-sm-12 col-md-4 item">
                <gauss-wrapper label="Energy" v-model="params.energy"></gauss-wrapper>
            </div>
            <div class="col-sm-12 col-md-4 item">
                <gauss-wrapper label="Happiness" v-model="params.happiness"></gauss-wrapper>
            </div>
            <div class="col-sm-12 col-md-4 item">
                <gauss-wrapper label="Speechiness" v-model="params.speechiness"></gauss-wrapper>
            </div>
            <div class="col-sm-12 col-md-4 item">
                <gauss-wrapper label="Acousticness" v-model="params.acousticness"></gauss-wrapper>
            </div>
            <div class="col-sm-12 col-md-4 item">
                <gauss-wrapper label="Liveness" v-model="params.liveness"></gauss-wrapper>
            </div>
            <div class="col-sm-12 col-md-4 item">
                <gauss-wrapper label="Danceability" v-model="params.danceability"></gauss-wrapper>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Index",
        data() {
            return {
                params: {
                    energy: {},
                    happiness: {},
                    speechiness: {},
                    acousticness: {},
                    liveness: {},
                    danceability: {},
                }
            }
        }
    }
</script>

<style scoped>
    .item {
        padding: 100px;
    }
</style>
