<template>
  <div class="row m-2">
    <div class="col-md-6 col-lg-6 col-sm-12">
      <form @submit.prevent="submitHandler">
        <base-card>
          <base-card-header label="Edit Purchase"></base-card-header>
          <base-input
            v-model="form.invoiceNumbers"
            is-disable
            class="mb-2"
            :require="true"
            label="Invoice Number"
          ></base-input>
          <span
            style="color: red; margin-bottom: 5px"
            v-for="error in v$.invoiceNumbers.$errors"
            :key="error"
          >
            {{ error.$message }}</span
          >
          <label for="">Supplier <span style="color: red">*</span></label>
          <VueMultiselect
            v-model="form.selectedSupplier"
            label="name"
            class="mb-2"
            placeholder="Type to get categories"
            :loading="supplierSelectLoding"
            :searchable="true"
            :options-limit="300"
            @search-change="asyncFind"
            :preserve-search="true"
            :close-on-select="true"
            :options="supplier"
            :showPointer="true"
            :show-no-results="true"
          >
            <!-- <span slot="noResult">No results were found.</span> -->
          </VueMultiselect>
          <span
            style="color: red; margin-bottom: 5px"
            v-for="error in v$.selectedSupplier.$errors"
            :key="error"
          >
            {{ error.$message }}</span
          >

          <label>Transaction Date <span style="color: red">*</span></label>
          <base-date-picker
            v-model="form.transactionDate"
            class="mb-2"
            calenderType="English"
            placeholder="Select a date"
          ></base-date-picker>
          <span
            style="color: red; margin-bottom: 5px"
            v-for="error in v$.transactionDate.$errors"
            :key="error"
          >
            {{ error.$message }}</span
          >
          <base-input
            :require="true"
            v-model="form.billDate"
            type="date"
            class="mb-2"
            label="Bill Date"
          ></base-input>
          <span
            style="color: red; margin-bottom: 5px"
            v-for="error in v$.billDate.$errors"
            :key="error"
          >
            {{ error.$message }}</span
          >
          <base-input
            :require="true"
            type="text"
            v-model="form.billNumber"
            class="mb-2"
            label="Bill Number"
          ></base-input>
          <base-input
            label="LR Number"
            class="mb-2"
            v-model="form.lrNo"
          ></base-input>

          <span
            style="color: red; margin-bottom: 5px"
            v-for="error in v$.billNumber.$errors"
            :key="error"
          >
            {{ error.$message }}</span
          >
          <base-text-area
            class="mb-2"
            v-model="form.remark"
            label="Remark"
          ></base-text-area>
          <base-button type="submit" class="mt-2 fs-5"
            ><span v-if="updateLoading"
              ><div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div></span
            >
            <span v-else>Update Purchase</span></base-button
          >
          <RouterLink
            class="btn btn-danger mt-2 fs-5 fw-bold"
            :to="{ name: 'purchase' }"
            >Cancle
          </RouterLink>
        </base-card>
      </form>
    </div>
  </div>
</template>

  <script setup>
import VueMultiselect from "vue-multiselect";
import { reactive } from "@vue/reactivity";
import useVuelidate from "@vuelidate/core";
import { required, maxLength } from "@vuelidate/validators";
import { inject, onMounted, watch } from "vue";
import router from "../../router";
import purchaseInvoice from "../../composables_api/purchase_api/purchaseInvoice";
import getSupplierNames from "../../composables_api/supplier_api/getSuppliersNames";
import purchaseCreate from "../../composables_api/purchase_api/purchaseCreate";
import getPurchaseDetails from "../../composables_api/purchase_api/getPurchaseDetails";
import getSupplierEdit from "../../composables_api/supplier_api/getSupplierEdit";
import purchaseUpdate from "../../composables_api/purchase_api/purchaseUpdate";


const props = defineProps(["id"]);
const toast = inject("toast");
const {
  purchase: purchaseUpdatesData,
  loading: updateLoading,
  updatePurchase,
} = purchaseUpdate();
const { supplier: supplierEdit, getEditData } = getSupplierEdit(); // Supplier Data -> Id, Name
const {
  supplier,
  getNames,
  loading: supplierSelectLoding,
} = getSupplierNames(); // Suppliers Datas (all supplier async search)
const { purchaseDetails, apiRequestPurchase } = getPurchaseDetails(); // Edit Purchase Details

const form = reactive({
  selectedSupplier: {},
  supplierId: "",
  transactionDate: "",
  billDate: "",
  billNumber: "",
  lrNo: "",
  remark: "",
  invoiceNumbers: "",
});

const rule = {
  selectedSupplier: { required },
  transactionDate: { required },
  billDate: { required },
  billNumber: { required },
  invoiceNumbers: { required },
  remark: { maxLength: maxLength(255) },
};

const v$ = useVuelidate(rule, form);

// Submitting the form
async function submitHandler() {
  //checking validation of the form
  const result = await v$.value.$validate();
  updateLoading.value = true;
  //if all validation is successful
  if (!result) {
    toast.error("Please Fill the fields and Enter a valid information!!");
    createLoading.value = false;
    return null;
  }
  form.supplierId = props.id;
  updatePurchase({ id: props.id, form: form });
}

//After Completing the Request Redierct to Purchase Dashboard
watch(purchaseUpdatesData, () => {
  router.push({ name: "purchase" });
});
//async search
const asyncFind = (searchValue) => {
  supplierSelectLoding.value = true;
  if (!searchValue) {
    supplierSelectLoding.value = false;
    return null;
  }
  getNames(searchValue); // Async search for supplier details
};

watch(purchaseDetails, () => {
  getEditData(purchaseDetails.value.supplier_id); // Response Supplier Name and id
  form.supplierId = purchaseDetails.value.supplier_id;
  form.transactionDate = purchaseDetails.value.transaction_date;
  form.billDate = purchaseDetails.value.bill_date;
  form.billNumber = purchaseDetails.value.bill_no;
  form.lrNo = purchaseDetails.value.lr_no;
  form.remark = purchaseDetails.value.remark;
  form.invoiceNumbers = purchaseDetails.value.invoice_number;
});

watch(supplierEdit, () => {
  form.selectedSupplier = [
    { id: supplierEdit.value.id, name: supplierEdit.value.name },
  ];
});

onMounted(() => {
  apiRequestPurchase(props.id);
});
</script>
  <style src="vue-multiselect/dist/vue-multiselect.css"></style>
  <style>
</style>

