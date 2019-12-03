<template>
 <div class="overflow-auto">
    <b-pagination v-model="currentPage" :total-rows="rows" :per-page="perPage" aria-controls="my-table"></b-pagination>
   
    <b-table  striped hover :items="users" :fields="fields" id="my-table" 
    :per-page="perPage" :current-page="currentPage">
            
                  
       <b-button></b-button>

    </b-table>  
    
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
    export default {
        props:['users', 'currentUser'],
        data:function(){
          return{
                perPage: 10,
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
                this.$emit('edit-user',user)
            },

            deleteUser(user){
                this.$emit('delete-user', user)    
            },
            
        },  
        computed: {
            rows() {                
                return this.users.length
            }
        }
    }
   

</script>
<style >


</style>