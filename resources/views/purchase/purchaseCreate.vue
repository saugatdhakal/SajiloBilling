<template>
  <div class="row m-2">
    <div class="col-md-6 col-lg-6 col-sm-12">
      <form @submit.prevent="submitHandler">
        <BaseCard>
          <BaseCardHeader label="Create Purchase"></BaseCardHeader>
          <BaseInput
            v-model="form.invoiceNumbers"
            is-disable
            class="mb-2"
            label="Invoice Number"
          ></BaseInput>
          <span
            style="color: red; margin-bottom: 5px"
            v-for="error in v$.invoiceNumbers.$errors"
            :key="error"
          >
            {{ error.$message }}</span
          >
          <label for="">Supplier</label>
          <VueMultiselect
            v-model="form.selectedSupplier"
            label="name"
            class="mb-2"
            placeholder="Type to get categories"
            :loading="loading"
            :searchable="true"
            :options-limit="300"
            @search-change="asyncFind"
            :preserve-search="true"
            :close-on-select="true"
            :options="supplier"
            :showPointer="true"
            :show-no-results="true"
          ></VueMultiselect>
          <span
            style="color: red; margin-bottom: 5px"
            v-for="error in v$.selectedSupplier.$errors"
            :key="error"
          >
            {{ error.$message }}</span
          >

          <label>Transaction Date</label>
          <BaseDatePicker
            v-model="form.transactionDate"
            class="mb-2"
            calenderType="English"
            placeholder="Select a date"
          ></BaseDatePicker>
          <span
            style="color: red; margin-bottom: 5px"
            v-for="error in v$.transactionDate.$errors"
            :key="error"
          >
            {{ error.$message }}</span
          >
          <BaseInput
            v-model="form.billDate"
            type="date"
            class="mb-2"
            label="Bill Date"
          ></BaseInput>
          <span
            style="color: red; margin-bottom: 5px"
            v-for="error in v$.billDate.$errors"
            :key="error"
          >
            {{ error.$message }}</span
          >
          <BaseInput
            type="text"
            v-model="form.billNumber"
            class="mb-2"
            label="Bill Number"
          ></BaseInput>
          <BaseInput
            label="LR Number"
            class="mb-2"
            v-model="form.lrNo"
          ></BaseInput>

          <span
            style="color: red; margin-bottom: 5px"
            v-for="error in v$.billNumber.$errors"
            :key="error"
          >
            {{ error.$message }}</span
          >
          <BaseTextArea
            class="mb-2"
            v-model="form.remark"
            label="Remark"
          ></BaseTextArea>
          <BaseButton type="submit" class="mt-2 fs-5"
            ><span v-if="createLoading"
              ><div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div></span
            >
            <span v-else>Create Purchase</span></BaseButton
          >
          <RouterLink
            class="btn btn-danger mt-2 fs-5 fw-bold"
            :to="{ name: 'purchase' }"
            >Cancle
          </RouterLink>
        </BaseCard>
      </form>
    </div>
  </div>
</template>

<script setup>
import purchaseInvoice from "../../composables_api/purchase_api/purchaseInvoice";
import BaseCard from "../../components/BaseCard.vue";
import VueMultiselect from "vue-multiselect";
import { reactive, ref } from "@vue/reactivity";
import useVuelidate from "@vuelidate/core";
import { required, maxLength } from "@vuelidate/validators";
import { inject, onMounted, watch } from "vue";
import router from "../../router";
import BaseCardHeader from "../../components/BaseCardHeader.vue";
import BaseInput from "../../components/BaseInput.vue";
import BaseDatePicker from "../../components/BaseDatePicker.vue";
import BaseTextArea from "../../components/BaseTextArea.vue";
import getSupplierNames from "../../composables_api/supplier_api/getSuppliersNames";
import BaseButton from "../../components/BaseButton.vue";
import purchaseCreate from "../../composables_api/purchase_api/purchaseCreate";

const toast = inject("toast");
const { createPurchase, purchase, createLoading } = purchaseCreate();
const { supplier, getNames, loading } = getSupplierNames();
const { getInvoiceNumber, invoiceNumber } = purchaseInvoice();

const form = reactive({
  selectedSupplier: {},
  supplierId: "",
  transactionDate: "",
  billDate: "",
  billNumber: "",
  lrNo: "",
  remark: "",
  invoiceNumbers: invoiceNumber,
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

async function submitHandler() {
  const result = await v$.value.$validate();
  createLoading.value = true;
  if (!result) {
    toast.error("Please Fill the fields and Enter a valid information!!");
    createLoading.value = false;
    return null;
  }
  form.supplierId = form.selectedSupplier.id;
  console.log(form);
  createPurchase(form);
}

function asyncFind(searchValue) {
  loading.value = true;
  if (!searchValue) {
    loading.value = false;
    return null;
  }
  getNames(searchValue);
}
watch(purchase, () => {
  router.push({ name: "purchase" });
});

onMounted(() => {
  getInvoiceNumber();
});
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<style>
</style>

