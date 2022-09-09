<template>
  <div>
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
            v-model="purchaseStatus"
            style="width: 10rem; text-align: center; height: 35px"
            id="pageNo"
            name="pageSelect"
            optionEmpty="All"
            :options="['RUNNING', 'COMPLETED', 'CANCLED']"
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
      <thead class="header">
        <th width="5%">SN</th>
        <th width="15%">Invoice No</th>
        <th>Supplier Name</th>
        <th>Transaction Date</th>
        <th>Bill Date</th>
        <th>Bill No</th>
        <th>Net Amount</th>
        <th width="10%">Action</th>
      </thead>
      <tbody>
        <tr v-for="(data, i) in purchase.data" :key="i">
          <td>{{ ++i }}</td>
          <td>{{ data.invoice_number }}</td>
          <td>{{ data.supplier_name }}</td>
          <td>{{ data.transaction_date }}</td>
          <td>{{ data.bill_date }}</td>
          <td>{{ data.bill_no }}</td>
          <td>{{ data.net_amount }}</td>
          <td>
            <purchaseTableButton :id="data.id"></purchaseTableButton>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="d-flex flex-row">
      <span class="fw-bold fs-4 mx-2">Pages -</span>
      <Pagination
        style="page"
        :data="purchase"
        @pagination-change-page="pageData"
      />
    </div>
  </div>
</template>


<script >
import LaravelVuePagination from "laravel-vue-pagination";
import { onMounted, ref, watch, inject } from "@vue/runtime-core";
import purchaseDataTable from "../../composables_api/purchase_api/purchaseDataTable";
import { appState } from "../../states/appState";
import BaseSelect from "../../components/BaseSelect.vue";
import purchaseTableButton from "./purchaseTableButton.vue";
export default {
  components: {
    Pagination: LaravelVuePagination,
    BaseSelect,
    purchaseTableButton,
  },
  setup() {
    const appStates = appState();
    const search = ref("");
    const pages = ref(1);
    const purchaseStatus = ref("");
    const paginate = ref(10); // 10 20 30 All

    const { purchase, purchaseLoading, getTableData } = purchaseDataTable();
    onMounted(() => {
      refreshTable();
    });
    function refreshTable() {
      getTableData({
        page: pages.value,
        paginate: paginate.value,
        selectedType: purchaseStatus.value,
        search: search.value,
      });
    }
    watch([pages, paginate, purchaseStatus, search], () => {
      refreshTable();
    });
    const pageData = (page = 1) => {
      pages.value = page;
      refreshTable();
    };
    return {
      appStates,
      purchase,
      pageData,
      search,
      pages,
      purchaseStatus,
      paginate,
    };
  },
};
</script>

<style>
table tr:hover {
  background: rgba(244, 240, 240, 0.954);
  color: black;
}
.header th {
  line-height: 1cm;
}
</style>
