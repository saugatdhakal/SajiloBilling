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
        <td> <div class="btn-group">
            <router-link
              class="btn btn-primary"
              style="width: 100%"
              :to="{ name: 'accountEdit', params: { id: data.id } }"
            >
              <i class="fa-regular fa-pen-to-square fa-lg"></i>
            </router-link>
            <!-- <button
              style="width: 100%"
              type="button"
              @click="getDetails(account.id)"
              class="btn btn-success"
              data-bs-toggle="modal"
              data-bs-target="#showAccountDetails"
            >
              <i class="fa-regular fa-eye fa-lg"></i>
            </button> -->
            <button

              style="width: 100%"
              class="btn btn-danger"
            >
              <i class="fa-regular fa-user-xmark fa-lg"></i>
            </button>
          </div></td>
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
</template>


<script >
import { appState } from "../../states/appState";
import getSuppliersDetails from "../../composables_api/supplier_api/getSuppliersDetails";
import { onMounted, ref, watch } from "@vue/runtime-core";
import LaravelVuePagination from "laravel-vue-pagination";

export default {
  components: {
    Pagination: LaravelVuePagination,
  },
  setup() {
    const appStates = appState();
    const { supplier, loading, getSuppliers } = getSuppliersDetails();

    const search = ref("");
    const pages = ref(1);
    const paginate = ref(10);

    const pageData = (page = 1) => {
      pages = page;
      console.log(page);
    };
    watch(paginate, () => {
      getSuppliers({
        paginate: paginate.value,
        page: pages.value,
        search: search.value,
      });
    });
    watch(search, () => {
      console.log("clicked");
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
    return { supplier, appStates, pageData, paginate, search, loading };
  },
};
</script>

<style>
</style>
