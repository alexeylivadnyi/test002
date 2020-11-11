<template>
    <div>
        <chart-widget :params="filters"/>
        <v-btn
            text
            color="primary"
            @click="email"
            :loading="emailLoading"
        >
            email this report
        </v-btn>
        <v-data-table
            :items="items"
            :loading="loading"
            :options.sync="options"
            :headers="headers"
            :server-items-length="totalItems"
            :footer-props="footerProps"
            item-key="id"
            multi-sort
        >
            <template #item.client="{item}">{{ item.client.name }}</template>
            <template #item.product="{item}">{{ item.product.name }}</template>
            <template #item.total="{item}">{{ item.total }}</template>
            <template #item.actions="{item}">
                <update-item :item="item" :clients="clients" :products="products" @updated="itemUpdated"/>
                <delete-item :item="item" @remove="deleteItem"/>
            </template>
        </v-data-table>
    </div>
</template>

<script>
    import { revenuesIndex, revenueDestroy, revenueEmail } from "../api/revenues";
    import debounce from "debounce";
    import DeleteItem from "./DeleteItem";
    import UpdateItem from "./UpdateItem";
    import ChartWidget from "./ChartWidget";

    export default {
        name: "TableDesk",

        components: { DeleteItem, UpdateItem, ChartWidget },

        props: {
            searchParams: Object,
            resetFlag: Boolean,
            clients: Array,
            products: Array
        },

        created() {
            this.fetch();
        },

        data() {
            return {
                loading: false,
                items: [],
                totalItems: -1,
                emailLoading: false,
                options: {
                    page: 1,
                    itemsPerPage: 15,
                    sortBy: [],
                    sortDesc: [],
                }
            };
        },

        computed: {
            headers: () => [
                { text: "Client", sortable: true, align: "left", value: "client" },
                { text: "Product", sortable: true, align: "left", value: "product" },
                { text: "Total", sortable: true, align: "left", value: "total" },
                { text: "Date", sortable: true, align: "left", value: "date" },
                { text: "Actions", sortable: true, align: "right", value: "actions" },
            ],
            footerProps() {
                return {
                    disableItemsPerPage: true,
                    itemsPerPageText: "",
                    itemsPerPageOptions: [],
                };
            },
            filters() {
                return {
                    ...this.options,
                    ...this.searchParams,
                    sortDesc: this.options.sortDesc.map(i => +i)
                };
            }
        },

        methods: {
            fetch(params) {
                this.loading = true;

                return revenuesIndex(params)
                    .then(this.fetchFulfilled)
                    .catch(this.fetchRejected)
                    .finally(() => {
                        this.loading = false;
                    });
            },
            fetchFulfilled({ data }) {
                this.items = data.data;
                this.totalItems = data.meta.total;
                this.options.page = data.meta.current_page;

                if (this.resetFlag) {
                    this.$emit("reseted");
                }
            },
            fetchRejected() {
            },
            deleteItem(id) {
                revenueDestroy(id).then(() => {
                    this.fetch(this.filters);
                });
            },
            itemUpdated(val) {
                const itemIdx = this.items.findIndex(item => item.id === val.id);
                this.$set(this.items, itemIdx, val);
            },
            email: debounce(function () {
                this.emailLoading = true;

                revenueEmail(this.filters)
                    .finally(() => {
                        this.emailLoading = false;
                    });
            }, 1000)
        },

        watch: {
            options: {
                deep: true,
                handler: debounce(function (val) {
                    if (!this.resetFlag) {
                        this.fetch(this.filters);
                    }
                }, 1000)
            },
            searchParams: debounce(function (val) {
                this.fetch(this.filters);
            }, 1000),
            resetFlag: debounce(function () {
                this.fetch({});
            }, 1000),
        }
    };
</script>

<style scoped>

</style>
