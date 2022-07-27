<template>
  <div class="row p-3">
    <div class="col-md-6">
      <form @submit.prevent="submit">
        <BaseCard>
          <!-- <center class="fw-bold h2">ADD USER</center> -->
          <h2 id="card-header">Create User</h2>
          <BaseInput
            class="mb-3"
            label="Name"
            v-model="name"
            type="text"
            style="width: 90%"
            :error="errors.name"
          />
          <BaseInput
            class="mb-3"
            label="Email Address"
            style="width: 90%"
            v-model="email"
            type="text"
        :error="errors.email"
          />
          <BaseInput
            class="mb-3"
            label="Password"
            style="width: 90%"
            v-model="password"
            :error="errors.password"
            type="text"
          />
          <span>Roles : </span>
          <BaseRadioGroup v-model="role" name="role" :options="rolesGroup" />
          <br />
          <BaseButtom type="submit">Create</BaseButtom>
        </BaseCard>
      </form>
    </div>
  </div>
</template>

<script >
import { useField, useForm } from "vee-validate";
import BaseInput from "../../components/BaseInput.vue";
import BaseRadioGroup from "../../components/BaseRadioGroup.vue";
import BaseCard from "../../components/BaseCard.vue";
import BaseButtom from "../../components/BaseButton.vue";
import registerUser from "../../composables_api/user_api/createUser.js";
import router from "../../router";
import { watch } from "@vue/runtime-core";
import { ref } from "@vue/reactivity";

// import getUserList from "../../composables_api/user_api/user";

export default {
  components: {
    BaseInput,
    BaseRadioGroup,
    BaseCard,
    BaseButtom,
  },
  setup() {
    // const { users, error, logedUser } = getUserList();
    const { user, error, createUser, isLoading } = registerUser();
    const resUser = ref({});

    const rolesGroup = [
      { label: "Admin", value: "1" },
      { label: "Staff", value: "0" },
    ];

    const required = (value) => {
      const requiredMessage = "This is a required";
      if (!value) return requiredMessage;
      if (!String(value).length) return requiredMessage;

      return true;
    };
    const emailValidation = (value) => {
      const regex =
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      if (!regex.test(String(value).toLowerCase())) {
        return "Please enter a valid email address";
      }
      return true;
    };

    const minLength = (number, value) => {
      if (String(value).length < number)
        return "Please type at least " + number + " characters";
      return true;
    };
    const anything = () => {
      return true;
    };

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


    const submit = handleSubmit((values) => {
      createUser(values);

    });
    watch(user, (newUser, oldUser) => {
      if (newUser.status) {
        router.push({name:"user",params: {registerFlag:true}});
      }
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
    };
  },
};
</script>

<style>
</style>
