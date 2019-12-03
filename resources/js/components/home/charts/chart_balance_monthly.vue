<script>
import {
    Line
} from 'vue-chartjs'

export default {
    extends: Line,
    props: ['chartdata'],
    data: function () {
        return {
            options: {
                responsive: true,
                maintainAspectRatio: false
            },
        }
    },
    methods: {
        render() {
            this.renderChart(this.chartdata, this.options)
        },
    },
    mounted() {}
}

Chart.defaults.global.animation.duration = 2000; // Animation duration
Chart.defaults.global.title.display = false; // Remove title
Chart.defaults.global.defaultFontColor = '#212121'; // Font color
Chart.defaults.global.defaultFontSize = 12; // Font size for every label

Chart.defaults.global.tooltips.backgroundColor = '#212121'; // Tooltips background color
Chart.defaults.global.tooltips.borderColor = 'white'; // Tooltips border color
Chart.defaults.global.legend.labels.padding = 0;
Chart.defaults.scale.ticks.beginAtZero = true;

Chart.defaults.global.legend.display = false;
</script>
