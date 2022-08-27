<template>
  <label v-if="props.label"
    >{{ props.label
    }}<span style="color: red" v-if="props.require"> *</span></label
  >
  <select
    :value="props.modelValue"
    v-bind="{
      ...$attrs,
      onChange: ($event) => {
        {
          $emit('update:modelValue', $event.target.value);
        }
      },
    }"
    class="form-select"
  >
    <option v-if="props.placeholder" value="" disabled selected hidden>
      {{ props.placeholder }}
    </option>
    <option v-if="props.optionEmpty" value="">{{ props.optionEmpty }}</option>
    <option
      v-for="option in options"
      :value="option"
      :key="option"
      :selected="option === modelValue"
    >
      {{ option }}
    </option>
  </select>
</template>

<script setup>
const props = defineProps({
  label: {
    type: String,
    define: "",
  },
  modelValue: {
    type: [String, Number],
    define: "",
  },
  options: {
    type: Array,
    required: true,
  },
  require: {
    type: Boolean,
    default: false,
  },
  placeholder: {
    type: String,
    define: "",
  },
  optionEmpty: {
    type: String,
    define: "",
  },
});
</script>

<style>
</style>
