<template>
  <div class="d-flex flex-row justify-content-between mt-2">
    <h1 style="font-weight: 800; margin-top: ">Product Dashboard</h1>

    <div class="mt-2">
      <RouterLink
        class="btn btn-danger me-3 p-2"
        :to="{ name: 'productSoftDelete' }"
        ><i class="fa-solid fa-trash-can-list"></i> Trash Product</RouterLink
      >
      <RouterLink class="btn btn-dark me-3 p-2" :to="{ name: 'productCreate' }">
        <i class="fa-regular fa-clothes-hanger p-1 fa-sm"></i> Add
        Product</RouterLink
      >
    </div>
  </div>
  <ProductDatable></ProductDatable>
</template>

<script setup>
import ProductDatable from "./productDatable.vue";
</script>

<style>
</style>
