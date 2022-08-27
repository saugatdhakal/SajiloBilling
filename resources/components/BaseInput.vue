  <!-- If parent component want to set classes or style or type of the
  input then the v-bind=$attrs will receive the attrs -->
<template>
  <label :for="uuid">{{ props.label }} <span class="requireStar" v-if="props.require">*</span></label>
  <input
    :id="uuid"

    class="form-control form-floating"
    v-bind="$attrs"
    :placeholder="props.label"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    :aria-describedby="error ? `${uuid}-error` : null"
    :aria-invalid="error ? true : null"
    :disabled="props.isDisable"
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
  require:{
    type:Boolean,
    default:false
  },
  isDisable:{
    type:Boolean,
    default:false
  }
});
</script>

<style>
label {
  padding-left: 7px;
  font-size: larger;
  margin-bottom: 3px;
}
.requireStar{
    color:red
}

</style>
