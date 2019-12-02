<script>
import {
    Bar
} from 'vue-chartjs'

export default {
    extends: Bar,
    data: function () {
        return {
            chartdata: {
                labels: [""],
                datasets: [{
                        label: "Expense",
                        fill: true,
                        data: [],
                        pointBorderColor: "#ff6384",
                        borderColor: '#ff6384',
                        borderWidth: 5,
                        showLine: true,
                    },
                    {
                        label: "Income",
                        fill: true,
                        data: [],
                        pointBorderColor: "#4bc0c0",
                        borderColor: '#4bc0c0',
                        borderWidth: 5,
                        showLine: true,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            },
        }
    },
    methods: {
        getData() {
            axios
                .get("api/user/movements/incomeexpense")
                .then(response => {
                    for (let value in response.data) {
                        if (response.data[value].type == 'i') {
                            this.chartdata.labels[value] = response.data[value].label;
                            this.chartdata.datasets[1].data[value] = response.data[value].value;
                        } else {
                            this.chartdata.labels[value] = "";
                            this.chartdata.datasets[0].data[value] = response.data[value].value;
                        }
                    }

                    this.renderChart(this.chartdata, this.options)
                })
                .catch((error) => {
                    console.log("error");
                    console.log(error.response)
                });
        },
    },
    mounted() {
        this.getData();
    }
}
</script>