<template>
  <!-- <BaseCard class="mt-1" style="width: 100%; height: auto">
    <div class="row">
      <div class="col-12">
        <span style="font-size: 20px">User Dashboard</span>
      </div>
    </div>
  </BaseCard> -->
<div class="text-center border-b"><h1>User Dashboard</h1></div>
  <div class="row card-deck mt-2 mb-2 gy-2">
    <div class="col-xs-12 col-sm-6 col-md-4">
      <BaseCard>
        <div class="row" style="font-size: 25px; font-weight: 600">
          <p>Total Admin Users</p>
          <p>{{ getAdminCount }}</p>
        </div>
      </BaseCard>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4">
      <BaseCard>
        <div class="row" style="font-size: 25px; font-weight: 600">
          <p>Total Staff Users</p>
          <p>{{getStaffCount}}</p>
        </div>
      </BaseCard>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4">
      <BaseCard>
        <div class="row" style="font-size: 25px; font-weight: 600">
          <p>Total Users</p>
          <p>{{getTotalUserCount}}</p>
        </div>
      </BaseCard>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="float-end m-2">
        <router-link
          class="btn btn-outline-primary"
          :to="{ name: 'adduser' }"
          tag="button"
        >
          <i class="fa-solid fa-user-plus"></i> ADD USER</router-link
        >
      </div>

      <div v-if="loading">
        <div class="text-center">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      </div>
      <div v-else>
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
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Register at</th>
              <th width="12%">Edit</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(user, i) in users" :key="i">
              <td>{{ ++i }}</td>
              <td>{{ user.name }}</td>
              <td>{{ user.email }}</td>
              <td>{{ user.role == 1 ? "admin" : "staff" }}</td>
              <td>{{ user.created_at }}</td>
              <td>
                <div class="row">
                  <div class="btn-group">
                    <button
                      style="width: 100%"
                      type="button"
                      class="btn btn-primary changePassword"
                      data-bs-toggle="modal"
                      data-id="{{$row->id}}"
                      data-bs-target="#change_password"
                    >
                      <i class="fa-solid fa-key"></i>
                    </button>
                    <button
                      style="width: 100%"
                      type="button"
                      class="btn btn-success btn-block edit"
                      data-bs-toggle="modal"
                      data-id="{{$row->id}}"
                      data-bs-target="#change_details"
                    >
                      <i class="fa-solid fa-user-gear"></i>
                    </button>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!-- Button trigger modal -->
    <!-- <button
      type="button"
      class="btn btn-primary"
      data-bs-toggle="modal"
      data-bs-target="#exampleModal"
    >
      Launch demo modal
    </button> -->

    <!-- Modal -->
    <!-- <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">...</div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Close
            </button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div> -->
  </div>
</template>

<script>
import BaseCard from "../../components/BaseCard.vue";
import { ref } from "@vue/reactivity";
import { appState } from "../../states/appState";
import getUserList from "../../composables_api/user_api/user";
import { computed, inject, onMounted, watch } from "@vue/runtime-core";
export default {
  components: {
    BaseCard,
  },
  props: ["registerFlag"],
  setup(props) {
    // APP states
    const appStates = appState();
    onMounted(async () => {
      await logedUser();
    });
    //ComposablesApi
    const { users, error, logedUser, getAdminCount,getStaffCount,getTotalUserCount } = getUserList();
    const loading = ref(true);
    const userAdminCount = ref(0);

    //Inject Toaster
    const toast = inject("toast");

    //Watching for loading to change states
    watch(users, () => {
      loading.value = false;
    });

    //Receving props(boolean) from Useradd after 200 status
    if (props.registerFlag) {
      toast.success("New User has been register");
      props.registerFlag = false;
    }

    // const totalAdminUsers = users.filter(user => user.isAdmin).count();

    return {
      appStates,
      loading,
      users,
      getAdminCount,
      getStaffCount,
      getTotalUserCount
    };
  },
};
</script>

<style>
</style>
