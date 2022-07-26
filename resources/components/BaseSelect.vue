<template>
  <label v-if="props.label">{{ props.label }}</label>
  <select
  :value="props.modelValue"
   v-bind="{
    ...$attrs,
    onChange:($event) =>{
        {$emit('update:modelValue',$event.target.value)}
    }
    }"
   class="form-select">
    <option
      v-for="option in options"
      :value="option"
      :key="option"
      :selected="option === modelValue"
    >{{option}}</option>
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
  options:{
    type:Array,
    required: true,
  }
});
</script>

<style>
</style>
