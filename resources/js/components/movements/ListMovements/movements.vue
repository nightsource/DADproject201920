<template>
        <div><div class="jumbotron"> <h1>{{ title }}</h1></div>

        <movement-list  :movements="movements" v-on:edit-movement="editMovement" 
            :current-movement="currentMovement" :message="childMessage" ref="movementListReference"></movement-list>
       
        <div class="alert alert-success" v-if="showSuccess">
            <b-button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</b-button>
            <strong>{{ successMessage }}</strong>
        </div>  

          <movement-edit v-if="editingMovement" :movement="currentMovement" :categories="categories"  @save_movement="saveMovement" @cancel_edit="cancelEdit"></movement-edit>
        </div>
</template>

<script>
import MovementListComponent from './movementList'
import MovementEditingComponent from './movementEdit'

export default{
     data:function(){
        return{
            title: 'List Movements',
            movements: [],
            categories: [],
            pagination: [],
            currentMovement: null,
            editingMovement: false,
            showSuccess: false,
            showFailure: false,
            successMessage: '',
            failMessage: '',
        }
    },
    methods:{
        editMovement: function(movement){
            this.currentMovement = movement;
            this.editingMovement = true;
            this.showSuccess = false;
           
        },
        saveMovement: function(movement){
            this.editingMovement = false;            
            axios.put('api/user/movements/'+this.currentMovement.id,this.currentMovement)
                .then(response=>{
                    this.showSuccess = true;
                    this.successMessage = 'Movement Saved';
                    Object.assign(this.currentMovement, response.data.data);
                    this.currentMovement = null;
                    this.editingMovement = false;
                    this.$refs.movementListReference.currentMovement = null;
                });

        },
        cancelEdit: function(movement){
            this.showSuccess = false;
            this.editingMovement = false;
            axios.get('api/user/movements/'+this.currentMovement.id)
                .then(response=>{
                    console.dir (this.currentMovement);
                    Object.assign(this.currentMovement, response.data.data); 
                    console.dir (this.currentMovement);
                    this.currentMovement = null;
                });
        },
        childMessage: function(message) {
            this.showSuccess = true;
            this.successMessage = message;
        },
        getMovements(){
             axios.get('api/user/movements', this.user)
                .then(response=>{
                    this.movements = response.data.data;

        this.movements.forEach(movement => {
          movement.date = new Date(movement.date).toLocaleString("en-GB", {
            timeZone: "UTC"
          });

          
          if (movement.type == "e") {
               movement.type = "Expense"
           }else{
               movement.type = "Income"
           }

            if(movement.type_payment == "c"){
                movement.type_payment = "Cash"
            }else if(movement.type_payment == "bt"){
                movement.type_payment = "Bank Transfer"
            }else{
                 movement.type_payment = "MB Payment"
            }

          if (movement.type == "Expense") {
            movement.value = 0 - movement.value;
            movement._cellVariants = "{ value: 'danger' }";
          }
          
           	this.categories.forEach(cat => {
			  if(cat.id==movement.category_id)movement.category_id=cat.name;
		  });
          movement.value = movement.value + "€";
            });
           })
        },
        getCategories(){
            axios.get("api/categories")
            .then(response => {
	            this.categories = response.data.data;
            })
        },
       
    }, 
    mounted() {
         this.getMovements()
         this.getCategories()
    },
    components:{
      'movement-list':MovementListComponent,
      'movement-edit': MovementEditingComponent,
    }
}

</script>

<style>

</style>