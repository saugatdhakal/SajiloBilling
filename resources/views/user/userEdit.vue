<template>
  <div class="row p-3">
    <div class="col-md-6">
      <form @submit.prevent="submit">
        <BaseCard style="padding: 30px">
          <!-- <center class="fw-bold h2">ADD USER</center> -->
          <h2 id="card-header">
            Update User <i class="fa-solid fa-user-pen"></i>
          </h2>
          <BaseInput
            class="mb-3"
            v-model="name"
            :error="errors.name"
            label="Name"
            type="text"
          />
          <BaseInput
            class="mb-3"
            label="Email Address"
            type="text"
            v-model="email"
            :error="errors.email"
          />
          <span>Roles : </span>
          <BaseRadioGroup v-model="role" name="role" :options="rolesGroup" />
          <br />
          <BaseButtom type="submit">UPDATE</BaseButtom>
        </BaseCard>
      </form>
    </div>
  </div>
</template>

<script>
import { useField, useForm } from "vee-validate";
import updateUserDetails from "../../composables_api/user_api/UpdateUserDetails";
import BaseInput from "../../components/BaseInput.vue";
import BaseRadioGroup from "../../components/BaseRadioGroup.vue";
import BaseCard from "../../components/BaseCard.vue";
import BaseButtom from "../../components/BaseButton.vue";
import getUserDetails from "../../composables_api/user_api/getUserDetails";
import { reactive } from "@vue/reactivity";
import router from "../../router";
import {
  required,
  emailValidation,
  minLength,
  anything,
} from "../../components_js/validation";
import { watch } from "@vue/runtime-core";

export default {
  components: {
    BaseInput,
    BaseRadioGroup,
    BaseCard,
    BaseButtom,
  },
  props: ["id"],
  setup(props) {
    const userId = props.id;
    const rolesGroup = [
      { label: "Admin", value: "1" },
      { label: "Staff", value: "0" },
    ];
    const { user: userDetails, getUser } = getUserDetails();
    const {
      user: updatedUser,
      error: updateError,
      userUpdate,
    } = updateUserDetails();

    getUser(userId);

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
      role: anything,
    };

    const userFormInput = reactive({
      emails: "",
      names: "",
      roles: "",
    });

    const { handleSubmit, errors } = useForm({
      validationSchema,
      initialValues: {
        role: 1,
      },
    });

    const { value: email } = useField("email");
    const { value: name } = useField("name");
    const { value: role } = useField("role");

    watch(userDetails, () => {
      email.value = userDetails.value.email;
      name.value = userDetails.value.name;
      role.value = userDetails.value.role;
    });

    const submit = handleSubmit((values) => {
      userUpdate(userId, values);
    });
    watch(updatedUser, (newUpdate, oldUpdate) => {
      if (newUpdate.status) {
        router.push({ name: "user", params: { updateFlag: true } });
      }
    });
    return {
      rolesGroup,
      userDetails,
      email,
      role,
      name,
      submit,
      errors,
    };
  },
};
</script>

<style>
</style>
