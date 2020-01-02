<template>
    <div class="jumbotron"  >
            <h2>Edit Movement</h2>
            <div class="form-group">
                <label for="inputDescription">Description</label>
                <input
                    type="text" class="form-control" v-model="movement.description"
                    name="description" id="inputDescription" 
                    placeholder="Description" value="" />
            </div>
            
            <div class="form-group">
                <label for="inputCategory">Category</label>
                <input
                    type="number" class="form-control" v-model="movement.category_id"
                    name="category" id="inputCategory"
                    placeholder="" value=""/>
            </div>
                      
            <div class="form-group">
                <a class="btn btn-primary" v-on:click.prevent="saveMovement()">Save</a>
                <a class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</a>
            </div>

        </div>
</template>

<script>

export default {
props: ['movement'],
 methods: {
	        saveMovement: function(){
	            axios.put('api/user/movements/'+this.movement.id, this.movement)
	                .then(response=>{
	                	Object.assign(this.movement, response.data.data);
                        this.$emit('movement-saved', this.movement)
                        this.showSuccess = true
                        this.successMessage = "Movement Saved"

	                });
	        },
	        cancelEdit: function(){
	        	axios.get('api/user/movements/'+this.movement.id)
	                .then(response=>{
	                	Object.assign(this.movement, response.data.data);
	                	this.$emit('movement-canceled', this.movement);
                    });
	        }
		}
}
</script>

<style 