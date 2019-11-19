<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
     </div>

    <div><a class="btn btn-primary">Add user</a></div>

              
       <user-list :users="users" v-on:edit-user="editUser" :current-user="currentUser" 
      v-on:delete-user="deleteUser" ref="userListReference"></user-list>

        <div class="alert alert-success" v-if="showSuccess">
            <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
            <strong>{{ successMessage }}</strong>
        </div>  

       <div class="row">
           <div class="col-md-8">
               <nav>
                   <ul class="pagination">
                       <li v-bind:class="{disabled:!pagination.first_link}" class="page-item"><a href="#" @click="getUsers(pagination.first_link)" class="page-link">&laquo;</a></li>
                       <li v-bind:class="{disabled:!pagination.prev_link}" class="page-item"><a href="#" @click="getUsers(pagination.prev_link)" class="page-link">&lt;</a></li>
                       <li v-for="n in pagination.las_page" v-bind:key="n" v-bind:class="{active:!pagination.current_page == n}" class="page-item"><a href="#" @click="getUsers(pagination.path_page + n)" class="page-link">{{n}}</a></li>
                       <li v-bind:class="{disabled:!pagination.next_link}" class="page-item"><a href="#" @click="getUsers(pagination.next_link)" class="page-link">&gt;</a></li>
                       <li v-bind:class="{disabled:!pagination.last_link}" class="page-item"><a href="#" @click="getUsers(pagination.last_link)" class="page-link">&raquo;</a></li>
                   </ul>
               </nav>

           </div>
           <div class="col-md-4">
               Page: {{pagination.from_page}} - {{pagination.to_page}}
               Total : {{pagination.total_page}}
           </div>
       </div>

          <user-edit v-if="editingUser" :user="currentUser" @save_user="saveUser" @cancel_edit="cancelEdit"></user-edit>
    </div>
</template>

<script>
import UserListComponent from './userList'
import UserEditingComponent from './userEdit'

export default{

    data:function(){
        return{
        title: 'List Users',
        editingUser: false,
        showSuccess: false,
        showFailure: false,
        successMessage: '',
        failMessage: '',
        currentUser: null,
        users: {},
       pagination: {}  
        }    
         
    },

    methods:{
          editUser: function(user){
            this.currentUser = user;
            this.editingUser = true;
            this.showSuccess = false;
        },
          deleteUser: function(user){
            axios.delete('api/users/'+user.id)
                .then(response => {
                    this.showSuccess = true;
                    this.successMessage = 'User Deleted';
                    this.getUsers();
                });
        },
        saveUser: function(user){
            this.editingUser = false;            
            axios.put('api/users/'+this.currentUser.id,this.currentUser)
                .then(response=>{
                    this.showSuccess = true;
                    this.successMessage = 'User Saved';
                    // Copies response.data.data properties to this.currentUser
                    // without changing this.currentUser reference
                    Object.assign(this.currentUser, response.data.data);
                    this.currentUser = null;
                    this.editingUser = false;
                    this.$refs.userListReference.currentUser = null;
                });
        },
        cancelEdit: function(user){
            this.showSuccess = false;
            this.editingUser = false;
            axios.get('api/users/'+this.currentUser.id)
                .then(response=>{
                    console.dir (this.currentUser);
                    // Copies response.data.data properties to this.currentUser
                    // without changing this.currentUser reference
                    Object.assign(this.currentUser, response.data.data); 
                    console.dir (this.currentUser);
                    this.currentUser = null;
                });
        },
        getUsers: function(){
                       axios.get('api/users')
                .then(response=>{
                    this.users = response.data.data;
                    this.pagination ={
                    current_page: response.meta.current_page,
                    last_page: response.meta.last_page,
                    from_page: response.meta.from,
                    to_page: response.meta.to,
                    total_page: response.meta.total,
                    path_page: response.meta.path + "page=",
                    first_link: response.links.first,
                    last_link: response.links.last,
                    prev_link: response.links.prev,
                    next_link: response.links.next
                    };
                })
                
        }
        
    },
    mounted() {
       this.getUsers();

    },
    components:{
        'user-list':UserListComponent,
        'user-edit': UserEditingComponent,
    
    }
    
    }
</script>

<style >

</style>