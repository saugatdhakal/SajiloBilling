<template>
  <div class="row p-3">
    <div class="col-md-6 col-lg-6 col-sm-12">
      <form @submit.prevent="submit">
        <BaseCard>
          <h3 class="mb-3 text-center border border-2 rounded p-2">
            Create Product
          </h3>

          <BaseRadioGroup
            class="mb-3"
            mainLabel="Sales Type :"
            :options="itemType"
          ></BaseRadioGroup>
          <BaseInput class="mb-3" label="Product Code"></BaseInput>
          <!-- <span class="errorMsg" v-for="error in v$.name.$errors" :key="error">
            {{ error.$property.toUpperCase() }} {{ error.$message }}</span
          > -->
          <BaseInput class="mb-3" label="Name"></BaseInput>
          <BaseSelect class="mb-3" label="Unit"></BaseSelect>
          <BaseSelect class="mb-3" label="Category"></BaseSelect>

          <BaseButton class="mt-2" type="submit">Create</BaseButton>
          <RouterLink class="btn btn-danger mt-2" :to="{ name: 'product' }"
            >Cancle
          </RouterLink>
        </BaseCard>
      </form>
    </div>
  </div>
</template>

<script setup>
import BaseCard from "../../components/BaseCard.vue";
import BaseButton from "../../components/BaseButton.vue";
import BaseInput from "../../components/BaseInput.vue";
import BaseSelect from "../../components/BaseSelect.vue";
import { reactive } from "@vue/reactivity";
import useVuelidate from "@vuelidate/core";
import {
  required,
  requiredIf,
  email,
  minLength,
  maxLength,
} from "@vuelidate/validators";
import BaseRadioGroup from "../../components/BaseRadioGroup.vue";

const itemType = [
  { label: "SALES", value: "SALES" },
  { label: "SERVICE", value: "SERVICE" },
];
</script>

<style>
</style>
