<template>
    <v-container fluid>
        <search-line @search="onSearch" @reset="reset = true"/>
        <table-desk
            :search-params="searchParams"
            :reset-flag="reset"
            @reseted="reset = false"
            :clients="clients"
            :products="products"
        />
    </v-container>
</template>

<script>
    import SearchLine from "./SearchLine";
    import TableDesk from "./TableDesk";
    import { productsIndex } from "../api/products";
    import { clientsIndex } from "../api/clients";

    export default {
        name: "MainLayout",

        components: { SearchLine, TableDesk },

        created() {
            Promise.all([
                clientsIndex(),
                productsIndex()
            ])
                .then(data => {
                    [this.clients, this.products] = [data[0].data.data, data[1].data.data];
                });
        },

        data() {
            return {
                searchParams: null,
                reset: false,
                clients: [],
                products: []
            };
        },

        methods: {
            onSearch(val) {
                if (val.field === 'a' && !val.keywords) {
                    this.searchParams = null;
                }
                if (val.keywords) {
                    this.searchParams = { ...val };
                }
            }
        }
    };
</script>

<style scoped>

</style>
