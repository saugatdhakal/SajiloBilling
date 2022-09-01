<template>
  <div class="row m-2">
    <div class="col-md-6 col-lg-6 col-sm-12">
      <BaseCard>
        <BaseCardHeader label="Create Purchase"></BaseCardHeader>
        <BaseInput
          v-model="form.invoiceNumbers"
          is-disable
          label="Invoice Number"
        ></BaseInput>
        <!-- <BaseInput
        type="date"
          v-model="form.invoiceNumbers"

          label="Invoice Number"
        ></BaseInput> -->
      </BaseCard>
    </div>
  </div>
</template>

<script setup>
import purchaseInvoice from "../../composables_api/purchase_api/purchaseInvoice";
import BaseCard from "../../components/BaseCard.vue";
import BaseButton from "../../components/BaseButton.vue";
import { reactive } from "@vue/reactivity";
import useVuelidate from "@vuelidate/core";
import {
  required,
  alpha,
  email,
  maxLength,
  minLength,
} from "@vuelidate/validators";
import { inject, onMounted, watch } from "vue";
import router from "../../router";
import BaseCardHeader from "../../components/BaseCardHeader.vue";
import BaseInput from "../../components/BaseInput.vue";

const { getInvoiceNumber, invoiceNumber } = purchaseInvoice();
const form = reactive({
  invoiceNumbers: invoiceNumber,
});

onMounted(() => {
  getInvoiceNumber();
});
</script>

<style>
</style>
