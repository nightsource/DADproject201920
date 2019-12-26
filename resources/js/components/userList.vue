<template>
 <div class="overflow-auto">
    <b-pagination v-model="currentPage" :total-rows="rows" :per-page="perPage" aria-controls="my-table"></b-pagination>
     
    

    <b-table  striped hover :items="users" :fields="fields" id="my-table" :per-page="perPage" :current-page="currentPage" >
            
          <template v-slot:cell(photo)="row" v-slot:key="user.photo" :class="{active: currentUser === user}" >
              <b-img class="rounded" :src="'/storage/fotos/' + users.photo" ></b-img>
           </template>     
       
        <template v-slot:cell(actions)="row" v-slot:key="user.id" :class="{active: currentUser === user}">
            <b-button variant="success" v-on:click="editUser(row.item)">Edit</b-button>
            <b-button variant="danger" v-on:click="deleteUser(row.item)">Delete</b-button>
       </template>    

    </b-table>  
    
     <user-edit v-if="currentUser!=undefined"  :user="currentUser"></user-edit>
       


   <!--  <table class="table table-striped"  >
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Nif</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id" :class="{active: currentUser === user}">
                    <td><img :src="'/storage/fotos/' + user.photo"></td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.type }}</td>
                    <td>{{ user.nif }}</td>
                    <td>{{ user.active }}</td>
                    <td>
                        <a class="btn btn-sm btn-primary" v-on:click.prevent="editUser(user)">Edit</a>
                        <a class="btn btn-sm btn-danger" v-on:click.prevent="deleteUser(user)">Delete</a>
                    </td>
                </tr>
            </tbody>
    </table> -->


        
       </div> 
</template>

<script>
import usersVue from './users.vue'
import UserEdit from './userEdit.vue'

    export default {
        props:['users'],
        data:function(){
          return{
                perPage: 10,
                currentUser:undefined,
                currentPage: 1,
                fields:[{ key: 'photo', sortable: false}, 
                        {key: 'name', sortable: true }, 
                        {key: 'email', sortable: false },
                        {key: 'type', sortable: true }, 
                        {key: 'nif', sortable: false }, 
                        {key: 'active', sortable: false }, 
                        {key: 'actions', sortable: false } ],
            }
        },  
        methods:{
            editUser(user){
                console.log(user)
                this.currentUser=user
            },

            deleteUser(user){
                this.$emit('delete-user', user)    
            },
            
        },  
        computed: {
           rows() {                
                return this.users.length
            }
        },components:{
            "user-edit": UserEdit, 
        }
        
       
    }
   

</script>
<style >


</style>