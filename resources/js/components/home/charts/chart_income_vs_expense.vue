<script>
import {
    Bar
} from 'vue-chartjs'

export default {
    extends: Bar,
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
</script>
