<template>
  <!-- sfa -->
  <component :is="$route.meta.layout || 'div'">
    <router-view  />
  </component>

</template>
<script setup>
import router from "../router";

</script>
