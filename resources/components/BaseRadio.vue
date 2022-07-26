<template>

<input
  type="radio"
  :label="props.label"
  :checked="props.modelValue === props.value"
  :value="props.value"
  v-bind="$attrs"
  @change="$emit('update:modelValue', $event.target.value)"
  >
  <label v-if="props.label">{{props.label}}</label>


</template>

<script setup>
const props = defineProps({
    label:{
        type:String,
        define:''
    },
    modelValue:{
        type:[String,Number],
        default:''
    },value:{
        type:[String,Number],
        required:true
    }


})
</script>

<style>

</style>
