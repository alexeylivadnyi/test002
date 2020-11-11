<template>
    <v-menu
        v-model="dialog"
        :close-on-content-click="true"
        transition="scale-transition"
        min-width="290px"
    >
        <template v-slot:activator="{ on }">
            <v-text-field
                v-bind="$attrs"
                @click:clear="date = null"
                v-model="dateText"
                label="Date"
                readonly
                outlined
                dense
                v-on="on"
                clearable
                :rules="rules"
                :error-messages="errorMessages"
            />
        </template>
        <v-date-picker v-model="dateStr" :first-day-of-week="1"/>
    </v-menu>
</template>

<script>
    import moment from "moment";

    export default {
        name: "DatePicker",

        model: {
            prop: "value",
            event: "change"
        },

        props: {
            value: String,
            rules: Array,
            errorMessages: [String, Array]
        },

        data() {
            return {
                dialog: false,
                date: this.value ? moment(this.value) : null,
                dateText: this.value ? this.value : "",
                dateStr: this.value
                    ? moment(this.value, "DD.MM.YYYY").format("YYYY-MM-DD")
                    : ""
            };
        },

        methods: {
            clearDate() {
                this.dateStr = "";
            }
        },

        watch: {
            value(val) {
                this.date = val ? moment(val, "DD.MM.YYYY") : null;
                this.dateStr = this.date ? this.date.format("YYYY-MM-DD") : "";
                this.dateText = this.date ? this.date.format("DD.MM.YYYY") : "";
            },
            dateStr(val) {
                this.date = val ? moment(val) : null;
            },
            date() {
                this.$emit("change", this.date ? this.date.format("DD.MM.YYYY") : "");
            }
        }
    };
</script>

<style scoped></style>
