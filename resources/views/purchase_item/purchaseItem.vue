<template>
  <div
    class="d-flex flex-cloumn card card-body mt-2 p-2 shadow"
    style="gap: 0.5rem"
  >
    <div
      class="d-flex justify-content-between flex-wrap fs-5"
      style="height: 1rem"
    >
      <p>Name: {{ purchaseDetails.supplier_name }}</p>
      <p>Transaction Date: {{ purchaseDetails.transaction_date }}</p>
    </div>

    <div
      class="d-flex justify-content-between flex-wrap fs-5 m-0"
      style="height: 1.6rem"
    >
      <p>Bill Date: {{ purchaseDetails.bill_date }}</p>

      <p>Lr No: {{ purchaseDetails.lr_no }}</p>
    </div>
    <div class="d-flex justify-content-center fs-4 fw-bold mt-1">
      Invoice No : {{ purchaseDetails.invoice_number }}
    </div>
  </div>
  <hr />

  <div class="mt-1 card card-body shadow p-2">
    <div class="d-flex flex-wrap purchase-item-box">
      <div style="margin: 0.5rem">
        <div
          class="d-flex justify-content-between flex-wrap"
          style="align-items: center"
        >
          <label class="m-0 p-0">Products </label>
          <a
            @click="showProduct"
            class="p-1 add-product-btn"
            href="/#/product/create"
            target="_blank"
          >
            + Add Product
          </a>
        </div>
        <VueMultiselect
          v-model="form.product"
          label="name"
          placeholder="Type Product Name"
          :loading="pLoading"
          :searchable="true"
          :options-limit="70"
          @search-change="asyncFind"
          :preserve-search="true"
          :close-on-select="true"
          :options="productDetails"
          :showPointer="true"
          :show-no-results="true"
        ></VueMultiselect>
      </div>
      <div>
        <label for="">Quantity</label>
        <div class="input-group m-2">
          <input
            id="Quantity"
            type="number"
            min="0"
            class="form-control"
            placeholder="0.00"
          />
          <span class="input-group-text">@example.com</span>
        </div>
      </div>

      <div class="m-2">
        <base-input label="Product"> </base-input>
      </div>
      <div class="m-2">
        <base-input label="Product"> </base-input>
      </div>
      <div class="m-2">
        <base-input label="Product"> </base-input>
      </div>
    </div>
    <div class="d-flex justify-content-center">
      <button
        class="btn btn-primary"
        style="margin-bottom: -1.3rem; margin-top: 1rem; font-weight: bold"
      >
        + Add Item
      </button>
    </div>
  </div>
  <hr style="margin-top: 1.3rem" />

  <!-- Model For Creating New Product -->
</template>

<script setup>
import {
  defineAsyncComponent,
  onMounted,
  reactive,
  ref,
} from "@vue/runtime-core";
import getPurchaseDataView from "../../composables_api/purchase_api/getPurchaseDataView";
import getProductNameId from "../../composables_api/product_api/getProductNameId";

/**
 * *VueMultiselect
 **/
import VueMultiselect from "vue-multiselect";
const props = defineProps(["id"]);
const { purchaseDetails, requestPurchaseData } = getPurchaseDataView();
const { productDetails, pLoading, apiResquestProduct } = getProductNameId();
onMounted(() => {
  requestPurchaseData(props.id);
});

const form = reactive({
  product: {},
});
const showAddProduct = ref(false);

const showProduct = () => {
  showAddProduct.value = true;
};

const asyncFind = (search) => {
  pLoading.value = true;
  if (!search) {
    pLoading.value = false;
    return null;
  }
  apiResquestProduct(search);
};
const addProduct = () => {
  console.log("adding product");
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style scoped>
.purchase-item-box > * {
  flex: 1 1 15%;
}
.add-product-btn:hover {
  cursor: pointer;
  background: black;
  color: white;
}
.add-product-btn {
  border: 1px solid black;
  border-radius: 5px;
  margin-bottom: 0.1rem;
  text-decoration: none;
  color: black;
  background: white;
}
</style>

