<template>
  <form @submit.prevent="handleSubmit">
    <base-radio-group
      name="sf"
      class="mb-3"
      mainLabel="Sales Type :"
      v-model="form.saleType"
      :options="itemType"
    ></base-radio-group>
    <span
      style="color: red; margin-bottom: 5px"
      v-for="error in v$.saleType.$errors"
      :key="error"
    >
      {{ error.$property.toUpperCase() }} {{ error.$message }}</span
    >

    <base-input
      isDisable
      v-model="form.productCode"
      class="mb-3"
      disabled
      :require="true"
      label="Product Code"
    ></base-input>
    <span
      style="color: red; margin-bottom: 5px"
      v-for="error in v$.productCode.$errors"
      :key="error"
    >
      {{ error.$message }}</span
    >

    <base-input
      class="mb-3"
      autofocus
      :require="true"
      v-model="form.name"
      label="Name"
    ></base-input>
    <span
      style="color: red; margin-bottom: 5px"
      v-for="error in v$.name.$errors"
      :key="error"
    >
      {{ error.$message }}</span
    >

    <div
      class="d-flex justify-content-between flex-wrap"
      style="align-items: center"
    >
      <label class="typo__label"
        >Category <span style="color: red">*</span></label
      >
      <div class="ml-auto p-2 bd-highlight mb-1" title="Add Category">
        <categoryCreate v-if="showCategoryButton"/>
      </div>
    </div>
    <div v-if="category" class="categoryDiv">
      <VueMultiselect
        v-model="form.category"
        label="name"
        placeholder="Type to get categories"
        :loading="loading"
        :searchable="true"
        :options-limit="300"
        @search-change="asyncFind"
        :preserve-search="true"
        class="categorySelect"
        :close-on-select="true"
        :options="category"
        :showPointer="true"
        :show-no-results="true"
      ></VueMultiselect>
    </div>

    <span
      style="color: red; margin-bottom: 5px"
      v-for="error in v$.category.$errors"
      :key="error"
    >
      {{ error.$message }}</span
    >
    <base-select
      v-model="form.unit"
      placeholder="select unit"
      label="Unit"
      :require="true"
      :options="['pcs', 'meter', 'bundle']"
    ></base-select>
    <span
      style="color: red; margin-bottom: 5px"
      v-for="error in v$.unit.$errors"
      :key="error"
    >
      {{ error.$message }}</span
    >

    <base-text-area
      v-model="form.remark"
      row="4"
      class="mb-3"
      label="Remark"
    ></base-text-area>
    <span
      style="color: red; margin-bottom: 5px"
      v-for="error in v$.remark.$errors"
      :key="error"
    >
      {{ error.$message }}</span
    >
    <div class="d-flex flex-column">
      <base-button class="mt-2" type="submit">
        <span v-if="!productLoading"
          ><div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div></span
        >
        <span v-else >Create Product</span></base-button
      >
      <RouterLink
        v-if="props.showCancelButton"
        class="btn btn-danger mt-2"
        :to="{ name: 'product' }"
        >Cancle
      </RouterLink>
    </div>
  </form>
</template>

<script setup>
import { reactive, ref } from "@vue/reactivity";
import useVuelidate from "@vuelidate/core";
import VueMultiselect from "vue-multiselect";
import categoryCreate from "../category/categoryCreate.vue";
import registerProduct from "../../composables_api/product_api/productCreate";
import { required } from "@vuelidate/validators";
import CategoriesList from "../../composables_api/category_api/getCategories";
import { onMounted, watch, inject } from "@vue/runtime-core";
import getProductCode from "../../composables_api/product_api/getProductCode";
import router from "../../router";


const itemType = [
  { label: "SALES", value: "SALES" },
  { label: "SERVICE", value: "SERVICE" },
];
/**
 * TODO:Props
 * *ShowCancelButton : Show or hide cancel Button
 **/
const props = defineProps({
  showCancelButton: {
    type: Boolean,
    default: true,
  },
  showCategoryButton: {
    type: Boolean,
    default: true,
  }
});
/**
 * TODO:Emit
 * *submitPressed : For Closing the model
 **/
const emits = defineEmits(['submitPressed'])

/**
 * TODO:API
 * *CategoriesList : Category list for async searching
 * *registerProduct : Create a new product in DB
 * *getProductsCode : Get New product code for product
 **/
const { category, loading, getAscynSearch } = CategoriesList();
const { product, loading: productLoading, createProduct } = registerProduct();
const { productCode, pCodeLoding, generateCode } = getProductCode();

onMounted(() => {
  generateCode();
});

const toast = inject("toast");

const form = reactive({
  saleType: "SALES",
  category: [],
  name: "",
  unit: "pcs",
  remark: "",
  productCode: "",
  categoryId: "",
});

const rules = {
  saleType: { required },
  category: { required },
  name: { required },
  productCode: { required },
  unit: { required },
  remark: { required },
};

// Async search for categories
function asyncFind(searchValue) {
  loading.value = true;
  if (!searchValue) {
    loading.value = false;
    return null;
  }
  getAscynSearch(searchValue);
}


/**
 * TODO:Create New Category
 **/
const cetegoryBool = ref(false);
function creatCategory() {
  cetegoryBool.value = !cetegoryBool.value;
}
function createdCategory() {
  cetegoryBool.value = false;
}

/**
 * TODO:Submit the product details by validating the product details
 **/

const v$ = useVuelidate(rules, form);
async function handleSubmit() {
    console.log("click on the product")
  const result = await v$.value.$validate();
  if (!result) {
    toast.error("Please Fill the fields and Enter a valid information!!");
    return null;
  }
  form.categoryId = form.category.id;
  createProduct(form);
}

/**
 * TODO:featch the prodcut to reactive form
 **/
watch(productCode, () => {
  form.productCode = productCode;
});

/**
 * TODO:Emit After the product is created successfully
 **/
watch(product, () => {
    emits('submitPressed');
})

</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<style scoped>
@media (min-width: 600px) {
  .categoryCreate {
    margin-top: 50px;
  }
  .multiselect__tags {
    display: inline-block !important;
    width: 500px;
  }
}

@media (min-width: 900px) {
  .categoryCreate {
    margin-top: 200px;
  }
}
</style>
