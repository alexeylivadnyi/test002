<template>
    <v-app-bar
        app
        class="overflow-hidden"
        clipped-left
        color="primary"
        elevate-on-scroll
        fixed
    >
        <v-toolbar-title class="white--text title">WebScribble Test Task</v-toolbar-title>

        <v-spacer/>

        <v-toolbar-title class="white--text body-2">made by <strong>Alexey Livadniy</strong></v-toolbar-title>
    </v-app-bar>
</template>

<script>
    export default {
        name: "AppHeader"
    };
</script>

<style scoped>
</style>
