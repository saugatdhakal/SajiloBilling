<template>
  <div>
    <label v-if="props.mainLabel">{{ props.mainLabel }}</label>
    <component
      v-for="option in props.options"
      :key="option.value"
      :is="props.vertical ? 'div' : 'span'"
      :class="{ horizontal: !vertical }"
    >
      <BaseRadio
        :label="option.label"
        :value="option.value"
        :name="props.name"
        :modelValue="props.modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
      />
    </component>
  </div>
</template>

<script setup>
import BaseRadio from "../components/BaseRadio.vue";
const props = defineProps({
  name: {
    type: String,
    required: true,
  },
  options: {
    type: Array,
    required: true,
  },
  modelValue: {
    type: [String, Number],
    required: true,
  },
  vertical: {
    type: Boolean,
    default: false,
  },
  mainLabel: {
    type: String,
    required: false,
  },
});
</script>

<style scoped>
.horizontal {
  margin-right: 20px;
}
</style>
