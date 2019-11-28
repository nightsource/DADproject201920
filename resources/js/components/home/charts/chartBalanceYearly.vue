<script>
import {
    Bar
} from 'vue-chartjs'

Chart.defaults.global.animation.duration = 2000; // Animation duration
Chart.defaults.global.title.display = false; // Remove title
Chart.defaults.global.title.text = "Chart"; // Title
Chart.defaults.global.title.position = 'bottom'; // Title position
Chart.defaults.global.defaultFontColor = '#999'; // Font color
Chart.defaults.global.defaultFontSize = 10; // Font size for every label

// Chart.defaults.global.tooltips.backgroundColor = '#FFF'; // Tooltips background color
Chart.defaults.global.tooltips.borderColor = 'white'; // Tooltips border color
Chart.defaults.global.legend.labels.padding = 0;
Chart.defaults.scale.ticks.beginAtZero = true;
Chart.defaults.scale.gridLines.zeroLineColor = 'rgba(255, 255, 255, 0.1)';
Chart.defaults.scale.gridLines.color = 'rgba(255, 255, 255, 0.02)';

Chart.defaults.global.legend.display = false;

export default {
    extends: Bar,
    data: function () {
        return {
            chartdata: {
                labels: ["January", "February", "March", "April", "May", 'Jul'],
                datasets: [{
                    label: "Lost",
                    fill: false,
                    lineTension: 0,
                    data: [45, 25, 40, 20, 45, 20],
                    pointBorderColor: "#4bc0c0",
                    borderColor: '#4bc0c0',
                    borderWidth: 2,
                    showLine: true,
                }, {
                    label: "Succes",
                    fill: false,
                    lineTension: 0,
                    startAngle: 2,
                    data: [20, 40, 20, 45, 25, 60],
                    // , '#ff6384', '#4bc0c0', '#ffcd56', '#457ba1'
                    backgroundColor: "transparent",
                    pointBorderColor: "#ff6384",
                    borderColor: '#ff6384',
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

    },
    mounted() {
        this.renderChart(this.chartdata, this.options)
    }
}
</script>

<style>
</style>
