<template>
  <div class="row p-3">
    <div class="col-md-6 col-lg-6 col-sm-12">
      <form @submit.prevent="submit">
        <base-card>
          <h3 class="mb-3 text-center border border-2 rounded p-2">
            Create Account
          </h3>
          <div class="d-flex flex-row align-items-*-center">
            <span style="margin-right: 20px; font-size: 20px"
              >Account Type :
            </span>

            <base-radio-group
              class="mb-3"
              v-model="formData.accountType"
              name="accountTypes"
              :options="accountTypeOption"
            />
          </div>
          <span
            class="errorMsg"
            v-for="error in v$.accountType.$errors"
            :key="error"
          >
            {{ error.$property.toUpperCase() }} {{ error.$message }}</span
          >
          <base-input
            class="mb-3"
            v-model="formData.name"
            label="Name"
          ></base-input>
          <span class="errorMsg" v-for="error in v$.name.$errors" :key="error">
            {{ error.$property.toUpperCase() }} {{ error.$message }}</span
          >
          <div v-if="formData.accountType == 'retailer'">
            <base-input
              class="mb-3"
              v-model="formData.shopName"
              label="Shop Name"
            ></base-input>
            <span
              class="errorMsg"
              v-for="error in v$.shopName.$errors"
              :key="error"
            >
              {{ error.$property.toUpperCase() }} {{ error.$message }}</span
            >
          </div>

          <base-input
            type="email"
            class="mb-3"
            v-model="formData.email"
            label="Email"
          ></base-input>
          <span class="errorMsg" v-for="error in v$.email.$errors" :key="error">
            {{ error.$property.toUpperCase() }} {{ error.$message }}</span
          >
          <base-input
            class="mb-3"
            v-model="formData.address"
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
            class="mb-3"
            type="number"
            v-model="formData.contactNumber"
            min="0"
            label="Contact Number"
          ></base-input>
          <span
            class="errorMsg"
            v-for="error in v$.contactNumber.$errors"
            :key="error"
          >
            {{ error.$property.toUpperCase() }} {{ error.$message }}</span
          >
          <div v-show="formData.accountType == 'retailer'">
            <div class="d-flex flex-row align-items-*-center mt-1 mb-1">
              <base-input
                type="number"
                min="0"
                class="mb-3 mx-2"
                v-model="formData.vat"
                label="VAT"
              ></base-input>
              <span
                class="errorMsg"
                v-for="error in v$.vat.$errors"
                :key="error"
              >
                {{ error.$property.toUpperCase() }} {{ error.$message }}</span
              >
              <base-input
                type="number"
                class="mb-3 mx-2"
                min="0"
                v-model="formData.pan"
                label="PAN"
              ></base-input>
              <span
                class="errorMsg"
                v-for="error in v$.pan.$errors"
                :key="error"
              >
                {{ error.$property.toUpperCase() }} {{ error.$message }}</span
              >
            </div>
          </div>

          <base-input
            class="mb-3"
            min="0"
            type="number"
            v-model="formData.dueLimit"
            label="Due limit"
          ></base-input>
          <span
            class="errorMsg"
            v-for="error in v$.dueLimit.$errors"
            :key="error"
          >
            {{ error.$property.toUpperCase() }} {{ error.$message }}</span
          >

          <base-button class="mt-2" type="submit">Create</base-button>
          <RouterLink class="btn btn-danger mt-2" to="/account"
            >Cancle
          </RouterLink>
        </base-card>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive } from "@vue/reactivity";
import useVuelidate from "@vuelidate/core";
import {
  required,
  requiredIf,
  email,
  minLength,
  maxLength,
} from "@vuelidate/validators";
import registerAccount from "../../composables_api/account_api/createAccount";
import router from "../../router";
import { watch, inject } from "@vue/runtime-core";
const accountTypeOption = [
  { label: "Retailer", value: "retailer" },
  { label: "Individual", value: "individual" },
];
const { account, accountError, createAccount } = registerAccount();
const toast = inject("toast");
const formData = reactive({
  email: "",
  name: "",
  accountType: "retailer",
  address: "",
  shopName: "",
  contactNumber: "",
  vat: "",
  pan: "",
  dueLimit: "",
});

const rules = {
  email: { required, email },
  name: { required, minLength: minLength(5) },
  accountType: { required },
  address: { required },
  shopName: {
    required: requiredIf(() =>
      formData.accountType == "retailer" ? true : false
    ),
  },
  contactNumber: {
    required,
    minLength: minLength(10),
    maxLength: maxLength(10),
  },
  vat: {
    required: requiredIf(() =>
      formData.accountType == "retailer" && !formData.pan ? true : false
    ),
    minLength: minLength(8),
    maxLength: maxLength(8),
  },
  pan: {
    required: requiredIf(() =>
      formData.accountType == "retailer" && !formData.vat ? true : false
    ),
    minLength: minLength(8),
    maxLength: maxLength(8),
  },
  dueLimit: { required },
};

const v$ = useVuelidate(rules, formData);

const submit = async () => {
  const result = await v$.value.$validate();
  if (!result) {
    console.log("error");
    return null;
  }
  console.log(formData);
  createAccount(formData);
};
watch(accountError, () => {
  toast.error(
    "Accrount Creation Error!! Phone Number must be should not be repeat"
  );
});
watch(account, () => {
  router.push({ name: "account", params: { createFlag: true } });
});
</script>

