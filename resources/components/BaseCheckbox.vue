<template>
<div>
<input type="checkbox"
    :checked="modelValue"
    @change="$emit('update:modelValue',$event.target.checked)"
  />
  <label v-if="props.label">{{props.label}}</label>
</div>

</template>

<script setup>
const props = defineProps({
  label: {
    type: String,
    define: "",
  },
  modelValue: {
    type: Boolean,
    define: false,
  },
});
</script>

<style>

</style>
