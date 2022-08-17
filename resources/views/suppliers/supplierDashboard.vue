<template>
   <div class="d-flex flex-row justify-content-between mt-2">
    <h1 style="font-weight: 800; margin-top: ">Supplier Dashboard</h1>

    <div class="mt-2">
      <RouterLink
        class="btn btn-danger me-3 p-2"
        :to="{ name: 'supplierSoftDelete' }"
        ><i class="fa-solid fa-trash-can-list"></i> Trash Supplier</RouterLink
      >
      <RouterLink class="btn btn-dark me-3 p-2" :to="{ name: 'supplierCreate' }">
        <i class="fa-regular fa-user-plus"></i> Add Supplier</RouterLink
      >
    </div>
  </div>
  <SupplierTable />
</template>

<script setup>
import SupplierTable from "./supplierDatatable.vue";





</script>

<style>
</style>
