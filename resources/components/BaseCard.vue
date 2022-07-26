<template>
  <div
    class="card card-body"
    v-bind="$attrs"
    :class="appStates.themeDark? 'dark':'light'"
    :style="appStates.themeDark ? 'color:white' : 'color:black'"
  >
  <slot></slot>
  </div>
</template>

<script setup>
import { appState } from "../states/appState";
const appStates = appState();

</script>

<style scoped>
.light {
  background-color: #eaebec;
  color: black;
  transition: background 0.7s ease-in-out;
}
.dark {
  background-color: #1f2a34;
  color: white;
  transition: background 0.7s ease-in-out;
}
</style>


