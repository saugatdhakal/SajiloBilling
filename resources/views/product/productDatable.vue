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
        <th width="5%">SN</th>
        <th width="15%">Type</th>
        <th>Name</th>
        <th>Category</th>
        <th>Units</th>
        <th width="10%">Action</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(product, i) in products.data" :key="i">
        <td>{{ ++i }}</td>
        <td>
          <span
            class="badge rounded-pill bg-info text-dark"
            style="height: 30px; font-size: 17px"
            :class="product.item_type == 'SALES' ? 'bg-info' : 'bg-warning'"
            >{{ product.item_type == "SALES" ? "SALES" : "SERVICE" }}</span
          >
        </td>
        <td>{{ product.name }}</td>
        <td>{{ product.category }}</td>
        <td>{{ product.unit }}</td>
        <td>
          <productTableButton
            :softDeleteButton="props.softDelete"
            :id="product.id"
            @forceDeleteHandler="forceDeleteHandler"
            @softDelete="deleteHandler"
            @restoreHandler="restoreHandler"
          >
          </productTableButton>
        </td>
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
import softDelete from "../../composables_api/product_api/softdelete";
import productTableButton from "./productTableButton.vue";
import restoreTrashProduct from "../../composables_api/product_api/restoreTrashProduct";
import forceDeleteProduct from "../../composables_api/product_api/forceDeleteProduct";

export default {
  components: {
    Pagination: LaravelVuePagination,
    BaseSelect,
    productTableButton,
  },
  props: {
    softDelete: {
      type: Boolean,
      default: false,
      required: false,
    },
  },
  setup(props) {

    const appStates = appState();
    const { products, getProducts } = dataTable();
    const { deleteProduct } = softDelete();
    const { restoredProduct, restore } = restoreTrashProduct();
    const { deletedProduct, deletePro } = forceDeleteProduct();

    const search = ref("");
    const pages = ref(1);
    const salesType = ref("");
    const paginate = ref(10); // 10 20 30 All

    const swal = inject("$swal");

    const deleteHandler = (id) => {
      swal({
        title: "Are you sure?",
        text: "Your Data will be temporarily deleted from the table",
        showCancelButton: true,
        confirmButtonColor: "#3084d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        buttonsStyling: true,
      }).then(function (isConfirm) {
        if (isConfirm.value === true) {
          deleteProduct(id);
          refreshTable();
        }
      });
    };
    const pageData = (page = 1) => {
      pages.value = page;
      refreshTable();
    };
    onMounted(() => {
      refreshTable();
    });

    watch(
      [search, pages, paginate, salesType, restoredProduct, deletedProduct],
      () => {
        refreshTable();
      }
    );

    function refreshTable() {
      getProducts({
        page: pages.value,
        paginate: paginate.value,
        search: search.value,
        selectedType: salesType.value,
        deleteData: props.softDelete,
      });
    }

    function restoreHandler(id) {
      swal({
        title: "Will you like to restore data?",
        text: "Your Data will be restore",
        showCancelButton: true,
        confirmButtonColor: "#3084d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, restore it!",
        cancelButtonText: "No, cancel!",
        buttonsStyling: true,
      }).then(function (isConfirm) {
        if (isConfirm.value === true) {
          restore(id);
        }
      });
    }
    function forceDeleteHandler(id) {
      swal({
        title: "Are you sure?",
        text: "Your Data will be permanently deleted from the table",
        showCancelButton: true,
        confirmButtonColor: "#3084d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        buttonsStyling: true,
      }).then(function (isConfirm) {
        if (isConfirm.value === true) {
          deletePro(id);
        }
      });
    }

    return {
      appStates,
      products,
      search,
      salesType,
      pages,
      paginate,
      pageData,
      deleteHandler,
      restoreHandler,
      forceDeleteHandler,
      props,
    };
  },
};
</script>

<style>
</style>
