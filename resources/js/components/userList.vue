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
            <b-form-checkbox value="name">Name</b-form-checkbox>
            <b-form-checkbox value="type">Type</b-form-checkbox>
            <b-form-checkbox value="active">Active</b-form-checkbox>
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

<b-table striped hover
      id="my-table" 
      show-empty
      small
      stacked="md"
      :items="users"
      :fields="fields"
      :current-page="currentPage"
      :per-page="perPage"
      :filter="filter"
      :filterIncludedFields="filterOn"
      :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc"
      :sort-direction="sortDirection"
      @filtered="onFiltered"
    >
      
        <template v-slot:cell(photo)="row" v-slot:key="user.id" :class="{active: currentUser === user}" >
              <b-img v-bind="mainProps"  :src="'/storage/fotos/' + row.item.photo" ></b-img>
      
        </template>     

       <template v-slot:cell(actions)="row" v-slot:key="user.id" :class="{active: currentUser === user}">
           <b-button-group>
                <b-button variant="success" size="sm" @click="editUser(row.item)">Edit</b-button>
                <b-button variant="primary" size="sm" v-if="row.item.active" @click="deactivate(row)">Deactivate</b-button>
                <b-button variant="primary" size="sm" v-if="!row.item.active" @click="activate(row)">Activate</b-button>
                <b-button variant="danger"  size="sm" @click="deleteUser(row.item)" >Delete</b-button>
            </b-button-group>
       </template>  

            <template v-slot:row-details="row">
        <b-card>
          <ul>
            <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value }}</li>
          </ul>
        </b-card>
      </template>
    </b-table>

  <user-edit  v-if="currentUser!=undefined"  :user="currentUser"></user-edit>  
</b-container>
</template>

<script>
import usersVue from './users.vue'
import UserEdit from './userEdit.vue'

    export default {
        props:['users'],
        data:function(){
          return{
               
                fields:[{ key: 'photo', label: 'Photo', sortable: false, }, 
                        {key: 'name', label: 'Name', sortable: true, sortDirection: 'desc' }, 
                        {key: 'email', label: 'Email', sortable: true },
                        {key: 'type', label: 'Type', sortable: true }, 
                        {key: 'nif', label: 'Nif', sortable: true }, 
                        {key: 'balance', label: 'Balance', sortable: true }, 
                        {key: 'active', label: 'Active', 
                        formatter: (value, key, item) => {return value ? 'Yes' : 'No'}, 
                                sortable: true, sortByFormatted: true, filterByFormatted: true}, 
                        
                        {key: 'actions', label: 'Actions', sortable: false } ],
                currentUser:undefined,
                currentPage: 1, 
                perPage: 10,
                pageOptions: [5, 10, 15, 25, 50],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
                delete_response: '',
                delete_user: 'danger',
              mainProps:{width: 70, height: 70,}
            }
        },  
        methods:{
            editUser(user){
               this.$emit('edit-user',user)
            },

            deleteUser(user){
                this.$emit('delete-user', user)    
            },
             activate(row) {
                row.item.active = 1;
                axios.put('api/users/'+ row.item.name, row.item)
                 .then(response => {
                    this.delete_user = "success";
                    this.delete_response = "Activated successfully!";
                })
                .catch((error) => {
                    console.log("ERROR: user->activate()");
                    console.log(error)
                    this.delete_user = "danger";
                    this.delete_response = error;
                });
            },
             deactivate(row) {
                row.item.active = 0;
                axios.put('api/users/'+ row.item.name, row.item)
                 .then(response => {
                    this.delete_user = "success";
                    this.delete_response = "Deactivated successfully!";
                })
                .catch((error) => {
                    console.log("ERROR: user->deactivate()");
                    console.log(error)
                    this.delete_user = "danger";
                    this.delete_response = error;
                });
            }, 
             onFiltered(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
        },  
        computed: {
           rows() {                
                return this.users.length
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
            "user-edit": UserEdit, 
        }, 
       
       
    }
   

</script>
<style >


</style>