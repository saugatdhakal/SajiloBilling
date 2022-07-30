<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
          <div class="card-header">
            <h3 class="text-center font-weight-light my-3">Puja Fancy Store</h3>
          </div>
          <div class="card-body">
            <form @submit.prevent="LoginEvent">
              <div class="form-floating mb-3">
                <input
                  v-model="form.email"
                  class="form-control"
                  id="inputEmail"
                  type="email"
                  required
                  placeholder="name@example.com"
                />
                <label for="inputEmail">Email address</label>
              </div>
              <label v-if="form.emailError" class="mb-3" for="inputEmail">{{
                form.emailError
              }}</label>
              <div class="form-floating mb-3">
                <input
                  v-model="form.password"
                  class="form-control"
                  id="inputPassword"
                  type="password"
                  required
                  placeholder="Password"
                />
                <label for="inputPassword">Password</label>
              </div>
              <label v-if="form.passwordError" class="mb-3" for="inputEmail">{{
                form.passwordError
              }}</label>
              <div class="form-check mb-3">
                <input
                  class="form-check-input"
                  id="inputRememberPassword"
                  type="checkbox"
                  value=""
                />
                <label class="form-check-label" for="inputRememberPassword"
                  >Remember Password</label
                >
              </div>
              <button @click="loginEvent" class="btn btn-primary w-100" to="/">
                Login
              </button>
              <div
                class="
                  d-flex
                  align-items-center
                  justify-content-center
                  mt-4
                  mb-0
                "
              >
                <a class="small">Forgot Password?</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { reactive, ref } from "@vue/reactivity";
import { onMounted } from "@vue/runtime-core";
import { authState } from "../../states/auth";
export default {
  setup() {
    const auths = authState();
    const flag = ref(false);
    const form = reactive({
      email: "",
      password: "",
      credentialError: "",
    });
    const LoginEvent = () => {
      if (!form.email || !form.password) {
        credentialError = "Please Fill your credentials";
        return false;
      }
      if (form.email && form.password) {
        const res = auths.LoginEvent(form);
        console.log(res);
      } else {
        return false;
      }
    };
    onMounted(() => {
      auths.checkLogin();
    });

    return { form, LoginEvent, auths };
  },
};
</script>

<style>
</style>
