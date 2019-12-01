<template>
 <div class="overflow-auto">
    <b-pagination v-model="currentPage" :total-rows="rows" :per-page="perPage" aria-controls="my-table"></b-pagination>
   
    <p class="mt-3">Current Page: {{ currentPage }}</p>

    <b-table  striped hover :items="items"  :fields="fields" id="my-table" :per-page="perPage" :current-page="currentPage" small>
                
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
                perPage: 3,
                currentPage: 1,
                fields:[{ key: 'Photo', sortable: false}, 
                        {key: 'Name', sortable: true }, 
                        {key: 'Email', sortable: false },
                        {key: 'Type', sortable: true }, 
                        {key: 'NIF', sortable: false }, 
                        {key: 'Active', sortable: false }, 
                        {key: 'Actions', sortable: false } ],
                
                items: [
                   
                ]
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
                return this.items.length
            }
        }
    }
   

</script>
<style >


</style>