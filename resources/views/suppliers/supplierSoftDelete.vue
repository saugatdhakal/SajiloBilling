<template>
  <div v-if="supplier.data && supplier.data.length <= 0">
    <div class="d-flex flex-row justify-content-center mt-2">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        data-name="Layer 1"
        width="647.63626"
        height="632.17383"
        viewBox="0 0 647.63626 632.17383"
      >
        <path
          d="M687.3279,276.08691H512.81813a15.01828,15.01828,0,0,0-15,15v387.85l-2,.61005-42.81006,13.11a8.00676,8.00676,0,0,1-9.98974-5.31L315.678,271.39691a8.00313,8.00313,0,0,1,5.31006-9.99l65.97022-20.2,191.25-58.54,65.96972-20.2a7.98927,7.98927,0,0,1,9.99024,5.3l32.5498,106.32Z"
          transform="translate(-276.18187 -133.91309)"
          fill="#f2f2f2"
        />
        <path
          d="M725.408,274.08691l-39.23-128.14a16.99368,16.99368,0,0,0-21.23-11.28l-92.75,28.39L380.95827,221.60693l-92.75,28.4a17.0152,17.0152,0,0,0-11.28028,21.23l134.08008,437.93a17.02661,17.02661,0,0,0,16.26026,12.03,16.78926,16.78926,0,0,0,4.96972-.75l63.58008-19.46,2-.62v-2.09l-2,.61-64.16992,19.65a15.01489,15.01489,0,0,1-18.73-9.95l-134.06983-437.94a14.97935,14.97935,0,0,1,9.94971-18.73l92.75-28.4,191.24024-58.54,92.75-28.4a15.15551,15.15551,0,0,1,4.40966-.66,15.01461,15.01461,0,0,1,14.32032,10.61l39.0498,127.56.62012,2h2.08008Z"
          transform="translate(-276.18187 -133.91309)"
          fill="#3f3d56"
        />
        <path
          d="M398.86279,261.73389a9.0157,9.0157,0,0,1-8.61133-6.3667l-12.88037-42.07178a8.99884,8.99884,0,0,1,5.9712-11.24023l175.939-53.86377a9.00867,9.00867,0,0,1,11.24072,5.9707l12.88037,42.07227a9.01029,9.01029,0,0,1-5.9707,11.24072L401.49219,261.33887A8.976,8.976,0,0,1,398.86279,261.73389Z"
          transform="translate(-276.18187 -133.91309)"
          fill="#38374c"
        />
        <circle cx="190.15351" cy="24.95465" r="20" fill="#38374c" />
        <circle cx="190.15351" cy="24.95465" r="12.66462" fill="#fff" />
        <path
          d="M878.81836,716.08691h-338a8.50981,8.50981,0,0,1-8.5-8.5v-405a8.50951,8.50951,0,0,1,8.5-8.5h338a8.50982,8.50982,0,0,1,8.5,8.5v405A8.51013,8.51013,0,0,1,878.81836,716.08691Z"
          transform="translate(-276.18187 -133.91309)"
          fill="#e6e6e6"
        />
        <path
          d="M723.31813,274.08691h-210.5a17.02411,17.02411,0,0,0-17,17v407.8l2-.61v-407.19a15.01828,15.01828,0,0,1,15-15H723.93825Zm183.5,0h-394a17.02411,17.02411,0,0,0-17,17v458a17.0241,17.0241,0,0,0,17,17h394a17.0241,17.0241,0,0,0,17-17v-458A17.02411,17.02411,0,0,0,906.81813,274.08691Zm15,475a15.01828,15.01828,0,0,1-15,15h-394a15.01828,15.01828,0,0,1-15-15v-458a15.01828,15.01828,0,0,1,15-15h394a15.01828,15.01828,0,0,1,15,15Z"
          transform="translate(-276.18187 -133.91309)"
          fill="#3f3d56"
        />
        <path
          d="M801.81836,318.08691h-184a9.01015,9.01015,0,0,1-9-9v-44a9.01016,9.01016,0,0,1,9-9h184a9.01016,9.01016,0,0,1,9,9v44A9.01015,9.01015,0,0,1,801.81836,318.08691Z"
          transform="translate(-276.18187 -133.91309)"
          fill="#38374c"
        />
        <circle cx="433.63626" cy="105.17383" r="20" fill="#38374c" />
        <circle cx="433.63626" cy="105.17383" r="12.18187" fill="#fff" />
      </svg>
    </div>
    <div class="d-flex flex-row justify-content-center mt-2 fs-1 fw-blod">
      NO DATA FOUND
    </div>
  </div>
  <div v-else>
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
        <select
          v-model="paginate"
          name="pageSelect"
          style="width: 70px; text-align: center; height: 30px"
          id="pageNo"
        >
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="30">30</option>
          <option value="40">40</option>
          <option value="50">50</option>
          <option value="-1">All</option>
        </select>
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
      class="table table-responsive"
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
          <th>Address</th>
          <th>Contact No</th>
          <th>Contact Person</th>
          <th>Email</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(data, i) in supplier.data" :key="data.id">
          <td>{{ ++i }}</td>
          <td>{{ data.name }}</td>
          <td>{{ data.address }}</td>
          <td>{{ data.contact_number }}</td>
          <td>{{ data.contact_person ? data.contact_person : "Empty" }}</td>
          <td>{{ data.email }}</td>
          <td>
            <div class="btn-group">
              <button
                style="width: 100%"
                class="btn btn-success"
                @click="restoreHandler(data.id)"
              >
                <i class="fa-solid fa-arrow-rotate-left"></i>
              </button>

              <button
                style="width: 100%"
                class="btn btn-danger"
                @click="deleteHandler(data.id)"
              >
                <i class="fa-regular fa-user-xmark fa-lg"></i>
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="d-flex flex-row">
      <span class="fw-bold fs-4 mx-2">Pages -</span>
      <Pagination
        style="page"
        :data="supplier"
        @pagination-change-page="pageData"
      />
    </div>
  </div>
