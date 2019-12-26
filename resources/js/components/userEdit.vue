<template>
    <div class="jumbotron"  >
            <h2>Edit User</h2>
            <div class="form-group">
                <label for="inputName">Name</label>
                <input
                    type="text" class="form-control" v-model="user.name"
                    name="name" id="inputName" 
                    placeholder="Fullname" value="" />
            </div>
            <div class="form-group">
                <label for="inputEmail">Email</label>
                <input
                    type="email" class="form-control" v-model="user.email"
                    name="email" id="inputEmail"
                    placeholder="Email address" value=""/>
            </div>
            <div class="form-group">
                <label for="inputNIF">NIF</label>
                <input
                    type="number" class="form-control" v-model="user.nif"
                    name="nif" id="inputNIF"
                    placeholder="NIF" value=""/>
            </div>
            <div class="form-group">
                 <label for="inputPhoto">Photo</label>
                <input
                    type="download" class="form-control" v-model="user.photo"
                    name="photo" id="inputPhoto"
                    placeholder="Photo" value=""/>
                    <a><button class="btn btn-light" style="width:100%"> Download</button></a>
            </div>
            
            <div class="form-group">
                <a class="btn btn-primary" v-on:click.prevent="saveUser()">Save</a>
                <a class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</a>
            </div>

        </div>
</template>

<script>

export default {
props: ['user'],
 methods:{
     saveUser(){
        this.$emit('save-user',this.user)
     }, 
     cancelEdit(){
            this.$emit('cancel-user')
     }
 }

    
       
}
</script>

<style 
>

</style>