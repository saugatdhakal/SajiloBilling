<template>
  <!-- Loading Div if loading true -->
  <div v-if="loading">
    <div class="text-center">
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </div>
  <div
    v-else
    class="
      d-flex
      flex-row
      justify-content-between
      mx-2
      my-1
      justify-content-center
    "
  >
    <div class="d-flex flex-row justify-content-center">
      <label for="pageNo" class="pe-2 align-middle fw-bold fs-5"
        >Per Page</label
      >
      <select
        v-model="paginates"
        name="pageSelect"
        style="width: 70px; text-align: center; height: 30px"
        id="pageNo"
      >
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="30">30</option>
        <option value="40">40</option>
        <option value="-1">All</option>
      </select>
      <div class="mx-5 d-flex flex-row justify-content-center">
        <span class="fw-bold fs-5 pe-2">Filter By Type</span>
        <select
          v-model="selectType"
          style="width: 80px; text-align: center; height: 30px"
        >
          <option value="">None</option>
          <option value="retailer">Reatiler</option>
          <option value="individual">Individual</option>
        </select>
      </div>
    </div>

    <div class="d-flex flex-row justify-content-center">
      <label class="fw-bold fs-4 mx-3">
        <i class="fa-solid fa-magnifying-glass"></i>
      </label>
      <input
        v-model.lazy="search"
        type="text"
        class="form-control mb-2"
        placeholder="Search Here"
      />
    </div>
  </div>
  <table
    class="table"
    style="border-radius: 5px; width: 100%"
    :style="
      appStates.themeDark
        ? 'background-color: #1f2a34;color:white;'
        : 'background-color: #eaebec;'
    "
  >
    <thead>
      <tr>
        <th>SN</th>
        <th>Account Type</th>
        <th>Name</th>
        <th>Shop Name</th>
        <th>Address</th>
        <th>contact No</th>
        <th>Email</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(account, i) in accounts.data" :key="account.id">
        <td>{{ ++i }}</td>
        <td>
          <span
            class="badge rounded-pill bg-info text-dark"
            :class="
              account.account_type == 'retailer' ? 'bg-info' : 'bg-warning'
            "
            >{{ account.account_type.toUpperCase() }}</span
          >
        </td>
        <td>{{ account.name }}</td>
        <td>{{ account.shop_name ? account.shop_name : "EMPTY" }}</td>
        <td>{{ account.address }}</td>
        <td>{{ account.contact_number }}</td>
        <td>{{ account.email }}</td>
        <td>
          <div class="btn-group">
            <router-link
              class="btn btn-primary"
              style="width: 100%"
              :to="{ name: 'accountEdit', params: { id: account.id } }"
            >
              <i class="fa-regular fa-pen-to-square fa-lg"></i>
            </router-link>
            <button
              @click="deleteAccount(account.id)"
              style="width: 100%"
              class="btn btn-danger"
            >
              <i class="fa-regular fa-user-xmark fa-lg"></i>
            </button>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
  <Pagination
    style="page"
    :data="accounts"
    @pagination-change-page="pageData"
  />
</template>

<script>
import { onMounted, ref, watch, inject } from "@vue/runtime-core";
import accountDetails from "../../composables_api/account_api/getAccounts";
import AccountDelete from "../../composables_api/account_api/softDeleteAccount";
import LaravelVuePagination from "laravel-vue-pagination";
import { appState } from "../../states/appState";

export default {
  components: {
    Pagination: LaravelVuePagination,
  },
  setup(props, context) {
    const { accounts, loading, getAccounts } = accountDetails(); // Composables Api
    const {
      deletedAccount,
      accountError,
      softDelete,
    } = AccountDelete(); // Delete Composables Api

    const appStates = appState();

    // sweet alert 2
    const swal = inject("$swal");

    const search = ref("");
    const paginates = ref(10); //Per page columns
    const paginationPage = ref(1); //Page Number
    const selectType = ref("");

    //Function get the page number and pass to getAccounts(composables api)
    const pageData = (page = 1) => {
      paginationPage.value = page;
      getAccounts({
        page: paginationPage.value,
        paginate: paginates.value,
        search: search.value,
        selectedType: selectType.value,
      });
    };
    function deleteAccount(id) {
      swal({
        title: "Are you sure?",
        text: "Your Data will be temporarily deleted from the table",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        buttonsStyling: true,
      }).then(function (isConfirm) {
        if (isConfirm.value === true) {
          softDelete(id);
        }
      });
    }
    watch(deletedAccount, () => {
      //Refresh page by calling api function
      getAccounts({
        page: paginationPage.value,
        paginate: paginates.value,
        search: search.value,
        selectedType: selectType.value,
      });

      swal({
        position: "top-end",
        icon: "success",
        title: "user has been successfully deleted",
        showConfirmButton: false,
        timer: 1500,
      });
    });
    // watching Per Page select to be change
    watch(paginates, () => {
      getAccounts({
        page: paginationPage.value,
        paginate: paginates.value,
        search: search.value,
        selectedType: selectType.value,
      });
    });
    //Input search
    watch(search, () => {
      getAccounts({
        page: paginationPage.value,
        paginate: paginates.value,
        search: search.value,
        selectedType: selectType.value,
      });
    });
    watch(selectType, () => {
      getAccounts({
        page: paginationPage.value,
        paginate: paginates.value,
        search: search.value,
        selectedType: selectType.value,
      });
    });

    onMounted(() => {
      getAccounts({
        page: paginationPage.value,
        paginate: paginates.value,
        search: search.value,
        selectedType: selectType.value,
      });
    });

    return {
      accounts,
      loading,
      appStates,
      paginates,
      search,
      pageData,
      selectType,
      deleteAccount,
    };
  },
};
</script>

<style>
.page-item.active .page-link,
.page-item.active .dataTable-pagination a,
.dataTable-pagination .page-item.active a,
.dataTable-pagination li.active .page-link,
.dataTable-pagination li.active a {
  z-index: 3;
  color: #fff;
  background-color: #1f2a34;
  border-color: #f8f9fa;
}
</style>