</template>


<script >
import { appState } from "../../states/appState";
import getSoftDeleteSupplier from "../../composables_api/supplier_api/getSoftDeleteSupplier";
import forceDeleteSupplier from "../../composables_api/supplier_api/forceDeleteSupplier";
import restoreTrashSupplier from "../../composables_api/supplier_api/restoreTrashSupplier";
import { onMounted, ref, watch, inject } from "@vue/runtime-core";
import LaravelVuePagination from "laravel-vue-pagination";
import router from "../../router";

export default {
  components: {
    Pagination: LaravelVuePagination,
  },
  setup() {
    const appStates = appState();
    const { supplier, loading, getSuppliers } = getSoftDeleteSupplier();
    const { deletedSupplier, deleteSupp } = forceDeleteSupplier();
    const { restoreSupplier, restore } = restoreTrashSupplier();
    const search = ref("");
    let pages = ref(1);
    const paginate = ref(10);

    // sweet alert 2
    const swal = inject("$swal");

    const pageData = (page = 1) => {
      pages.value = page;
      getSuppliers({
        paginate: paginate.value,
        page: pages.value,
        search: search.value,
      });
    };

    const deleteHandler = (id) => {
      swal({
        title: "Are you sure?",
        text: "Your Data will be Permanently delete from the table",
        showCancelButton: true,
        confirmButtonColor: "#3084d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        buttonsStyling: true,
      }).then(function (isConfirm) {
        if (isConfirm.value === true) {
          deleteSupp(id);
        }
      });
    };
    const restoreHandler = (id) => {
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
    };
    watch(paginate, () => {
      getSuppliers({
        paginate: paginate.value,
        page: pages.value,
        search: search.value,
      });
    });
    watch(restoreSupplier, () => {
      router.push({ name: "supplier" });
    });
    watch(search, () => {
      console.log("clicked");
      getSuppliers({
        paginate: paginate.value,
        page: pages.value,
        search: search.value,
      });
    });

    watch(deletedSupplier, () => {
      getSuppliers({
        paginate: paginate.value,
        page: pages.value,
        search: search.value,
      });
    });

    onMounted(() => {
      getSuppliers({
        paginate: paginate.value,
        page: pages.value,
        search: search.value,
      });
    });
    return {
      supplier,
      appStates,
      pageData,
      paginate,
      search,
      loading,
      deleteHandler,
      restoreHandler,
    };
  },
};
</script>

<style>
</style>
