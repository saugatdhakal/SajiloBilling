<template>
  <div class="row">
    <div class="col-md-12">
      <div class="row m-2">
        <div class="col-md-4"></div>
        <div class="col-md-6"></div>
        <div class="col-md-2">
          <router-link
            class="btn btn-outline-primary"
            :to="{ name: 'adduser' }"
            tag="button"
          >
            <i class="fa-solid fa-user-plus"></i> ADD USER</router-link
          >
        </div>
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
          style="border-radius: 5px"
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
              <th>Edit</th>
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
                  <div class="col-md-6">
                    <button
                      style="width: 100%"
                      type="button"
                      class="btn btn-primary changePassword"
                      data-bs-toggle="modal"
                      data-id="{{$row->id}}"
                      data-bs-target="#change_password"
                    >
                      <i class="fa-solid fa-key"></i> Password
                    </button>
                  </div>
                  <div class="col-md-4">
                    <button
                      style="width: 100%"
                      type="button"
                      class="btn btn-success edit"
                      data-bs-toggle="modal"
                      data-id="{{$row->id}}"
                      data-bs-target="#change_details"
                    >
                      <i class="fa-solid fa-user-gear"></i> Edit
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

<script setup>
import { ref } from "@vue/reactivity";
import { appState } from "../../states/appState";
import getUserList from "../../composables_api/user_api/user";
import { onMounted, watch } from "@vue/runtime-core";
const appStates = appState();
const { users, error, logedUser } = getUserList();
const loading = ref(true);
watch(users, () => {
    loading.value= false;
});
onMounted(() => {
  logedUser();
});
</script>

<style>
</style>
