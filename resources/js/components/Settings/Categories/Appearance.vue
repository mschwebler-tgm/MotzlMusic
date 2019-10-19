<template>
    <div>
        <h3 class="headline">Appearance</h3>
        <v-divider class="mb-3 mt-3"></v-divider>
        <v-alert type="success" border="left" v-show="success">
            Appearance settings updated!
        </v-alert>
        <v-alert type="error" border="left" v-show="error">
            {{ error.message }}
            <ul>
                <li v-for="errorMessage in error.errors" class="caption">{{ errorMessage[0] }}</li>
            </ul>
        </v-alert>
        <v-select label="Theme"
                  v-model="theme"
                  :items="themeOptions"
                  filled
                  style="width: 200px"></v-select>
        <v-divider class="mb-3 mt-3"></v-divider>
        <v-btn color="accent" @click="save" :loading="loading">Save</v-btn>
    </div>
</template>

<script>
    export default {
        name: "Appearance",
        data() {
            return {
                user: {...this.$root.user},
                loading: false,
                success: false,
                error: false,
                theme: this.$root.user.settings.appearance.theme,
                themeOptions: ['light', 'dark', 'extra dark'],
            }
        },
        methods: {
            save() {
                this.loading = true;
                axios.post('/api/settings/appearance', {theme: this.theme.toLowerCase()})
                    .then(res => {
                        this.success = true;
                        this.error = false;
                        this.$root.user.settings.appearance = res.data.appearance;
                        setTimeout(() => this.success = false, 5000);
                    })
                    .catch(err => {
                        this.success = false;
                        this.error = err.response.data;
                    })
                    .finally(() => this.loading = false);
            }
        },
    }
</script>

<style scoped>

</style>
