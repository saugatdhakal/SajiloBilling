<template>
  <div v-bind="$attrs" v-if="props.visible">
    <form @submit="handleSubmit">
      <BaseCard>
        <h3>Create Category</h3>
        <BaseInput label="Name" v-model="form.name" />
        <span class="errorMsg" v-for="error in v$.name.$errors" :key="error">
          {{ error.$property.toUpperCase() }} {{ error.$message }}</span
        >
        <BaseButton class="mt-2">Create Category</BaseButton>
      </BaseCard>
    </form>
  </div>
</template>

<script setup>
import BaseCard from "../../components/BaseCard.vue";
import BaseButton from "../../components/BaseButton.vue";
import BaseInput from "../../components/BaseInput.vue";
import { reactive } from "@vue/reactivity";
import useVuelidate from "@vuelidate/core";
import { required, minLength } from "@vuelidate/validators";
import { inject, watch } from "vue";
import registerCategory from "../../composables_api/category_api/createCategory";

const props = defineProps({
  visible: Boolean,
  default: false,
});
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
