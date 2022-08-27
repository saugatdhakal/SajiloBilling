<template>
  <label style="margin: 10px 0px;" :for="`${uuid}-textareaLabel`">{{ props.label }}</label>
  <textarea
    class="form-control"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    v-bind="$attrs"
    :id="`${uuid}-textarea`"
    :cols="props.column"
    :rows="props.row"
  ></textarea>
</template>

<script setup>
import UniqueID from "../components_js/UniqueID";
const uuid = UniqueID().getID();

const props = defineProps({
  label: {
    type: String,
    define: "",
  },
  column: {
    type: [Number, String],
    default: "30",
  },
  row: {
    type: [Number, String],
    default: "5",
  },
  modelValue:{
    type: [String],
    define: "",
  }
});
</script>
