<template>
	<div class="registerBody">
		<b-form>
			<b-alert v-if="showFailure" show variant="danger">{{failMessage}}</b-alert>
			<b-alert v-if="showSuccess" show variant="success">{{successMessage}}</b-alert>

			<b-form-group label="Type of Expense:">
				<b-form-select v-model="mov_register.type" class="mb-3">
			<!-- This slot appears above the options from 'options' prop -->
			<template v-slot:first>
				<option :value="null" disabled>-- Please select an expense --</option>
			</template>
			<!-- These options will appear after the ones from 'options' prop -->
			<option value="e">External Payment</option>
			<option value="i">Account Transfer</option>
			</b-form-select>
			</b-form-group>

			<b-form-group label="Category:">
			<b-form-select v-model="mov_register.category_id" class="mb-3">
			<!-- This slot appears above the options from 'options' prop -->
			<template v-slot:first>
				<option :value="null" disabled>-- Please select a category --</option>
			</template>
			<!-- These options will appear after the ones from 'options' prop -->
			<option v-for="category in categories"
					:key="category.id"
					:value="category.id"
					>{{ category.name }}</option>
		</b-form-select>
			</b-form-group>

			<b-form-group label="Amount:">
				<CurrencyInput
					v-model="mov_register.value"/>
			</b-form-group>
			<b-form-invalid-feedback v-if="mov_register.value !== null" :state="val_amount">
				Your value must be between 0.01 and 5000.00 €
			</b-form-invalid-feedback>

			<b-form-group label="Description:">
				<b-form-input
					id="input-description"
					type="text"
					v-model="mov_register.description"
					placeholder="Enter Description of expense"
				></b-form-input>
			</b-form-group>

			<b-form-group v-if="mov_register.type === 'e'" label="Type of payment:">
				<b-form-select v-model="mov_register.type_payment" class="mb-3">
			<template v-slot:first>
				<option :value="null" disabled>-- Please select a payment type --</option>
			</template>
			<option value="bt">Bank Transfer</option>
			<option value="mb">MB Payment</option>
			</b-form-select>
			</b-form-group>

			<b-form-group v-if="mov_register.type_payment === 'bt'" label="IBAN :">
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

			<b-form-group v-if="mov_register.type_payment === 'mb'" label="MB Entity :">
				<b-form-input
					id="input-mbEntity"
					type="text"
					v-model="mov_register.mb_entity_code"
					placeholder="Enter MB Entity"
				></b-form-input>
			</b-form-group>
			<b-form-invalid-feedback v-if="mov_register.mb_entity_code !== null" :state="val_mb_entity">
				MB Reference consists in 5 numbers
			</b-form-invalid-feedback>

			<b-form-group v-if="mov_register.type_payment === 'mb'" label="MB Reference :">
				<b-form-input
					id="input-mbReference"
					type="text"
					v-model="mov_register.mb_payment_reference"
					placeholder="Enter MB Reference"
				></b-form-input>
			</b-form-group>
			<b-form-invalid-feedback v-if="mov_register.mb_payment_reference !== null" :state="val_mb_reference">
				MB Reference consists in 9 numbers
			</b-form-invalid-feedback>

			<b-form-group v-if="mov_register.type === 'i'" label="Destinator e-mail:">
				<b-form-input
					id="input-email"
					type="text"
					v-model="mov_register.email"
					placeholder="Enter destinator email"
				></b-form-input>
			</b-form-group>
			<b-form-invalid-feedback v-if="mov_register.email !== null" :state="val_email">
				It has to be a valid e-mail and exist in our database.
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
			/*wallet_id
				type
				transfer
				transfer_movement_id
				transfer_wallet_id
				type_payment
				category_id
				iban
				mb_entity_code
				mb_payment_reference
				description
				source_description
				date
				start_balance
				end_balance
				value */
			mov_register: {
				wallet_id:null,
				value: null,
				category_id: null,
				type: null,	//e-external i-internal
				description:"",
				type_payment: null,	//mb bt c
				iban:null,
				mb_entity_code:null,
				mb_payment_reference:null,
				email:null,
				start_balance:null,
				end_balance:null,
				transfer_wallet_id:null
			},
			user: {
        name: "",
        email: "",
        password: "",
        access_token: ""
      },
			response: "",
			showSuccess:false,
			successMessage:'',
			showFailure:false,
			failMessage:'',
			categories: [],
		};
	},
	methods: {
		getUser() {
      axios.get("api/user").then(response => {
        console.log("user logged: ", response.data);
        this.user = response.data;
      });
    },
		getWallet(){
			axios.get("api/user/wallet").then(response => {
				this.mov_register.wallet_id = response.data.data.id;
				this.mov_register.start_balance = parseFloat(response.data.data.balance);
			});
		},
		getCategories() {
			axios.get("api/categories").then(response => {
				this.categories = response.data.data;
			});
		},
		saveExpense() {
			if (this.canRegister()) {
				this.mov_register.end_balance = this.mov_register.start_balance - this.mov_register.value;
				this.response='';
				if(this.mov_register.type=='i'){
					//internal transfer
					//getDestinationWallet
						axios.get("api/user/wallet/"+ this.mov_register.email)
							.then(response => {
							if(response.data==''){
								this.response='This e-mail does not exist in our database.';
								return;
							}else{
								this.response='';
								this.mov_register.transfer_wallet_id = response.data.id;
								// console.log('movement to save :', JSON.parse(JSON.stringify(this.mov_register)));
								axios.put("api/movements/registerInternal", this.mov_register).then(response => {
          				console.log("response to save ", response);
          				this.showSuccess = true;
         					this.successMessage = "Movement saved successfully!";
        				});
								//create websocket tell destination about income value
							}
						});
						
				} else if (this.mov_register.type=='e'){
					//external movement
					axios.put("api/movements/registerExternal", this.mov_register).then(response => {
          				console.log("response to save ", response);
          				this.showSuccess = true;
         					this.successMessage = "Movement saved successfully!";
        				});
				}
			}else{
				this.response = 'Please correct invalid fields.';
			}
		},
		cancelExpense() {
			this.$router.push('home')
		},
		canRegister() {
						return (this.val_amount && this.val_email);
		}
	},
	computed: {
		val_amount() {
						if (!this.mov_register.value)
								return false;

						return this.mov_register.value > 0.01 && this.mov_register.value < 5000
				},
		val_iban() {
			//[A-Z]{2}[0-9]{23}
			let reg = /^[A-Z]{2}[0-9]{23}$/;
			return reg.test(this.mov_register.iban);
		},
		val_mb_entity() {
			let reg = /^[0-9]{5}$/;
			return reg.test(this.mov_register.mb_entity_code);
		},
		val_mb_reference() {
			let reg = /^[0-9]{9}$/;
			return reg.test(this.mov_register.mb_payment_reference);
		},
		val_email() {
						if (this.mov_register.email == null)
								return true;
						
						let reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
						return reg.test(this.mov_register.email);
				}
	},
	mounted() {
		this.getUser();
		this.getCategories();
		this.getWallet();
	}
};
</script>

<style scoped>

</style>