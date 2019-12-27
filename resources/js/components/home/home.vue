<template>
<div>
    <last-access :user="this.$root.user"></last-access>

    <section class="statistics">
        <div class="container-fluid">
            <div class="row">
                <statistics :fa="'fas fa-euro-sign'" :value="$root.userWallet.balance" :valuesymbol="'€'" :type="'bg-primary'" :desc="'Current balance'">
                </statistics>
            </div>
        </div>
    </section>

    <section class="charts">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="chart-container">
                        <h3>Monthly Balance</h3>
                        <chart-balance-monthly ref="chartbalance" :chartdata="chartdatabalance"></chart-balance-monthly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chart-container">
                        <h3>Income vs Expense</h3>
                        <chart-balance-income-vs-expense ref="chartincomeexpense" :chartdata="chartdataincomeexpense"></chart-balance-income-vs-expense>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chart-container">
                        <h3>Latests 30 movements</h3>
                        <latests-movements :tabledata="tablemovements"></latests-movements>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</template>

<script>
import ChartBalanceIncomeExpenseComponent from "./charts/chart_income_vs_expense";
import ChartBalanceMonthlyComponent from "./charts/chart_balance_monthly";
import LatestsMovementsComponent from "./components/latests_movements";
import Statistics from "./components/statistics";
import LastAccess from "./components/last_access";

export default {
    data: function () {
        return {
            chartdatabalance: {
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
            chartdataincomeexpense: {
                labels: [],
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
            tablemovements: [],
        }
    },
    methods: {
        async getBalanceMonthly() {
            axios
                .get("api/user/movements/monthly")
                .then(response => {
                    for (let value in response.data) {
                        this.chartdatabalance.labels[value] = response.data[value].label;
                        this.chartdatabalance.datasets[0].data[value] = response.data[value].data;
                    }

                    this.$refs.chartbalance.render();
                })
                .catch((error) => {
                    console.log("error");
                    console.log(error.response)
                });
        },
        async getIncomeExpense() {
            axios
                .get("api/user/movements/incomeexpense")
                .then(response => {
                    for (let value in response.data) {
                        if (response.data[value].type == 'i') {
                            this.chartdataincomeexpense.labels[value] = response.data[value].label;
                            this.chartdataincomeexpense.datasets[1].data[value] = response.data[value].value;
                        } else {
                            this.chartdataincomeexpense.labels[value] = "";
                            this.chartdataincomeexpense.datasets[0].data[value] = response.data[value].value;
                        }
                    }

                    this.$refs.chartincomeexpense.render();
                })
                .catch((error) => {
                    console.log("error");
                    console.log(error.response)
                });
        },
        async getLatestsMovements() {
            axios
                .get("api/user/movements/latests")
                .then(response => {
                    this.tablemovements = response.data.data;

                    this.tablemovements.forEach(movement => {
                        movement.date = new Date(movement.date).toLocaleString('en-GB', {
                            timeZone: 'UTC'
                        })

                        if (movement.type == 'e') {
                            movement.value = 0 - movement.value
                            movement._cellVariants = "{ value: 'danger' }"
                        }

                        movement.value = "€ " + movement.value
                    });
                })
                .catch((error) => {
                    console.log("error");
                    console.log(error)
                });
        },
    },
    mounted() {
        this.getIncomeExpense();
        this.getBalanceMonthly();
        this.getLatestsMovements();
    },
    components: {
        "chart-balance-income-vs-expense": ChartBalanceIncomeExpenseComponent,
        "chart-balance-monthly": ChartBalanceMonthlyComponent,
        "latests-movements": LatestsMovementsComponent,
        "statistics": Statistics,
        "last-access": LastAccess
    },
}
</script>

<style>
/* Start stats*/
.statistics {
    margin-top: 25px;
    color: #212121;
}

.statistics .box {
    background-color: #CECECE;
    padding: 15px;
    overflow: hidden;
}

.statistics .box>i {
    float: left;
    color: #FFF;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    line-height: 60px;
    font-size: 22px;
}

.statistics .box .info {
    float: left;
    width: auto;
    margin-left: 10px;
}

.statistics .box .info h3 {
    margin: 5px 0 5px;
    display: inline-block;
}

.statistics .box .info p {
    color: #212121
}

.warning {
    background-color: #f0ad4e
}

.danger {
    background-color: #d9534f
}

.success {
    background-color: #5cb85c
}

.inf {
    background-color: #5bc0de
}

/* Start Charts*/
.charts {
    margin-top: 25px;
    color: #212121
}

.charts .chart-container {
    height: 460px;
    background-color: #CECECE;
    padding: 15px;
}

.charts .chart-container h3 {
    margin: 0 0 10px;
    font-size: 17px;
}
</style>
