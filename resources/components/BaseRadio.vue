<template>
<label v-if="props.label">
<input
  type="radio"
  :label="props.label"
  :checked="props.modelValue === props.value"
  :value="props.value"
  v-bind="$attrs"
  @change="$emit('update:modelValue', $event.target.value)"
  >
  {{props.label}}</label>


</template>

<script setup>
import { required } from '../components_js/validation.js';

const props = defineProps({
    label:{
        type:String,
        define:'',
        required:true
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
