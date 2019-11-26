<template>
 <div>
    <table class="table table-striped">
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
                    <td><img :src="'public/storage/app/public/fotos/' +user.photo" width="100" height="100"></td>
                    
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
    </table>
        
       </div> 
</template>

<script>
    export default {
        props:['users', 'currentUser'],
        data:function(){
          return{
              // <td><img :src="'/storage/app/public/fotos/' +user.photo" width="100" height="100"></td>
          }
        },  
        methods:{
            editUser(user){
                this.$emit('edit-user',user)
            },

            deleteUser(user){
                this.$emit('delete-user', user)    
            },
            
		}
    }
   

</script>

<style >

</style>