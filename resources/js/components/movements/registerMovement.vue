<template>
  <div class="registerBody">
    <b-form>
      <b-alert v-if="response != ''" show variant="danger">{{response}}</b-alert>

      <b-dropdown id="dd_typeOfExpense" text="Type of expense" class="m-md-2">
        <b-dropdown-item @click="mov_register.movement_type = 'external'">External Payment</b-dropdown-item>
        <b-dropdown-item @click="mov_register.movement_type = 'transfer'">Account transfer</b-dropdown-item>
        <!-- <b-dropdown-item>Third Action</b-dropdown-item>
			<b-dropdown-divider></b-dropdown-divider>
			<b-dropdown-item active>Active action</b-dropdown-item>
        <b-dropdown-item disabled>Disabled action</b-dropdown-item>-->
      </b-dropdown>

      <b-dropdown id="dd_category" text="Category" class="m-md-2">
        <b-dropdown-item
          v-for="category in categories"
          :key="category.id"
          :value="category.name"
          @click="mov_register.category = category.name"
        >{{ category.name }}</b-dropdown-item>
      </b-dropdown>

      <b-form-group label="Amount:" style="width: 49%;">
        <b-form-input
          id="input-amount"
          type="number"
          v-model="mov_register.value"
          placeholder="Enter Amount"
        ></b-form-input>
      </b-form-group>

      <b-form-group label="Description:" style="width: 49%;">
        <b-form-input
          id="input-description"
          type="text"
          v-model="mov_register.description"
          placeholder="Enter Description of expense"
        ></b-form-input>
      </b-form-group>

      <div class="form-group">
        <a class="btn btn-primary" v-on:click.prevent="saveExpense()">Save</a>
        <a class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</a>
      </div>
    </b-form>
  </div>
</template>

<script>
export default {
  props: [],
  data: function() {
    return {
      mov_register: {
        value: "",
        category: "",
        movement_type: "",
        description:""
      },
      response: "",
      categories: []
    };
  },
  methods: {
    getCategories() {
      axios.get("api/categories").then(response => {
        console.log("response: ", response.data.data);
        this.categories = response.data.data;
        console.log("responsethis.categories: ", this.categories);
      });
    },
    saveExpense() {
      console.log('movement like ', this.mov_register);
    }
  },
  computed: {},
  mounted() {
    this.getCategories();
  }
};
</script>

<style scoped>
</style>