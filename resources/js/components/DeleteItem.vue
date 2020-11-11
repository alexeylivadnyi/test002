<template>
    <v-dialog v-model="dialog" max-width="30%">
        <template v-slot:activator="{ on }">
            <v-btn icon v-on="on">
                <v-icon>mdi-delete</v-icon>
            </v-btn>
        </template>

        <v-card class="pa-5">
            <v-card-title>Remove Revenue Item</v-card-title>

            <v-card-text>{{`This item #${item.id} would be removed`}}</v-card-text>

            <v-card-actions>
                <v-btn @click="$emit('remove', item.id)" color="error">Remove</v-btn>
                <v-btn @click="dialog = false" color="success">Cancel</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: "DeleteItem",

        props: {
            item: Object
        },

        data() {
            return {
                dialog: false,
            };
        }
    };
</script>

<style scoped>

</style>
