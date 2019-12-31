<template>
  <div class="overflow-auto">

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
        <b-button variant="danger" v-on:click="deleteUser(row.item)">Delete</b-button>-->
      </template>
    </b-table>
	<b-pagination
      v-model="currentPage"
      :total-rows="rows"
      :per-page="perPage"
      aria-controls="my-table"
    ></b-pagination>
    <!-- <user-edit v-if="currentUser!=undefined" :user="currentUser"></user-edit> -->
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      movements: [],
      user: {
        name: "",
        email: "",
        password: "",
        access_token: ""
      },
      perPage: 10,
      currentMovement: undefined,
      currentPage: 1,
      categories: [],
      fields: [
        { key: "description", sortable: false },
        { key: "category", sortable: false },
        { key: "date", sortable: true },
        { key: "value", sortable: true },
        { key: "actions", sortable: false }
      ]
    };
  },
  methods: {
    async getAllMovements() {
      axios.get("api/user/movements", this.user).then(response => {
        this.movements = response.data.data;

        this.movements.forEach(movement => {
          movement.date = new Date(movement.date).toLocaleString("en-GB", {
            timeZone: "UTC"
          });

          if (movement.type == "e") {
            movement.value = 0 - movement.value;
            movement._cellVariants = "{ value: 'danger' }";
		  }
		  this.categories.forEach(cat => {
			  if(cat.id==movement.category_id)movement.category=cat.name;
		  });
          movement.value = movement.value + "€";
        });
      });
    },
    async getCategories() {
      axios.get("api/categories").then(response => {
		this.categories = response.data.data;
      });
    },
    async getUser() {
      axios.get("api/user").then(response => {
        this.user = response.data;
      });
    }
  },
  computed: {
    rows() {
      return this.movements.length;
    }
  },
  mounted() {
    this.getCategories();
    this.getUser();
    this.getAllMovements();
  },
  components: {}
};
</script>

<style scoped>
</style>