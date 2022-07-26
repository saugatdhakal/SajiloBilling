  <!-- If parent component want to set classes or style or type of the
  input then the v-bind=$attrs will receive the attrs -->
<template>
  <label :for="uuid">{{ props.label }}</label>
  <input
    :id="uuid"
    aria-de
    class="form-control"
    v-bind="$attrs"
    :placeholder="props.label"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    :aria-describedby="error ? `${uuid}-error` : null"
    :aria-invalid="error ? true : null"
  />
  <p
    v-if="props.error"
    :id="`${uuid}-error`"
    style="color: red"
    aria-live="assertive"
  >
    {{ props.error }}
  </p>
</template>

<script setup>
import UniqueID from "../components_js/UniqueID";
const uuid = UniqueID().getID();

const props = defineProps({
  label: {
    type: String,
    define: "",
  },
  modelValue: {
    type: [String, Number],
    define: "",
  },
  error: {
    type: String,
    default: "",
  },
});
</script>

<style>
label {
  padding-left: 7px;
  font-size: larger;
  margin-bottom: 3px;
}
</style>
