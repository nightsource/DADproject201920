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
                <label for="inputType">Type</label>
                <input
                    type="type" class="form-control" v-model="user.type"
                    name="type" id="inputType"
                    placeholder="Type" value=""/>
            </div>
            <div class="form-group">
                <label for="inputNIF">NIF</label>
                <input
                    type="number" class="form-control" v-model="user.nif"
                    name="nif" id="inputNIF"
                    placeholder="NIF" value=""/>
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
 methods: {
	        saveUser: function(){
	            axios.put('api/users/'+this.user.id, this.user)
	                .then(response=>{
	                	Object.assign(this.user, response.data.data);
                        this.$emit('user-saved', this.user)
                        
                        this.showSuccess = true
                        this.successMessage = "User Saved"

	                });
	        },
	        cancelEdit: function(){
	        	axios.get('api/users/'+this.user.id)
	                .then(response=>{
	                	// Copy object properties from response.data.data to this.user
	                	// without creating a new reference
	                	Object.assign(this.user, response.data.data);
	                	this.$emit('user-canceled', this.user);
                    });
	        }
		}
}
</script>

<style 
>

</style>