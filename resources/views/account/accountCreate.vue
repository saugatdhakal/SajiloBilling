<template>
  <div class="row p-3">
    <div class="col-md-6 col-lg-6 col-sm-12">
      <form @submit.prevent="submit">
        <BaseCard>
          <h3 class="mb-3">Create Account</h3>
          <div class="d-flex flex-row align-items-*-center">
            <span style="margin-right: 20px; font-size: 20px"
              >Account Type :
            </span>

            <BaseRadioGroup
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
          <BaseInput
            class="mb-3"
            v-model="formData.name"
            label="Name"
          ></BaseInput>
          <span class="errorMsg" v-for="error in v$.name.$errors" :key="error">
            {{ error.$property.toUpperCase() }} {{ error.$message }}</span
          >
          <div v-if="formData.accountType == 'retailer'">
            <BaseInput
              class="mb-3"
              v-model="formData.shopName"
              label="Shop Name"
            ></BaseInput>
            <span
              class="errorMsg"
              v-for="error in v$.shopName.$errors"
              :key="error"
            >
              {{ error.$property.toUpperCase() }} {{ error.$message }}</span
            >
          </div>

          <BaseInput
            type="email"
            class="mb-3"
            v-model="formData.email"
            label="Email"
          ></BaseInput>
          <span class="errorMsg" v-for="error in v$.email.$errors" :key="error">
            {{ error.$property.toUpperCase() }} {{ error.$message }}</span
          >
          <BaseInput
            class="mb-3"
            v-model="formData.address"
            label="Address"
          ></BaseInput>
          <span
            class="errorMsg"
            v-for="error in v$.address.$errors"
            :key="error"
          >
            {{ error.$property.toUpperCase() }} {{ error.$message }}</span
          >
          <BaseInput
            class="mb-3"
            type="number"
            v-model="formData.contactNumber"
            min="0"
            oninput="this.value = Math.abs(this.value)"
            label="Contact Number"
          ></BaseInput>
          <span
            class="errorMsg"
            v-for="error in v$.contactNumber.$errors"
            :key="error"
          >
            {{ error.$property.toUpperCase() }} {{ error.$message }}</span
          >
          <div v-show="formData.accountType == 'retailer'">
            <div class="d-flex flex-row align-items-*-center mt-1 mb-1">
              <BaseInput
                type="number"
                min="0"
                oninput="this.value = Math.abs(this.value)"
                class="mb-3 mx-2"
                v-model="formData.vat"
                label="VAT"
              ></BaseInput>
              <span
                class="errorMsg"
                v-for="error in v$.vat.$errors"
                :key="error"
              >
                {{ error.$property.toUpperCase() }} {{ error.$message }}</span
              >
              <BaseInput
                type="number"
                class="mb-3 mx-2"
                min="0"
                oninput="this.value = Math.abs(this.value)"
                v-model="formData.pan"
                label="PAN"
              ></BaseInput>
              <span
                class="errorMsg"
                v-for="error in v$.pan.$errors"
                :key="error"
              >
                {{ error.$property.toUpperCase() }} {{ error.$message }}</span
              >
            </div>
          </div>

          <BaseInput
            class="mb-3"
            min="0"
            type="number"
            oninput="this.value = Math.abs(this.value)"
            v-model="formData.dueLimit"
            label="Due limit"
          ></BaseInput>
          <span
            class="errorMsg"
            v-for="error in v$.dueLimit.$errors"
            :key="error"
          >
            {{ error.$property.toUpperCase() }} {{ error.$message }}</span
          >

          <BaseButton class="mt-2" type="submit">Create</BaseButton>
        </BaseCard>
      </form>
    </div>
  </div>
</template>

<script>
import BaseCard from "../../components/BaseCard.vue";
import BaseButton from "../../components/BaseButton.vue";
import BaseInput from "../../components/BaseInput.vue";
import BaseRadioGroup from "../../components/BaseRadioGroup.vue";
import { reactive } from "@vue/reactivity";
import useVuelidate from "@vuelidate/core";
import { required, requiredIf, email, minLength,maxLength } from "@vuelidate/validators";
import registerAccount from "../../composables_api/account_api/createAccount";
import router from "../../router";
import { watch, inject } from "@vue/runtime-core";

export default {
  components: { BaseCard, BaseInput, BaseRadioGroup, BaseButton },
  setup() {
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
      contactNumber: { required, minLength: minLength(10) ,maxLength: maxLength(10) },
      vat: {
        minLength: minLength(8),
        maxLength: maxLength(8),
        required: requiredIf(() =>
          formData.accountType == "retailer" ? true : false
        ),
      },
      pan: {
        minLength: minLength(8),
        maxLength: maxLength(8),
        required: requiredIf(() =>
          formData.accountType == "retailer" ? true : false
        ),
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
    return {
      accountTypeOption,
      formData,
      v$,
      submit,
    };
  },
};
</script>

<style>
.errorMsg {
  color: red;
  margin-bottom: 5px;
}
</style>
