<template>
    <div class="wrapper">
        <div class="side-nav">
            <div class="list-group">
                <router-link to="/ideas/gauss" class="list-group-item active">Normal density customization</router-link>
                <a href="#" class="list-group-item">Coming soon...</a>
                <a href="#" class="list-group-item">Coming soon...</a>
                <a href="#" class="list-group-item">Coming soon...</a>
                <a href="#" class="list-group-item">Coming soon...</a>
                <a href="#" class="list-group-item">Coming soon...</a>
                <a href="#" class="list-group-item">Coming soon...</a>
            </div>
        </div>
        <div class="my-content">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Ideas"
    }
</script>

<style scoped>
    .wrapper {
        width: 100vw;
        height: 100vh;
        display: flex;
    }
    .side-nav {
        width: 300px;
        border-right: 1px solid darkgray;
    }
    .my-content {
        padding: 50px;
        flex: 1;
        overflow-y: scroll;
    }
</style>