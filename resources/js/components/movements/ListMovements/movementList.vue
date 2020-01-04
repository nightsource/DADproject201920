<template>

  <b-container fluid>
    <b-row>
      <b-col lg="6" class="my-1">
        <b-form-group
          label="Sort"
          label-cols-sm="3"
          label-align-sm="right"
          label-size="sm"
          label-for="sortBySelect"
          class="mb-0"
        >
          <b-input-group size="sm">
            <b-form-select v-model="sortBy" id="sortBySelect" :options="sortOptions" class="w-75">
              <template v-slot:first>
                <option value="">-- none --</option>
              </template>
            </b-form-select>
            <b-form-select v-model="sortDesc" size="sm" :disabled="!sortBy" class="w-25">
              <option :value="false">Asc</option>
              <option :value="true">Desc</option>
            </b-form-select>
          </b-input-group>
        </b-form-group>
      </b-col>

      <b-col lg="6" class="my-1">
        <b-form-group
          label="Initial sort"
          label-cols-sm="3"
          label-align-sm="right"
          label-size="sm"
          label-for="initialSortSelect"
          class="mb-0"
        >
          <b-form-select
            v-model="sortDirection"
            id="initialSortSelect"
            size="sm"
            :options="['asc', 'desc', 'last']"
          ></b-form-select>
        </b-form-group>
      </b-col>

      <b-col lg="6" class="my-1">
        <b-form-group
          label="Filter"
          label-cols-sm="3"
          label-align-sm="right"
          label-size="sm"
          label-for="filterInput"
          class="mb-0"
        >
          <b-input-group size="sm">
            <b-form-input
              v-model="filter"
              type="search"
              id="filterInput"
              placeholder="Type to Search"
            ></b-form-input>
            <b-input-group-append>
              <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
            </b-input-group-append>
          </b-input-group>
        </b-form-group>
      </b-col>
      

      <b-col lg="6" class="my-1">
        <b-form-group
          label="Filter On"
          label-cols-sm="3"
          label-align-sm="right"
          label-size="sm"
          description="Leave all unchecked to filter on all data"
          class="mb-0">
          <b-form-checkbox-group v-model="filterOn" class="mt-1">
            <b-form-checkbox value="wallet_id">Wallet ID</b-form-checkbox>
            <b-form-checkbox value="type">Type</b-form-checkbox>
            <b-form-checkbox value="type_payment">Type Payment</b-form-checkbox>
             <b-form-checkbox value="category_id">Category</b-form-checkbox>
             <b-form-checkbox value="date">Date</b-form-checkbox>
          </b-form-checkbox-group>
        </b-form-group>
      </b-col>

      <b-col sm="5" md="6" class="my-1">
        <b-form-group
          label="Per page"
          label-cols-sm="6"
          label-cols-md="4"
          label-cols-lg="3"
          label-align-sm="right"
          label-size="sm"
          label-for="perPageSelect"
          class="mb-0"
        >
          <b-form-select
            v-model="perPage"
            id="perPageSelect"
            size="sm"
            :options="pageOptions"
          ></b-form-select>
        </b-form-group>
      </b-col>

      <b-col sm="7" md="6" class="my-1">
         <b-pagination
            v-model="currentPage" 
            :total-rows="rows" 
            align="fill" 
            size="sm" 
            :per-page="perPage" 
            aria-controls="my-table"></b-pagination>
      </b-col>
    </b-row>


  <b-col sm="5" md="6" class="my-1">
        <b-form-group
          label="Date"
          label-cols-sm="6"
          label-cols-md="4"
          label-cols-lg="3"
          label-align-sm="right"
          label-size="sm"
          label-for="dateSelect"
          class="mb-0"
        >
            <date-picker 
            v-model="range" 
            id="dateSelect" 
            :lang="lang" range confirm
            v-on:change="onDateRangeChanged"
            ></date-picker>

        </b-form-group>
      </b-col>

