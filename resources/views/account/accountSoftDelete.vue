<template>
    <h1>Account Trash Dashboard</h1>
  <div
    class="
      mt-2
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
      <div class="mx-4 d-flex flex-row justify-content-center">
        <span class="fw-bold fs-4 pe-2">Filter By Type</span>
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
            <button
              style="width: 100%"
              @click="getDetails(account.id)"
              type="button"
              class="btn btn-success"
              data-bs-toggle="modal"
              data-bs-target="#showAccountDetails"
            >
              <i class="fa-regular fa-eye fa-lg"></i>
            </button>
            <button
              style="width: 100%"
              @click="deleteAccount(account.id)"
              class="btn btn-danger"
            >
              <i class="fa-regular fa-user-xmark fa-lg"></i>
            </button>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
  <div class="mx-4 d-flex flex-row justify-content-between">
    <div>
      <span
        >Showing {{ accounts.from }} to {{ accounts.to }} of
        {{ accounts.total }} entries</span
      >
    </div>
    <div class="d-flex flex-row">
      <span class="fw-bold fs-4 mx-2">Pages -</span>
      <Pagination
        style="page"
        :data="accounts"
        @pagination-change-page="pageData"
      />
    </div>
  </div>

  <!-- Bootstrap Modal -->
  <BaseModal
    modelHeader="Show Account Details"
    id="showAccountDetails"
    :footerButton="false"
    :dropBack="true"
  >
    <template v-slot:modalBody>
      <div class="d-flex flex-column">
        <span
          class="badge rounded-pill bg-info text-dark"
          style="height: 30px; font-size: 17px"
          :class="
            accountViewData.account_type == 'retailer'
              ? 'bg-info'
              : 'bg-warning'
          "
          >{{
            accountViewData.account_type == "retailer"
              ? "Retailer"
              : "Individual"
          }}</span
        >
        <p class="fs-4">Name : {{ accountViewData.name }}</p>
        <p class="fs-4" v-if="accountViewData.account_type == 'retailer'">
          Shop Name : {{ accountViewData.shop_name }}
        </p>
        <p class="fs-4">Address : {{ accountViewData.address }}</p>
        <p class="fs-4">Contact No : {{ accountViewData.contact_number }}</p>
        <p class="fs-4">Email : {{ accountViewData.email }}</p>
        <p class="fs-4" v-if="accountViewData.account_type == 'retailer'">
          Vat No :
          {{
            accountViewData.vat_number ? accountViewData.vat_number : "Empty"
          }}
        </p>
        <p class="fs-4" v-if="accountViewData.account_type == 'retailer'">
          Pan No :{{
            accountViewData.pan_number ? accountViewData.pan_number : "Empty"
          }}
        </p>
        <p class="fs-4">Due Limit : Rs. {{ accountViewData.due_limit }}</p>
      </div>
    </template>
  </BaseModal>
</template>

<script>
import { onMounted, ref, watch, inject } from "@vue/runtime-core";
import LaravelVuePagination from "laravel-vue-pagination";
import { appState } from "../../states/appState";
import BaseModal from "../../components/BaseModal.vue";
import getSoftDeleteAccounts from "../../composables_api/account_api/getSoftDeleteAccount";
import getAccountDetails from "../../composables_api/account_api/getAccountDetails";
import forceDeleteAccounts from "../../composables_api/account_api/forceDeleteAccount";

export default {
  components: {
    Pagination: LaravelVuePagination,
    BaseModal,
  },
  setup(props) {
    const appStates = appState();
    const { accounts, accountError, getAccounts } = getSoftDeleteAccounts();
    const {
      deletedAccount,
      accountError: deleteAccountError,
      deleteAcc,
    } = forceDeleteAccounts();
    const {
      account: accountViewData,
      accountError: viewAccError,
      getDetails,
    } = getAccountDetails(); // get specific account details

    const search = ref("");
    const paginates = ref(10); //Per page columns
    const paginationPage = ref(1); //Page Number
    const selectType = ref("");

    // sweet alert 2
    const swal = inject("$swal");

    function deleteAccount(id) {
      swal({
        title: "Are you sure?",
        text: "Your Data will be Permanently deleted from the table",
        showCancelButton: true,
        confirmButtonColor: "#3084d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        buttonsStyling: true,
      }).then(function (isConfirm) {
        if (isConfirm.value === true) {
          deleteAcc(id);
          pageData();
        }
      });
    }

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

    const pageData = (page = 1) => {
      paginationPage.value = page;
      getAccounts({
        page: paginationPage.value,
        paginate: paginates.value,
        search: search.value,
        selectedType: selectType.value,
      });
    };
    onMounted(() => {
      getAccounts({
        page: paginationPage.value,
        paginate: paginates.value,
        search: search.value,
        selectedType: selectType.value,
      });
    });
    return {
      appStates,
      accounts,
      pageData,
      accountViewData,
      getDetails,
      deleteAccount,
      paginates,
      search,
      pageData,
      selectType
    };
  },
};
</script>

<style>
</style>
