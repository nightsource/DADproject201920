<template>
  <div class="registerBody">
    <b-form>
      <b-alert v-if="response != ''" show variant="danger">{{response}}</b-alert>

      <b-form-group label="Type of Expense:">
        <b-form-select v-model="mov_register.movement_type" class="mb-3">
      <!-- This slot appears above the options from 'options' prop -->
      <template v-slot:first>
        <option :value="null" disabled>-- Please select an expense --</option>
      </template>
      <!-- These options will appear after the ones from 'options' prop -->
      <option value="external">External Payment</option>
      <option value="transfer">Account Transfer</option>
      </b-form-select>
      </b-form-group>

      <b-form-group label="Category:">
      <b-form-select v-model="mov_register.category" class="mb-3">
      <!-- This slot appears above the options from 'options' prop -->
      <template v-slot:first>
        <option :value="null" disabled>-- Please select a category --</option>
      </template>
      <!-- These options will appear after the ones from 'options' prop -->
      <option v-for="category in categories"
          :key="category.id"
          :value="category.name"
          >{{ category.name }}</option>
    </b-form-select>
      </b-form-group>

      <b-form-group label="Amount:">
        <b-form-input
          id="input-amount"
          type="number"
          v-mask="'#####.## €'"
          v-model="mov_register.value"
          placeholder="Enter Amount"
        ></b-form-input>
      </b-form-group>
      <b-form-invalid-feedback v-if="mov_register.value !== null" :state="val_amount">
        Your value must be between 0.01 and 500.000
      </b-form-invalid-feedback>

      <b-form-group label="Description:">
        <b-form-input
          id="input-description"
          type="text"
          v-model="mov_register.description"
          placeholder="Enter Description of expense"
        ></b-form-input>
      </b-form-group>

      <b-form-group v-if="mov_register.movement_type === 'external'" label="Type of payment:">
        <b-form-select v-model="mov_register.payment_type" class="mb-3">
      <template v-slot:first>
        <option :value="null" disabled>-- Please select a payment type --</option>
      </template>
      <option value="bankTransfer">Bank Transfer</option>
      <option value="mbpayment">MB Payment</option>
      </b-form-select>
      </b-form-group>

      <b-form-group v-if="mov_register.payment_type === 'bankTransfer'" label="IBAN :">
        <b-form-input
          id="input-iban"
          type="text"
          v-model="mov_register.iban"
          placeholder="Enter IBAN"
        ></b-form-input>
      </b-form-group>
      <b-form-invalid-feedback v-if="mov_register.iban !== null" :state="val_iban">
        IBAN should be TWO capital letters and 23 numbers
      </b-form-invalid-feedback>

      <b-form-group v-if="mov_register.payment_type === 'mbpayment'" label="MB Entity :">
        <b-form-input
          id="input-mbEntity"
          type="text"
          v-model="mov_register.mbEntity"
          placeholder="Enter MB Entity"
        ></b-form-input>
      </b-form-group>
      <b-form-invalid-feedback v-if="mov_register.mbEntity !== null" :state="val_mb_entity">
        MB Reference consists in 5 numbers
      </b-form-invalid-feedback>

      <b-form-group v-if="mov_register.payment_type === 'mbpayment'" label="MB Reference :">
        <b-form-input
          id="input-mbReference"
          type="text"
          v-model="mov_register.mbReference"
          placeholder="Enter MB Reference"
        ></b-form-input>
      </b-form-group>
      <b-form-invalid-feedback v-if="mov_register.mbReference !== null" :state="val_mb_reference">
        MB Reference consists in 5 numbers
      </b-form-invalid-feedback>

      <div class="form-group">
        <a class="btn btn-primary" v-on:click.prevent="saveExpense()">Save</a>
        <a class="btn btn-light" v-on:click.prevent="cancelExpense()">Cancel</a>
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
        value: null,
        category: null,
        movement_type: null,
        description:"",
        payment_type: null,
        iban:null,
        mbEntity:null,
        mbReference:null
      },
      response: "",
      categories: [],
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
      console.log('movement to save ', JSON.parse(JSON.stringify(this.mov_register)));
    },
    cancelExpense() {
      this.$router.push('home')
    }
  },
  computed: {
    val_amount() {
            if (this.mov_register.value===undefined)
                return null;

            return this.mov_register.value > 0.01 && this.mov_register.value < 5000
        },
    val_iban() {
      //[A-Z]{2}[0-9]{23}
      let reg = /^[A-Z]{2}[0-9]{23}$/;
      return reg.test(this.mov_register.iban);
    },
    val_mb_entity() {
      let reg = /^[0-9]{5}$/;
      return reg.test(this.mov_register.mbEntity);
    },
    val_mb_reference() {
      let reg = /^[0-9]{9}$/;
      return reg.test(this.mov_register.mbReference);
    }
  },
  mounted() {
    this.getCategories();
  }
};
</script>

<style scoped>
</style>