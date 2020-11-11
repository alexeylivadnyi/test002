<template>
    <v-dialog v-model="dialog" max-width="30%">
        <template v-slot:activator="{ on }">
            <v-btn icon v-on="on">
                <v-icon>mdi-square-edit-outline</v-icon>
            </v-btn>
        </template>

        <v-form ref="form">
            <v-card class="pa-5">
                <v-card-title>Update Revenue Item</v-card-title>

                <v-card-text>
                    <v-combobox
                        v-model="fields.product"
                        label="Выберите продукт"
                        :items="products"
                        item-text="name"
                        item-value="id"
                        :error-messages="errorMessages.product"
                        :rules="rules.product"
                    />
                    <v-combobox
                        v-model="fields.client"
                        label="Выберите клиента"
                        :items="clients"
                        item-text="name"
                        item-value="id"
                        :error-messages="errorMessages.client"
                        :rules="rules.client"
                    />

                    <v-text-field
                        label="Total"
                        v-model="fields.total"
                        :error-messages="errorMessages.total"
                        :rules="rules.total"
                    />
                    <date-picker
                        v-model="fields.date"
                        :error-messages="errorMessages.date"
                        :rules="rules.date"
                    />
                </v-card-text>

                <v-card-actions>
                    <v-btn @click="submit" color="success" :loading="loading">Update</v-btn>
                    <v-btn @click="cancel" color="error" :loading="loading">Cancel</v-btn>
                </v-card-actions>
            </v-card>
        </v-form>
    </v-dialog>
</template>

<script>
    import DatePicker from "./DatePicker";
    import { revenueUpdate } from "../api/revenues";

    export default {
        name: "UpdateItem",

        components: { DatePicker },

        props: {
            item: Object,
            clients: Array,
            products: Array,
        },

        data() {
            return {
                dialog: false,
                loading: false,
                date: null,
                fields: { ...this.item },
                errorMessages: {
                    product: "",
                    client: "",
                    total: "",
                    date: "",
                },
                rules: {
                    product: [v => !!v || "Required"],
                    client: [v => !!v || "Required"],
                    total: [
                        v => !!v || "Required",
                        v => /\d+/.test(v) || "Only number"
                    ],
                    date: [v => !!v || "Required"],
                }
            };
        },

        computed: {},

        methods: {
            initials: () => ({
                product_id: null,
                client_id: null,
                total: 0,
                date: ""
            }),
            cancel() {
                this.dialog = false;
                this.$refs.forms.reset();
                this.$set(this, "fields", { ...this.item });
            },
            submit() {
                if (this.$refs.form.validate()) {
                    this.loading = true;

                    revenueUpdate(this.item.id, this.fields)
                        .then(({ data }) => {
                            this.$emit("updated", data.data);
                            this.dialog = false;
                        })
                        .catch(({ errors }) => {
                            this.errorMessages = { ...this.errorMessages, ...errors };
                        })
                        .finally(() => {
                            this.loading = false;
                        });
                }
            }
        },

        watch: {
            item(val) {
                this.fields = {
                    ...val,
                    product_id: val.product.id,
                    client_id: val.client.id
                };
            },
            'fields.client': {
                deep: true,
                handler(val) {
                    this.fields.client_id = val.id;
                }
            },
            'fields.product': {
                deep: true,
                handler(val) {
                    this.fields.product_id = val.id;
                }
            }
        }
    };
</script>

<style scoped>

</style>
