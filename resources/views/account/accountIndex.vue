<template>
  <div class="d-flex flex-row justify-content-between mt-2">
    <h1 style="font-weight: 800; margin-top: ">Account Dashboard</h1>

    <div class="mt-2">
      <RouterLink
        class="btn btn-danger me-3 p-2"
        :to="{ name: 'accountSoftDelete' }"
        ><i class="fa-solid fa-trash-can-list"></i> Trash Accounts</RouterLink
      >
      <RouterLink class="btn btn-dark me-3 p-2" :to="{ name: 'accountCreate' }">
        <i class="fa-regular fa-user-plus"></i> Add Account</RouterLink
      >
    </div>
  </div>

  <AccountDatatable />
</template>

<script>
import { inject, onMounted, ref } from "@vue/runtime-core";
import BaseButton from "../../components/BaseButton.vue";

import AccountDatatable from "../../views/account/accountDatatable.vue";
export default {
  components: {
    BaseButton,
    AccountDatatable,
  },
  props: ["createFlag", "updateFlags"],
  setup(props) {
    //Inject Toaster
    const toast = inject("toast");

    //All for toast message after account created
    const createFlags = ref(false);
    const updateFlag = ref(false);

    createFlags.value = props.createFlag ? props.createFlag : false;
    updateFlag.value = props.updateFlags ? props.updateFlags : false;

    if (createFlags.value) {
      toast.success("New Account has been register");
      createFlags.value = false;
    }
    if (updateFlag.value) {
      toast.success("Account has been updated");
      updateFlag.value = false;
    }

    return {};
  },
};
</script>

<style>
</style>
