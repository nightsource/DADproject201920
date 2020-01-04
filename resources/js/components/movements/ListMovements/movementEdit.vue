<template>
    
    <div class="jumbotron"> 
        
        <h2>Edit Movement</h2>
    
  
     <b-form-group id="input-group-2" label="Description" label-for="input-2">
                    <b-form-input
                    id="input-2"
                    v-model="movement.description" required
                    placeholder="Enter name"
                    ></b-form-input>
      </b-form-group>

    
   <b-form-group label="Category:">
        <b-form-select v-model="movement.category_id"  class="mb-3" @input="choose">
          <!-- This slot appears above the options from 'options' prop -->
          <template v-slot:first>
            <option :value="null" disabled>-- Please select a category --</option>
          </template>
          <!-- These options will appear after the ones from 'options' prop  -->
          <option
            v-for="category in categories"
            :key="category.id"
            :value="category.id"
            :text="category.name"
          >{{  category.name }}</option>

          
        </b-form-select>  
      </b-form-group>
     
     <b-button type="submit" variant="primary" v-on:click.prevent="saveMovement()">Save</b-button>
     <b-button type="reset" variant="danger" v-on:click.prevent="cancelEdit()">Cancel</b-button>

    </div>
</template>

<script>

export default {
props: ['movement'],
data: function() {
        return {
            categories: [],


            
        }
    }, 
    methods: {
        choose(value){
          console.log(value)

          if(value != category.category_id){
              category.category_id=cat.id;
               console.log("vxczvcvxcvzxcbzvcbzfb", cat)

          }
        /*	this.categories.forEach(cat => {
             if(cat.name==value)category.category_id=cat.id;
               console.log("vxczvcvxcvzxcbzvcbzfb", cat)
	         });*/
          
        },

    	        saveMovement: function(){
            console.log(this.movement)
               axios.put('api/user/movements/'+ this.movement.id, this.movement)
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
            },
            getCategories() {
                axios.get("api/categories").then(response => {
                    this.categories = response.data.data;


                                
                });
            },
        },
         mounted() {
            this.getCategories();
        }
}
</script>

<style 