<button @click="filterClick">Filtrar</button>
    

<b-table striped hover
      id="my-table" 
      show-empty
      small
      stacked="md"
      :items="movements"
      :fields="fields"
      :current-page="currentPage"
      :per-page="perPage"
      :filter="filter"
      :filterIncludedFields="filterOn"
      :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc"
      :sort-direction="sortDirection"
      @filtered="onFiltered"
      :date="range"
    >

   <template v-slot:cell(actions)="row" v-slot:key="movement.id" :class="{active: currentMovement === movement}">
         <b-button variant="success" size="sm" v-on:click="editMovement(row.item)">Edit</b-button>
      </template> 

           <template v-slot:row-details="row">
        <b-card>
          <ul>
            <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value }}</li>
          </ul>
        </b-card>
      </template>
    </b-table>

      <movement-edit  v-if="currentMovement!=undefined"  :movement="currentMovement"></movement-edit>
</b-container>
</template>



<script>
import movementsVue from './movements.vue'
import MovementEdit from './movementEdit.vue'
import DatePicker from 'vue2-datepicker'

export default {
        props:['movements'],
        data:function(){
          return{
               
                fields:[{ key: 'id', label: 'ID', sortable: true },
                  { key: 'wallet_id', label: 'Wallet ID', sortable: true }, 
                        {key: 'type', label: 'Type', sortable: true, sortDirection: 'desc' }, 
                        {key: 'transfer_movement_id', label: 'Transfer Movement', sortable: true },
                        {key: 'transfer_wallet_id', label: 'Transfer Wallet', sortable: true }, 
                        {key: 'type_payment', label: 'Type Payment', sortable: true }, 
                        {key: 'category_id', label: 'Category ID', sortable: true }, 
                        {key: 'iban', label: 'iban', sortable: true }, 
                        {key: 'mb_entity_code', label: 'MB Entity Code', sortable: true }, 
                        {key: 'mb_payment_reference', label: 'MB Payment Reference', sortable: true },
                        {key: 'description', label: 'Description', sortable: true },
                        {key: 'date', label: 'Date', sortable: true }, 
                        {key: 'start_balance', label: 'Start Balance', sortable: true }, 
                        {key: 'end_balance', label: 'End Balance', sortable: true }, 
                        {key: 'value', label: 'Value', sortable: true },
                        {key: 'actions', label: 'Actions', sortable: false }  ],
                currentMovement:undefined,
                currentPage: 1,
                perPage: 10,
                pageOptions: [5, 10, 15, 25, 50],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
                delete_response: '',
                delete_movement: 'danger',
                date:'',
                time:'',
                timePickerOptions:{
                  start: '00:00', 
                  step: '00:30',
                  end: '23:30',
                  format:'HH:mm'
                },
                datetime: '',
                range: '', 
                lang: {
                      days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                      months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                      pickers: ['next 7 days', 'next 30 days', 'previous 7 days', 'previous 30 days'],
                      placeholder: {
                        date: 'Select Date',
                        dateRange: 'Select Date Range'
                      }
                    }
            }
        },  
        methods:{
           editMovement(movement){
                this.$emit('edit-movement',movement)
            },
            onFiltered(filteredItems) {
              // Trigger pagination to update the number of buttons/pages due to filtering
              this.totalRows = filteredItems.length
              this.currentPage = 1
            },
            onDateRangeChanged: function(picker){
              this.range = picker[0] + " - " + picker[1];    	
              },
              filterClick(){
                console.log(this.range)

              }
        },  
        computed: {
           rows() {                
                return this.movements.length
            },
            sortOptions() {
                // Create an options list from our fields
                return this.fields
                .filter(f => f.sortable)
                .map(f => {
                    return { text: f.label, value: f.key }
                })
            }
        },components:{
          "movement-edit": MovementEdit,
          DatePicker,

        }
    }  


</script>
<style >


</style>