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
                axios.get('api/users?page=1')
                .then(response=>{
                    this.users = response.data.data;
                    this.pagination ={
                    current_page: response.data.meta.current_page,
                    last_page: response.data.meta.last_page,
                    from_page: response.data.meta.from,
                    to_page: response.data.meta.to,
                    total_page: response.data.meta.total,
                    path_page: response.data.meta.path + "page=",
                    first_link: response.data.links.first,
                    last_link: response.data.links.last,
                    prev_link: response.data.links.prev,
                    next_link: response.data.links.next
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