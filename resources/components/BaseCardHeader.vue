<template>
  <h3
    v-bind="$attrs"
    class="boarder-style"
    :style="appStates.themeDark ? 'border: 2px solid white;' : 'color:black;'"
  >
    {{ props.label }}
  </h3>
</template>

<script setup>
import { appState } from "../states/appState";
const appStates = appState();

const props = defineProps({
  label: {
    default: "",
    type: String,
  },
});
</script>

<style scoped>
.boarder-style {
  text-align: center;
  border: 2px solid black;
  color:white;
  border-radius: 5px;
  padding: 15px;
}
</style>
