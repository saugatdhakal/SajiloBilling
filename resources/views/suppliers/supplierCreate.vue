<template>
  <div class="row m-2">
    <div class="col-md-6 col-lg-6 col-sm-12">
      <form @submit.prevent="submit">
        <base-card>
          <h3 class="mb-3 text-center border border-2 rounded p-2">
            Create Supplier
          </h3>
          <base-input
            class="mb-2"
            v-model="form.name"
            label="Name"
            :require="true"
          ></base-input>
          <span class="errorMsg" v-for="error in v$.name.$errors" :key="error">
            {{ error.$property.toUpperCase() }} {{ error.$message }}</span
          >
          <base-input
            :require="true"
            class="mb-2"
            v-model="form.address"
            label="Address"
          ></base-input>
          <span
            class="errorMsg"
            v-for="error in v$.address.$errors"
            :key="error"
          >
            {{ error.$property.toUpperCase() }} {{ error.$message }}</span
          >
          <base-input
            :require="true"
            type="number"
            min="0"
            class="mb-2"
            v-model="form.contact_number"
            label="Contact Number"
          ></base-input>
          <span
            class="errorMsg"
            v-for="error in v$.contact_number.$errors"
            :key="error"
          >
            {{ error.$property.toUpperCase() }} {{ error.$message }}</span
          >
          <base-input
            class="mb-2"
            v-model="form.contact_person"
            label="Contact Person"
          ></base-input>
          <span
            class="errorMsg"
            v-for="error in v$.contact_person.$errors"
            :key="error"
          >
            {{ error.$property.toUpperCase() }} {{ error.$message }}</span
          >
          <base-input
            class="mb-2"
            v-model="form.email"
            :require="true"
            label="Email"
          ></base-input>
          <span class="errorMsg" v-for="error in v$.email.$errors" :key="error">
            {{ error.$property.toUpperCase() }} {{ error.$message }}</span
          >
          <label for="">Remarks</label>
          <textarea
            class="form-control"
            placeholder="About the supplier"
            v-model="form.remark"
            id=""
            cols="25"
            rows="5"
          ></textarea>
          <span
            class="errorMsg mb-2"
            v-for="error in v$.remark.$errors"
            :key="error"
          >
            {{ error.$property.toUpperCase() }} {{ error.$message }}</span
          >
          <base-button type="submit" class="mt-3 fw-bold fs-5">
            <span v-if="!loading"
              ><div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div></span
            >
            <span v-else>Create Supplier</span>
          </base-button>
          <RouterLink class="btn btn-danger mt-2 fs-5 fw-bold" :to="{name:'supplier'}"
            >Cancle
          </RouterLink>
        </base-card>
      </form>
    </div>
  </div>
</template>

<script setup>

import registerSupplier from "../../composables_api/supplier_api/createSupplier";
import { reactive } from "@vue/reactivity";
import useVuelidate from "@vuelidate/core";
import {
  required,
  alpha,
  email,
  maxLength,
  minLength,
} from "@vuelidate/validators";
import { inject, watch } from "vue";
import router from "../../router";

const { supplier:suppierData, loading, createSupplier } = registerSupplier();
const form = reactive({
  name: "",
  address: "",
  contact_number: "",
  contact_person: "",
  email: "",
  remark: "",
});

const rules = {
  name: { required },
  address: { required },
  contact_number: {
    required,
    maxLength: maxLength(10),
    minLength: minLength(10),
  },
  contact_person: { alpha },
  email: { email, required },
  remark: { maxLength: maxLength(255) },
};

const toast = inject("toast");
const v$ = useVuelidate(rules, form);

watch(suppierData,()=>{
    router.push({ name: "supplier"});
})

async function submit() {
  const result = await v$.value.$validate();
  if (!result) {
    toast.error("Please Fill the fields and Enter a valid information!!");
    return null;
  }
  createSupplier(form);
}
</script>

<style>
</style>
