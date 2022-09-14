<template>
<div class="d-flex flex-row justify-content-between mt-2">
    <h1 style="font-weight: 800; margin-top: " v-once>Purchase Dashboard</h1>

    <div class="mt-2">
      <RouterLink
      v-once
        class="btn btn-danger me-3 p-2"
        :to="{ name: 'purchaseSoftDelete' }"
        ><i class="fa-solid fa-trash-can-list"></i> Trash Supplier</RouterLink
      >
      <RouterLink class="btn btn-dark me-3 p-2" :to="{ name: 'purchaseCreate' }">
        <i class="fa-regular fa-user-plus"></i> Add Purchase</RouterLink
      >
    </div>
  </div>
<purchase-datatable></purchase-datatable>

</template>

<script setup>
import purchaseDatatable from './purchaseDatatable.vue';

</script>

<style>
</style>
