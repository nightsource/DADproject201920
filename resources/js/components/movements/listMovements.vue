<template>
  <div class="overflow-auto">
	<b-pagination
	  v-model="currentPage"
	  :total-rows="rows"
	  :per-page="perPage"
	  aria-controls="my-table"
	></b-pagination>

	<b-table
	  striped
	  hover
	  :items="movements"
	  :fields="fields"
	  id="movement"
	  :per-page="perPage"
	  :current-page="currentPage"
	>
	  <template
		v-slot:cell(actions)="row"
		v-slot:key="movement.id"
		:class="{active: currentMovement === movement}"
	  >
		<!-- <b-button variant="success" v-on:click="editUser(row.item)">Edit</b-button>
		<b-button variant="danger" v-on:click="deleteUser(row.item)">Delete</b-button> -->
	  </template>
	</b-table>

	<!-- <user-edit v-if="currentUser!=undefined" :user="currentUser"></user-edit> -->
  </div>
</template>

<script>
export default {
	data: function () {
		return {
			movements:[],
			user: {
				name: "",
				email: "",
				password: "",
				access_token: ""
			},
			perPage: 10,
			currentMovement:undefined,
			currentPage: 1,
			fields:[{ key: 'category_id', sortable: false},
					{key: 'value', sortable: false },
					{key: 'type', sortable: true }, 
					{key: 'date', sortable: false }, 
					{key: 'description', sortable: false }, 
					{key: 'actions', sortable: false } ],
		};
	},
	methods: {
		async getAllMovements() {
			axios.get('api/user/movements',this.user)
			.then(response => {
			// console.log("all movements: ", response.data.data);
			this.movements=response.data.data;
			// console.log(JSON.parse(JSON.stringify(this.movements)));
        	// this.user = response.data;
      		});
		},
		getUser() {
      		axios.get("api/user").then(response => {
        	console.log("user logged: ", response.data);
        	this.user = response.data;
      		});
    	},
	},  
	computed: {
		rows() {                
			return this.movements.length
		}
	},
	mounted() {
		this.getUser();
		this.getAllMovements();
	},
	components: {
	}
}
</script>

<style scoped>
</style>