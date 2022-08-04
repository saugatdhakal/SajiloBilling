<template>I am here in account</template>

<script>
import { inject, ref
 } from "@vue/runtime-core";
export default {
  props: ["createFlag"],
  setup(props) {
    //Inject Toaster
    const toast = inject("toast");

    const createFlags = ref(false);
    createFlags.value = (props.createFlag) ? props.createFlag : false;

    if(createFlags.value){
            toast.success("New User has been register");
            createFlags.value = false;
    }

  },
};
</script>

<style>
</style>
