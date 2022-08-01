<template>
  <div
    v-bind="$attrs"
    class="spinner-border"
    :class="appStates.themeDark ? 'text-white' : 'text-dark'"
    role="status"
  >
    <span class="visually-hidden">Creating...</span>
  </div>
</template>

<script setup>
import { appState } from "../states/appState";
const appStates = appState();
</script>

<style>
</style>
