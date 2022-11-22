<template>
  <i
    @click="creatCategory"
    class="fa-solid fa-circle-plus fa-2xl"
    style="cursor: pointer"
    data-bs-toggle="modal"
    data-bs-target="#addNewCategory"
  ></i>

  <base-modal
    modelHeader="New Category"
    modelId="addNewCategory"
    :footerButton="false"
  >
    <template v-slot:modalBody>
      <base-input label="Name" v-model="form.name" />
      <span class="errorMsg" v-for="error in v$.name.$errors" :key="error">
        {{ error.$property.toUpperCase() }} {{ error.$message }}</span
      >
      <div class="d-flex justify-content-center mt-3">
        <base-button @click="handleSubmit" class="mt-2">Create Category</base-button>
      </div>
    </template>
  </base-modal>
</template>

<script setup>
import { reactive } from "@vue/reactivity";
import useVuelidate from "@vuelidate/core";
import { required, minLength } from "@vuelidate/validators";
import { inject, watch } from "vue";
import registerCategory from "../../composables_api/category_api/createCategory";

const emit = defineEmits(["categoryCreated"]);
const form = reactive({
  name: "",
});

const { category, loading, createCategory } = registerCategory();
const rule = {
  name: { required, minLength: minLength(3) },
};

const v$ = useVuelidate(rule, form);

watch(category, () => {
  form.name = "";
  toast.success("Category created successfully");
  emit("categoryCreated", true);
});

const toast = inject("toast");

async function handleSubmit() {
  console.log("click on category");
  const result = await v$.value.$validate();
  if (!result) {
    toast.error("Please fill the fields of category!!");
    return null;
  }
  createCategory(form);
}
</script>

<style>
</style>
