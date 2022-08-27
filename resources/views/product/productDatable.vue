<template>

  <div
    class="
      mt-4
      d-flex
      flex-row
      justify-content-between
      mx-2
      my-1
      justify-content-center
    "
  >
    <div class="d-flex flex-row justify-content-center">
      <label for="pageNo" class="pe-2 align-middle fw-bold fs-4"
        >Per Page</label
      >
      <BaseSelect
        v-model="paginate"
        style="width: 5rem; text-align: center; height: 35px"
        id="pageNo"
        name="pageSelect"
        :options="['10', '20', '30', '40', '50', '-1']"
      ></BaseSelect>

      <div class="mx-4 d-flex flex-row justify-content-center">
        <span class="fw-bold fs-4 pe-2">Filter By Type</span>
        <BaseSelect
          placeholder="Select Type"
          v-model="salesType"
          style="width: 10rem; text-align: center; height: 35px"
          id="pageNo"
          name="pageSelect"
            optionEmpty="All"
          :options="['SALES', 'SERVICE']"
        ></BaseSelect>
      </div>
    </div>

    <div class="d-flex flex-row justify-content-center">
      <label class="fw-bold fs-4 mx-3">
        <i class="fa-solid fa-magnifying-glass"></i>
      </label>
      <input
        v-model.lazy="search"
        type="search"
        class="form-control mb-2"
        placeholder="Search Here"
      />
    </div>
  </div>
  <table
    class="table table-responsive mt-3"
    style="border-radius: 4px; width: 100%"
    :style="
      appStates.themeDark
        ? 'background-color: #1f2a34;color:white;'
        : 'background-color: #eaebec;'
    "
  >
    <thead>
      <tr>
        <th>SN</th>
        <th>Name</th>
        <th>Category</th>
        <th>Units</th>
        <th>Type</th>
        <th width="10%">Action</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(product, i) in products.data" :key="i">
        <td>{{ ++i }}</td>
        <td>{{ product.name }}</td>
        <td>{{ product.category }}</td>
        <td>{{ product.unit }}</td>
        <td>{{ product.item_type }}</td>
        <td></td>
      </tr>
    </tbody>
  </table>
  <div class="d-flex flex-row">
    <span class="fw-bold fs-4 mx-2">Pages -</span>
    <Pagination
      style="page"
      :data="products"
      @pagination-change-page="pageData"
    />
  </div>
</template>

<script>
import LaravelVuePagination from "laravel-vue-pagination";
import { onMounted, ref, watch, inject } from "@vue/runtime-core";
import { appState } from "../../states/appState";
import dataTable from "../../composables_api/product_api/dataTable";
import BaseSelect from "../../components/BaseSelect.vue";

export default {
  components: {
    Pagination: LaravelVuePagination,
    BaseSelect,
  },
  setup() {
    const appStates = appState();
    const { products, productLoading, productError, getProducts } = dataTable();

    const search = ref("");
    const pages = ref(1);
    const salesType = ref("");
    const paginate = ref(10); // 10 20 30 All

    const pageData = (page = 1) => {
      pages.value = page;
      getProducts({
        page: pages.value,
        paginate: paginate.value,
        search: search.value,
        selectedType: salesType.value,
      });
    };
    onMounted(() => {
      getProducts({
        page: pages.value,
        paginate: paginate.value,
        search: search.value,
        selectedType: salesType.value,
      });
    });

    watch([search, pages, paginate, salesType], () => {
      getProducts({
        page: pages.value,
        paginate: paginate.value,
        search: search.value,
        selectedType: salesType.value,
      });
    });

    return {
      appStates,
      products,
      search,
      salesType,
      pages,
      paginate,
      pageData
    };
  },
};
</script>

<style>
</style>
