<template>
<div>
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
                        <chart-balance-monthly></chart-balance-monthly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chart-container">
                        <h3>Income vs Expense</h3>
                        <chart-balance-income-vs-expense></chart-balance-income-vs-expense>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chart-container">
                        <h3>Latests 30 movements</h3>
                        <latests-movements></latests-movements>
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

export default {
    data: function () {
        return {
            
        }
    },
    methods: {},
    components: {
        "chart-balance-income-vs-expense": ChartBalanceIncomeExpenseComponent,
        "chart-balance-monthly": ChartBalanceMonthlyComponent,
        "latests-movements": LatestsMovementsComponent,
        "statistics": Statistics
    },
}
</script>

<style>
.statistics {
  margin-top: 25px;
  color: #212121;
}
.statistics .box {
  background-color: #CECECE;
  padding: 15px;
  overflow: hidden;
}
.statistics .box > i {
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
.statistics .box .info p {color:#212121}

.warning {background-color: #f0ad4e}
.danger {background-color: #d9534f}
.success {background-color: #5cb85c}
.inf {background-color: #5bc0de}

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