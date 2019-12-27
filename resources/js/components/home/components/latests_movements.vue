<template>
<div>
    <b-table id='movements-table' :small="true" :fixed="true" :striped="true" 
    :fields="fields" :items="tabledata" :per-page="perPage" :current-page="currentPage"></b-table>
    
    <!-- <b-pagination pills align="center" v-model="currentPage" :total-rows="rows"  -->
    <!-- :per-page="perPage" size="sm" aria-controls="movements-table"></b-pagination> -->
</div>
</template>

<script>
    export default {
        props: ['tabledata'],
        data: function () {
            return {
                fields: [{
                        key: 'date',
                        sortable: true
                    },
                    {
                        key: 'value',
                        sortable: true
                    }
                ],
                perPage: 10,
                currentPage: 1,
            }
        },
        methods: {},
        computed: {
            rows() {
                return this.tabledata.length
            }
        }
    }
</script>

<style scoped>

</style>

<!-- 

<template>
  <div>
    <b-form-group label="Table Options" label-cols-lg="2">
      <b-form-checkbox v-model="striped" inline>Striped</b-form-checkbox>
      <b-form-checkbox v-model="bordered" inline>Bordered</b-form-checkbox>
      <b-form-checkbox v-model="borderless" inline>Borderless</b-form-checkbox>
      <b-form-checkbox v-model="outlined" inline>Outlined</b-form-checkbox>
      <b-form-checkbox v-model="small" inline>Small</b-form-checkbox>
      <b-form-checkbox v-model="hover" inline>Hover</b-form-checkbox>
      <b-form-checkbox v-model="dark" inline>Dark</b-form-checkbox>
      <b-form-checkbox v-model="fixed" inline>Fixed</b-form-checkbox>
      <b-form-checkbox v-model="footClone" inline>Foot Clone</b-form-checkbox>
      <b-form-checkbox v-model="noCollapse" inline>No border collapse</b-form-checkbox>
    </b-form-group>
    <b-form-group label="Head Variant" label-cols-lg="2">
      <b-form-radio-group v-model="headVariant" class="mt-lg-2">
        <b-form-radio :value="null" inline>None</b-form-radio>
        <b-form-radio value="light" inline>Light</b-form-radio>
        <b-form-radio value="dark" inline>Dark</b-form-radio>
      </b-form-radio-group>
    </b-form-group>
    <b-form-group label="Table Variant" label-for="table-style-variant" label-cols-lg="2">
      <b-form-select
        v-model="tableVariant"
        :options="tableVariants"
        id="table-style-variant"
      >
        <template v-slot:first>
          <option value="">-- None --</option>
        </template>
      </b-form-select>
    </b-form-group>

    <b-table
      :striped="striped"
      :bordered="bordered"
      :borderless="borderless"
      :outlined="outlined"
      :small="small"
      :hover="hover"
      :dark="dark"
      :fixed="fixed"
      :foot-clone="footClone"
      :no-border-collapse="noCollapse"
      :items="items"
      :fields="fields"
      :head-variant="headVariant"
      :table-variant="tableVariant"
    ></b-table>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        fields: ['first_name', 'last_name', 'age'],
        items: [
          { age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
          { age: 21, first_name: 'Larsen', last_name: 'Shaw' },
          { age: 89, first_name: 'Geneva', last_name: 'Wilson' }
        ],
        tableVariants: [
          'primary',
          'secondary',
          'info',
          'danger',
          'warning',
          'success',
          'light',
          'dark'
        ],
        striped: false,
        bordered: false,
        bor
