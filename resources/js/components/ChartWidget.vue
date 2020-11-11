<template>
    <linechart
        type="line"
        height="350"
        :options="chartOptions"
        :series="series"
        ref="chart"
    />
</template>

<script>
    import VueApexCharts from "vue-apexcharts";
    import { revenuesSummary } from "../api/revenues";

    export default {
        name: "ChartWidget2",

        components: { linechart: VueApexCharts },

        props: {
            params: Object,
        },

        data() {

            return {
                series: [],
                chartOptions: {
                    noData: {
                        text: "Loading..."
                    },
                    chart: {
                        height: 350,
                        type: "line",
                        zoom: {
                            enabled: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: "straight"
                    },
                    title: {
                        text: "Revenue by period",
                        align: "left"
                    },
                    grid: {
                        row: {
                            colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    xaxis: {
                        categories: [],
                    }
                },
            };
        },

        computed: {
            filters() {
                // debugger
                const filters = { ...this.params };
                filters.sortBy = [...this.params.sortBy];
                filters.sortDesc = [...this.params.sortDesc];

                const idIdx = filters.sortBy.findIndex(i => i === "id");
                filters.sortBy.splice(idIdx, 1);
                filters.sortDesc.splice(idIdx, 1);

                return filters;
            },
        },

        mounted() {
            // debugger
            this.fetch(this.filters);
            // console.log(this.$refs.chart);
        },

        methods: {
            fetch(params) {
                // debugger
                revenuesSummary(params)
                    .then(({ data }) => {
                        // debugger
                        const { chart } = this.$refs;
                        chart.updateSeries([{
                            name: "Total",
                            data: data.data.map(item => item.total)
                        }]);

                        chart.updateOptions({
                            ...this.chartOptions, xaxis: {
                                categories: data.data.map(item => item.date)
                            }
                        });
                    });
            }
        },

        watch: {
            params() {
                // debugger
                this.fetch(this.filters);
            }
        }
    };
</script>

<style scoped>

</style>
