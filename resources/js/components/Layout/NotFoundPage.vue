<template>
    <div class="error-404">
        <div class="h-80 has-background-primary flex-column flex-center">
            <h1 class="title is-404 is-unselectable">404</h1>
            <h2 class="subtitle is-3">Whooops</h2>
            <h3 class="subtitle is-size-5">Looks like the page you requested does not exist</h3>
            <div>
                <br>
                <br>
                <br>
                <a @click="$router.go(-1)" href="javascript:">Go back</a>
            </div>
        </div>
        <div class="flex-1 has-background-grey-dark"></div>
    </div>
</template>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .error-404 {
        position: absolute;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        display: flex;
        flex-direction: column;
    }
    .is-404 {
        font-size: 10rem;
        padding-bottom: .5rem;
        margin-bottom: 3rem;
        border-bottom: 1px solid $grey-dark;
    }
</style>
