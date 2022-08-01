<template>
  <button
    class="btn"
    v-bind="$attrs"
    :class="appStates.themeDark ? 'btnLight' : 'btndark'"
  >
    <slot></slot>
  </button>
</template>

<script setup>
import { appState } from "../states/appState";
const appStates = appState();
</script>

<style scoped>
.btnLight {
  background-color: #eaebec;
  color: black;
}
.btndark {
  background-color: #1f2a34;
  color: white;
}
</style>
