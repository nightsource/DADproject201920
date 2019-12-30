<template>
    <div><div class="jumbotron"> <h1>{{ title }}</h1></div>

             
       <user-list :users="users" v-on:edit-user="editUser" :current-user="currentUser" 
      v-on:delete-user="deleteUser"  :message="childMessage" ref="userListReference"></user-list>

        <div class="alert alert-success" v-if="showSuccess">
            <b-button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</b-button>
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
        users: [],
        pagination: {} , 
        wallets: [],
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
               })
                
        },
         childMessage: function(message) {
            this.showSuccess = true;
            this.successMessage = message;
        },
         getWallets: function(){
                axios.get('api/wallets')
                .then(response=>{
                    console.log(wallets)
                    this.wallets = response.data.data;
               })
                
        }
    },
    mounted() {
       this.getUsers();
       this.getWallets();

    },
    components:{
        'user-list':UserListComponent,
        'user-edit': UserEditingComponent,
    
    }
    
}
</script>

<style >

</style>