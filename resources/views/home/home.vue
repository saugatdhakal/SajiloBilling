<template>
  <p>home</p>
  <button @click="showToast">Show toast</button>
</template>

<script>
import { inject } from "vue";
export default {
    
  setup(props, context) {
    const toast = inject("toast");

    function showToast() {
      toast.error("it works !");
    }
    return { showToast };
  },
};
</script>

<style>
</style>
