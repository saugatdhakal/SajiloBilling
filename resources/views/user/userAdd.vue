<template>
  <div class="row p-3">
    <div class="col-md-6">
      <form @submit.prevent="submit">
        <BaseCard style="padding: 30px">
          <!-- <center class="fw-bold h2">ADD USER</center> -->
          <h2 id="card-header">
            Create User <i class="fa-solid fa-user-plus"></i>
          </h2>
          <BaseInput
            class="mb-3"
            label="Name"
            v-model="name"
            type="text"
            :error="errors.name"
          />
          <BaseInput
            class="mb-3"
            label="Email Address"
            v-model="email"
            type="text"
            :error="errors.email"
          />
          <BaseInput
            class="mb-3"
            label="Password"
            v-model="password"
            :error="errors.password"
            type="text"
          />
          <span>Roles : </span>
          <BaseRadioGroup v-model="role" name="role" :options="rolesGroup" />
          <br />
          <BaseButtom type="submit">
            <BaseSpinner v-if="loading"></BaseSpinner>

            <p style="padding: 0; margin: 0" v-else>Create</p>
          </BaseButtom>
        </BaseCard>
      </form>
    </div>
  </div>
</template>

<script >
//All Imports
import { useField, useForm } from "vee-validate";
import BaseInput from "../../components/BaseInput.vue";
import BaseRadioGroup from "../../components/BaseRadioGroup.vue";
import BaseCard from "../../components/BaseCard.vue";
import BaseButtom from "../../components/BaseButton.vue";
import registerUser from "../../composables_api/user_api/createUser.js";
import router from "../../router";
import { watch, inject } from "@vue/runtime-core";
import { ref } from "@vue/reactivity";
import BaseSpinner from "../../components/BaseSpinner.vue";
import {
  required,
  emailValidation,
  minLength,
  anything,
} from "../../components_js/validation";

// import getUserList from "../../composables_api/user_api/user";

export default {
  components: {
    BaseInput,
    BaseRadioGroup,
    BaseCard,
    BaseButtom,
    BaseSpinner,
  },
  setup() {
    // const { users, error, logedUser } = getUserList();
    const { user, error, createUser } = registerUser();
    const resUser = ref({});
    //Inject Toaster
    const toast = inject("toast");

    const rolesGroup = [
      { label: "Admin", value: "1" },
      { label: "Staff", value: "0" },
    ];

    const validationSchema = {
      name: (value) => {
        const req = required(value);
        if (req != true) return req;
        const min = minLength(5, value);
        if (min != true) return min;

        return true;
      },
      email: (value) => {
        const req = required(value);
        if (req != true) return req;
        const min = minLength(5, value);
        if (min != true) return min;
        const emailVal = emailValidation(value);
        if (emailVal != true) return emailVal;

        return true;
      },
      password: (value) => {
        const req = required(value);
        if (req != true) return req;
        const min = minLength(8, value);
        if (min != true) return min;

        return true;
      },
      role: anything,
    };

    const { handleSubmit, errors } = useForm({
      validationSchema,
      initialValues: {
        role: 1,
      },
    });

    const { value: email } = useField("email");
    const { value: password } = useField("password");
    const { value: name } = useField("name");
    const { value: role } = useField("role");
    const loading = ref(false);
    const submit = handleSubmit((values) => {
      createUser(values);
      loading.value = true;
    });
    watch(user, (newUser, oldUser) => {
      loading.value = false;
      if (newUser.status) {
        router.push({ name: "user", params: { registerFlag: true } });
      }
    });
    watch(error, (newError, oldError) => {
      loading.value = false;
      toast.error(" This User already Exists ");
    });

    return {
      submit,
      email,
      password,
      role,
      name,
      rolesGroup,
      errors,
      user,
      error,
      loading,
    };
  },
};
</script>

<style>
</style>
