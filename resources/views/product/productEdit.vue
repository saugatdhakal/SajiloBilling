<template>
  <div class="row p-3">
    <div class="col-md-12 col-lg-6 col-sm-12">
      <form @submit.prevent="handleSubmit">
        <base-card>
          <base-card-header label="Edit Product"></base-card-header>
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

          <label class="typo__label"
            >Category <span style="color: red">*</span></label
          >
          <div class="d-flex mt-1">
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
            <div class="ml-auto p-2 bd-highlight mb-3" title="Add Category">
              <i
                @click="creatCategory"
                class="fa-solid fa-circle-plus fa-2xl"
                style="cursor: pointer"
              ></i>
            </div>
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

          <base-button class="mt-2" type="submit">
            <span v-if="!updateLoading"
              ><div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div></span
            >
            <span v-else>Update Supplier</span></base-button
          >
          <RouterLink class="btn btn-danger mt-2" :to="{ name: 'product' }"
            >Cancle
          </RouterLink>
        </base-card>
      </form>
    </div>
    <div v-if="cetegoryBool" class="col-md-4 col-lg-4 col-sm-12 categoryCreate">
      <category-create
        :visible="cetegoryBool"
        @categoryCreated="createdCategory"
      />
    </div>
  </div>
</template>

<script setup>
import categoryCreate from "../category/categoryCreate.vue";
import { reactive, ref } from "@vue/reactivity";
import useVuelidate from "@vuelidate/core";
import VueMultiselect from "vue-multiselect";
import registerProductUpdate from "../../composables_api/product_api/productUpdate";
import { required } from "@vuelidate/validators";
import CategoriesList from "../../composables_api/category_api/getCategories";
import { onMounted, watch, inject } from "@vue/runtime-core";
import getProductDetails from "../../composables_api/product_api/productDeatils";
import router from "../../router";

const itemType = [
  { label: "SALES", value: "SALES" },
  { label: "SERVICE", value: "SERVICE" },
];

const { category, loading, getAscynSearch } = CategoriesList();
const { product, productError,loading:updateLoading, updateProduct } = registerProductUpdate();
const { productDetails, pLoading, apiResquestProduct } = getProductDetails();

const props = defineProps(["id"]);

onMounted(() => {
  apiResquestProduct(props.id);
});

watch(productDetails, () => {
    form.saleType= productDetails.value.item_type;
    form.name = productDetails.value.name;
    form.unit = productDetails.value.unit;
    form.remark = productDetails.value.remark;
    form.productCode = productDetails.value.product_code;
    form.category=[{id:productDetails.value.id,name:productDetails.value.name}]
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

function asyncFind(searchValue) {
  loading.value = true;
  if (!searchValue) {
    loading.value = false;
    return null;
  }
  getAscynSearch(searchValue);
}

const cetegoryBool = ref(false);

function creatCategory() {
  cetegoryBool.value = !cetegoryBool.value;
}
function createdCategory() {
  cetegoryBool.value = false;
}

const v$ = useVuelidate(rules, form);
async function handleSubmit() {
  const result = await v$.value.$validate();
  if (!result) {
    toast.error("Please Fill the fields and Enter a valid information!!");
    return null;
  }
  form.categoryId = props.id;
  updateProduct({id:props.id,form:form});
}

watch(product, () => {
  router.push({ name: "product" });
});
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<style>
@media (min-width: 600px) {
  .categoryCreate {
    margin-top: 50px;
  }
  .categoryDiv .multiselect {
    width: 78vw;
  }
}

@media (min-width: 900px) {
  .categoryCreate {
    margin-top: 200px;
  }
  .categoryDiv .multiselect {
    width: 38vw;
  }
}
</style>
