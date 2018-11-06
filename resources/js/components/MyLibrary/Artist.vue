<template>
    <div class="card">
        <div class="card-image">
            <figure class="image is-128x128">
                <img class="is-rounded" src="https://bulma.io/images/placeholders/128x128.png" alt="Placeholder image">
            </figure>
        </div>
        <div class="card-content">
            <div class="has-text-centered">
                <p class="subtitle is-6">Some name</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "artist"
    }
</script>

<style scoped>
    .card {
        width: 128px;
        margin-right: 30px;
        margin-bottom: 20px;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        box-shadow: none;
    }
</style>