<template>
        <div>
            <div class="jumbotron"> <h1>{{ title }}</h1></div>

            <movement-list  :movements="movements" ></movement-list>
        </div>
</template>

<script>
import MovementListComponent from './movementList'

export default{
     data:function(){
        return{
            title: 'List Movements',
            movements: [],
            categories: [],
            pagination: []
            
        }
    },
    methods:{
        getMovements(){
             axios.get('api/user/movements')
                .then(response=>{
                    this.movements = response.data.data;
               })
        }, getCategories(){
            axios.get('api/categories')
            .then(response=>{this.categories = response.data.data; });

        }

      }, 
    mounted() {
        this.getMovements();
        this.getCategories();
    },
    components:{
        'movement-list':MovementListComponent,
    }
}

</script>

<style>

</style>