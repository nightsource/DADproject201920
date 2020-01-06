<template>
<div>
    <b-table id='movements-table' :small="true" :fixed="true" :striped="true" 
    :fields="fields" :items="tabledata" :per-page="perPage" :current-page="currentPage"></b-table>
<!--     
    <b-pagination pills align="center" v-model="currentPage" :total-rows="rows" 
    :per-page="perPage" size="sm" aria-controls="movements-table"></b-pagination> -->
</div>
</template>

<script>
    export default {
        props: ['tabledata'],
        data: function () {
            return {
                fields: [{
                        key: 'date',
                        sortable: true
                    },
                    {
                        key: 'value',
                        sortable: true
                    }
                ],
                perPage: 10,
                currentPage: 1,
            }
        },
        methods: {},
        computed: {
            rows() {
                return this.tabledata.length
            }
        }
    }
</script>

<style scoped>

</style>