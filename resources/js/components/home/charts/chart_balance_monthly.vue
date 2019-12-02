<script>
import {
    Line
} from 'vue-chartjs'

Chart.defaults.global.animation.duration = 2000; // Animation duration
Chart.defaults.global.title.display = false; // Remove title
Chart.defaults.global.defaultFontColor = '#212121'; // Font color
Chart.defaults.global.defaultFontSize = 12; // Font size for every label

Chart.defaults.global.tooltips.backgroundColor = '#212121'; // Tooltips background color
Chart.defaults.global.tooltips.borderColor = 'white'; // Tooltips border color
Chart.defaults.global.legend.labels.padding = 0;
Chart.defaults.scale.ticks.beginAtZero = true;

Chart.defaults.global.legend.display = false;

export default {
    extends: Line,
    data: function () {
        return {
            chartdata: {
                labels: [],
                datasets: [{
                    label: "Balance",
                    fill: true,
                    data: [],
                    pointBorderColor: "#4bc0c0",
                    borderColor: '#4bc0c0',
                    borderWidth: 2,
                    showLine: true,
                }]
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
                .get("api/user/movements/monthly")
                .then(response => {
                    for (let value in response.data) {
                        this.chartdata.labels[value] = response.data[value].label;
                        this.chartdata.datasets[0].data[value] = response.data[value].data;
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