<template>
    <div class="card">
        <div class="card-image">
            <figure class="image is-4by3">
                <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
            </figure>
        </div>
        <div class="card-content">
            <div class="media">
                <div class="media-content">
                    <p class="title is-5">{{ data.artist }}</p>
                    <p class="subtitle is-6">{{ data.title }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "album",
        props: ['data']
    }
</script>

<style scoped>
    .card {
        width: 200px;
        margin-right: 20px;
        margin-bottom: 20px;
    }
</style>