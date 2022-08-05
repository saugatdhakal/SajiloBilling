<template>
  <h1>Account Dashboard</h1>
  <br />

  <AccountDatatable />
</template>

<script>
import { inject, onMounted, ref } from "@vue/runtime-core";

import AccountDatatable from "../../views/account/accountDatatable.vue";
export default {
  components: {
    AccountDatatable,
  },
  props: ["createFlag"],
  setup(props) {
    //Inject Toaster
    const toast = inject("toast");

    //All for toast message after account created
    const createFlags = ref(false);
    createFlags.value = props.createFlag ? props.createFlag : false;
    if (createFlags.value) {
      toast.success("New User has been register");
      createFlags.value = false;
    }

    return {};
  },
};
</script>

<style>
</style>
