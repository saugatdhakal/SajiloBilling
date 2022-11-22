<template>
  <div class="row p-3">
    <div class="col-md-12 col-lg-6 col-sm-12">
      <base-card>
      <base-card-header label="Create Product"></base-card-header>
        <!-- product create resuable components -->
        <product-create-temp> </product-create-temp>
      </base-card>
    </div>
  </div>
</template>

<script setup>
import productCreateTemp from "./productCreateTemp.vue";
</script>

<style>
</style>
