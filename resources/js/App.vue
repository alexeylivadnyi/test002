<template>
    <v-app>
        <!--        <v-snackbar-->
        <!--            v-for="(snack, index) in snackbars"-->
        <!--            v-model="snack.active"-->
        <!--            :color="snack.color"-->
        <!--            :multi-line="snack.multiLine"-->
        <!--            right-->
        <!--            top-->
        <!--            :timeout="snack.timeout"-->
        <!--            :key="index"-->
        <!--            :style="`top: ${index * 60 + 8}px`"-->
        <!--        >-->
        <!--            {{ snack.text }}-->
        <!--            <v-btn dark icon @click="close(snack.id)">-->
        <!--                <v-icon>mdi-close</v-icon>-->
        <!--            </v-btn>-->
        <!--        </v-snackbar>-->
        <app-header/>
        <!--        <app-sidebar :drawer="drawer"/>-->
        <v-content>
            <main-layout/>
        </v-content>
    </v-app>
</template>

<script>
    import AppHeader from "./components/AppHeader";
    import MainLayout from "./components/MainLayout";

    export default {
        name: "App",

        components: { AppHeader, MainLayout },

        data: () => ({
            // drawer: true,
            snackbar: true
        }),
    };
</script>

<style scoped>

</style>
