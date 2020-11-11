<template>
    <v-form>
        <v-row>
            <v-col cols="8">
                <v-text-field
                    v-model="params.keywords"
                    label="Keywords"
                    dense
                    outlined
                    clearable
                />
            </v-col>
            <v-col cols="2">
                <v-select
                    v-model="params.field"
                    :items="fieldset"
                    label="field"
                    item-text="text"
                    item-value="value"
                    dense
                    outlined
                />
            </v-col>
            <v-col cols="1">
                <v-btn color="primary" block @click="onClick">Search</v-btn>
            </v-col>
            <v-col cols="1">
                <v-btn color="secondary" block @click="onReset">Reset</v-btn>
            </v-col>
        </v-row>
    </v-form>
</template>

<script>
    import { fieldset } from "./../data/fieldSet";

    export default {
        name: "SearchLine",

        data() {
            return {
                params: {
                    keywords: "",
                    field: "a"
                }
            };
        },

        computed: {
            fieldset: () => Object.entries(fieldset).map(([value, text]) => ({
                value, text
            })),
        },

        methods: {
            onClick() {
                this.$emit("search", this.params);
            },
            onReset() {
                this.params.keywords = "";
                this.params.field = "a";
                this.$emit("reset");
                this.$emit("search", this.params);
            }
        }
    };
</script>

<style scoped>

</style>
