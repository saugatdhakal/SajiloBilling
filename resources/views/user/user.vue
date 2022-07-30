<template>
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
          <p>{{ getStaffCount }}</p>
        </div>
      </BaseCard>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4">
      <BaseCard>
        <div class="row" style="font-size: 25px; font-weight: 600">
          <p>Total Users</p>
          <p>{{ getTotalUserCount }}</p>
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
                      class="btn btn-primary"
                      @click="modalSelectedUser(user.id)"
                      data-bs-toggle="modal"
                      data-bs-target="#passwordModal"
                    >
                      <i class="fa-solid fa-key"></i>
                    </button>
                    <button
                      style="width: 100%"
                      type="button"
                      class="btn btn-success btn-block edit"
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

    <!-- Password Modal -->
    <BaseModal
      @closeForm="clearFormInputs"
      @submit.prevent="passwordModalSubmit"
      modelHeader="Change User Password"
      id="passwordModal"
      v-model:modelToggle="modelOpen"
    >
      <template v-slot:modalBody>
        <BaseInput
          required
          class="mb-3"
          v-model="passwordModal.newPassword"
          label="New Password"
          type="text"
          style="width: 90%"
          :error="passwordModal.newPassError"
        />
        <BaseInput
          required
          class="mb-3"
          v-model="passwordModal.repeatPassword"
          label="Repeat New Password"
          type="text"
          style="width: 90%"
          :error="passwordModal.repeatPassError"
        />
      </template>
    </BaseModal>
  </div>
</template>

<script>
import BaseCard from "../../components/BaseCard.vue";
import BaseModal from "../../components/BaseModal.vue";
import BaseInput from "../../components/BaseInput.vue";
import { reactive, ref } from "@vue/reactivity";
import { appState } from "../../states/appState";
import getUserList from "../../composables_api/user_api/user";
import { inject, onMounted, watch } from "@vue/runtime-core";
import udpateUserPassword from "../../composables_api/user_api/changeUserPassword";

export default {
  components: {
    BaseCard,
    BaseModal,
    BaseInput,
  },
  props: ["registerFlag"],
  setup(props) {
    // APP State
    const appStates = appState();
    onMounted(async () => {
      await logedUser();
    });

    //Bootstrap Modal Toggle Component
    const modelOpen = ref(false);
    const openModel = () => {
      modelOpen.value = !modelOpen.value;
    };
    const { user: userUpdated, setPassword } = udpateUserPassword();
    //
    const passwordModal = reactive({
      newPassword: "",
      repeatPassword: "",
      newPassError: "",
      repeatPassError: "",
    });
    function clearFormInputs() {
      passwordModal.newPassError = "";
      passwordModal.repeatPassError = "";
      passwordModal.newPassword = "";
      passwordModal.repeatPassword = "";
    }
    function passwordModalSubmit(event) {
      event.target.reset();
      const flag = validatePasswordModals();
      if (flag) {
        setPassword(passwordModal, selectedUserId.value);
      }
    }
    //Wating for request to be fatched and assign into userUpdated
    watch(userUpdated, () => {
      toast.success("User password updated successfully");
    });

    const selectedUserId = ref("");
    // Getting user id after clicking the change password button
    function modalSelectedUser(id) {
      selectedUserId.value = id;
    }

    function validatePasswordModals() {
      const requiredMessage = "Please Fill Password!!";
      const passdoesnotMatch = "Password does not match!! Try again";
      const minLength = "min 6 digits password required";
      if (!passwordModal.newPassword && !passwordModal.repeatPassword) {
        passwordModal.newPassError = requiredMessage;
        passwordModal.repeatPassError = requiredMessage;
        return false;
      }
      if (!passwordModal.newPassword) {
        passwordModal.newPassError = requiredMessage;
        return false;
      }
      if (!passwordModal.repeatPassword) {
        passwordModal.repeatPassError = requiredMessage;
        return false;
      }
      if (
        passwordModal.newPassword.length < 6 &&
        passwordModal.repeatPassword.length < 6
      ) {
        passwordModal.newPassError = minLength;
        passwordModal.repeatPassError = minLength;
        return false;
      }
      //Checkin two fields is equal or not
      if (
        passwordModal.newPassword.trim() != passwordModal.repeatPassword.trim()
      ) {
        passwordModal.newPassError = passdoesnotMatch;
        passwordModal.repeatPassError = passdoesnotMatch;

        return false;
      }
      passwordModal.newPassError = "";
      passwordModal.repeatPassError = "";
      return true;
    }

    //ComposablesApi for Dashboard card and
    const {
      users,
      error,
      logedUser,
      getAdminCount,
      getStaffCount,
      getTotalUserCount,
    } = getUserList();
    const loading = ref(true);

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

    return {
      appStates,
      loading,
      users,
      getAdminCount,
      getStaffCount,
      getTotalUserCount,
      modelOpen,
      openModel,
      passwordModalSubmit,
      passwordModal,
      clearFormInputs,
      modalSelectedUser,
    };
  },
};
</script>

<style scoped>
.errorMessage {
  color: red;
  font: italic;
}
</style>
