<template>
  <div :class="sidebarToggle ? 'sb-sidenav-toggled' : null">
    <nav
      class="sb-topnav navbar navbar-expand"
      :class="appStates.themeDark ? 'dark' : 'light'"
    >
      <!-- Navbar Brand-->
      <router-link
        :style="appStates.themeDark ? 'color:white' : 'color:black'"
        class="navbar-brand ps-3"
        to="/"
        >Sajilo Billing</router-link
      >
      <!-- Sidebar Toggle-->
      <button
        @click="toggleNavBar"
        :style="appStates.themeDark ? 'color:white' : 'color:black'"
        class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0"
        id="sidebarToggle"
        href="#!"
      >
        <i class="fas fa-bars"></i>
      </button>
      <!-- Back Button -->
      <button class="btn" @click="$router.go(-1)">
        <i
          class="fa-solid fa-chevron-left"
          :style="appStates.themeDark ? 'color:white' : 'color:black'"
          style="margin-left: 15px"
        ></i>
      </button>

      <!-- Nav DarkMode Toggle Button-->
      <div
        class="
          d-none d-md-inline-block
          form-inline
          ms-auto
          me-0 me-md-3
          my-2 my-md-0
        "
      >
        <div class="input-group">
          <div class="form-check form-switch ms-auto mt-3 me-3">
            <label class="form-check-label ms-2 mb-2" for="lightSwitch">
              <svg
                :style="appStates.themeDark ? 'color:white' : 'color:black'"
                xmlns="http://www.w3.org/2000/svg"
                width="25"
                height="25"
                fill="currentColor"
                viewBox="0 0 16 16"
              >
                <path
                  d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"
                />
              </svg>
            </label>
            <input
              class="form-check-input"
              @input="appStates.themeDark = $event.target.checked"
              :checked="appStates.themeDark"
              style="width: 1.2cm; height: 20px"
              type="checkbox"
              id="lightSwitch"
            />
          </div>
          <!-- <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" /> -->
          <!-- <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button> -->
        </div>
      </div>

      <!-- Navbar-->
      <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
          <a
            :style="appStates.themeDark ? 'color:white' : 'color:black'"
            class="nav-link dropdown-toggle"
            id="navbarDropdown"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
            ><i class="fas fa-user fa-fw"></i
          ></a>
          <ul
            class="dropdown-menu dropdown-menu-end"
            aria-labelledby="navbarDropdown"
          >
            <li><a class="dropdown-item">Settings</a></li>
            <li><a class="dropdown-item">Activity Log</a></li>
            <li><hr class="dropdown-divider" /></li>
            <li><a class="dropdown-item" @click="auths.logout">Logout</a></li>
          </ul>
        </li>
      </ul>
    </nav>
    <div id="layoutSidenav">
      <div id="layoutSidenav_nav">
        <nav
          class="sb-sidenav accordion"
          :class="appStates.themeDark ? 'dark' : 'light'"
          id="sidenavAccordion"
        >
          <div class="sb-sidenav-menu">
            <div class="nav">
              <div class="sb-sidenav-menu-heading">Core</div>
              <!-- Dashboard -->
              <router-link
                :style="appStates.themeDark ? 'color:white' : 'color:black'"
                class="nav-link"
                to="/"
              >
                <i class="fa-regular fa-grid-horizontal p-1 fa-lg"></i>
                Dashboard</router-link
              >
              <!-- User -->
              <router-link
                :style="appStates.themeDark ? 'color:white' : 'color:black'"
                class="nav-link"
                to="/user"
              >
                <i class="fa-regular fa-user p-1 fa-lg"></i>
                User</router-link
              >
              <!-- Account -->
              <a
                :style="appStates.themeDark ? 'color:white' : 'color:black'"
                class="nav-link collapsed"
                href="#"
                data-bs-toggle="collapse"
                data-bs-target="#accountBar"
                aria-expanded="false"
                aria-controls="collapseLayouts"
              >
                <div class="sb-nav-link-icon">
                  <i class="fa-regular fa-file-user p-1 fa-lg"></i>
                </div>
                Account
                <div class="sb-sidenav-collapse-arrow">
                  <i class="fas fa-angle-down"></i>
                </div>
              </a>
              <div
                class="collapse"
                id="accountBar"
                aria-labelledby="headingOne"
                data-bs-parent="#sidenavAccordion"
              >
                <nav class="sb-sidenav-menu-nested nav">
                  <router-link
                    :style="appStates.themeDark ? 'color:white' : 'color:black'"
                    class="nav-link"
                    :to="{ name: 'account' }"
                  >
                    Account Dashboard</router-link
                  >
                  <router-link
                    :style="appStates.themeDark ? 'color:white' : 'color:black'"
                    class="nav-link"
                    :to="{ name: 'accountCreate' }"
                  >
                    Create Account</router-link
                  >
                  <router-link
                    :style="appStates.themeDark ? 'color:white' : 'color:black'"
                    class="nav-link"
                    :to="{ name: 'accountSoftDelete' }"
                  >
                    Trash Account</router-link
                  >
                </nav>
              </div>

              <!-- Suppliers -->
              <a
                :style="appStates.themeDark ? 'color:white' : 'color:black'"
                class="nav-link collapsed"
                href="#"
                data-bs-toggle="collapse"
                data-bs-target="#supplierBar"
                aria-expanded="false"
                aria-controls="collapseLayouts"
              >
                <div class="sb-nav-link-icon">
                  <i class="fa-regular fa-industry-windows p-1 fa-lg"></i>
                </div>
                Supplier
                <div class="sb-sidenav-collapse-arrow">
                  <i class="fa-regular fa-angle-down"></i>
                </div>
              </a>
              <div
                class="collapse"
                id="supplierBar"
                aria-labelledby="headingOne"
                data-bs-parent="#sidenavAccordion"
              >
                <nav class="sb-sidenav-menu-nested nav">
                  <router-link
                    :style="appStates.themeDark ? 'color:white' : 'color:black'"
                    class="nav-link"
                    :to="{ name: 'supplier' }"
                  >
                    Suppier Dashboard</router-link
                  >
                  <router-link
                    :style="appStates.themeDark ? 'color:white' : 'color:black'"
                    class="nav-link"
                    :to="{ name: 'supplierCreate' }"
                  >
                    Create Supplier</router-link
                  >
                  <router-link
                    :style="appStates.themeDark ? 'color:white' : 'color:black'"
                    class="nav-link"
                    :to="{ name: 'supplierSoftDelete' }"
                  >
                    Trash Supplier</router-link
                  >
                </nav>
              </div>

              <!-- Product -->
              <a
                :style="appStates.themeDark ? 'color:white' : 'color:black'"
                class="nav-link collapsed"
                href="#"
                data-bs-toggle="collapse"
                data-bs-target="#productBar"
                aria-expanded="false"
                aria-controls="collapseLayouts"
              >
                <div class="sb-nav-link-icon">
                  <i class="fa-regular fa-clothes-hanger p-1 fa-lg"></i>
                </div>
                Product
                <div class="sb-sidenav-collapse-arrow">
                  <i class="fa-regular fa-angle-down"></i>
                </div>
              </a>
              <div
                class="collapse"
                id="productBar"
                aria-labelledby="headingOne"
                data-bs-parent="#sidenavAccordion"
              >
                <nav class="sb-sidenav-menu-nested nav">
                  <router-link
                    :style="appStates.themeDark ? 'color:white' : 'color:black'"
                    class="nav-link"
                    :to="{ name: 'product' }"
                  >
                    Product Dashboard</router-link
                  >
                  <router-link
                    :style="appStates.themeDark ? 'color:white' : 'color:black'"
                    class="nav-link"
                    :to="{ name: 'productCreate' }"
                  >
                    Create Product</router-link
                  >
                  <router-link
                    :style="appStates.themeDark ? 'color:white' : 'color:black'"
                    class="nav-link"
                    :to="{ name: 'productSoftDelete' }"
                  >
                    Trash Product</router-link
                  >
                </nav>
              </div>

              <!-- Purchase -->
              <a
                :style="appStates.themeDark ? 'color:white' : 'color:black'"
                class="nav-link collapsed"
                href="#"
                data-bs-toggle="collapse"
                data-bs-target="#purchaseBar"
                aria-expanded="false"
                aria-controls="collapseLayouts"
              >
                <div class="sb-nav-link-icon">
                  <i class="fa-regular fa-clothes-hanger p-1 fa-lg"></i>
                </div>
                Purchase
                <div class="sb-sidenav-collapse-arrow">
                  <i class="fa-regular fa-angle-down"></i>
                </div>
              </a>
              <div
                class="collapse"
                id="purchaseBar"
                aria-labelledby="headingOne"
                data-bs-parent="#sidenavAccordion"
              >
                <nav class="sb-sidenav-menu-nested nav">
                  <router-link
                    :style="appStates.themeDark ? 'color:white' : 'color:black'"
                    class="nav-link"
                    :to="{ name: 'purchase' }"
                  >
                    Purchase Dashboard</router-link
                  >
                  <router-link
                    :style="appStates.themeDark ? 'color:white' : 'color:black'"
                    class="nav-link"
                    :to="{ name: 'purchaseCreate' }"
                  >
                    Create Product</router-link
                  >
                  <router-link
                    :style="appStates.themeDark ? 'color:white' : 'color:black'"
                    class="nav-link"
                    :to="{ name: 'purchaseSoftDelete' }"
                  >
                    Trash Product</router-link
                  >
                </nav>
              </div>

              <div class="sb-sidenav-menu-heading">Interface</div>
              <a
                class="nav-link collapsed"
                href="#"
                data-bs-toggle="collapse"
                data-bs-target="#collapseLayouts"
                aria-expanded="false"
                aria-controls="collapseLayouts"
              >
                <div class="sb-nav-link-icon">
                  <i class="fas fa-columns"></i>
                </div>
                Layouts
                <div class="sb-sidenav-collapse-arrow">
                  <i class="fas fa-angle-down"></i>
                </div>
              </a>
              <div
                class="collapse"
                id="collapseLayouts"
                aria-labelledby="headingOne"
                data-bs-parent="#sidenavAccordion"
              >
                <nav class="sb-sidenav-menu-nested nav">
                  <a class="nav-link" href="layout-static.html"
                    >Static Navigation</a
                  >
                  <a class="nav-link" href="layout-sidenav-light.html"
                    >Light Sidenav</a
                  >
                </nav>
              </div>
              <a
                class="nav-link collapsed"
                href="#"
                data-bs-toggle="collapse"
                data-bs-target="#collapsePages"
                aria-expanded="false"
                aria-controls="collapsePages"
              >
                <div class="sb-nav-link-icon">
                  <i class="fas fa-book-open"></i>
                </div>
                Pages
                <div class="sb-sidenav-collapse-arrow">
                  <i class="fas fa-angle-down"></i>
                </div>
              </a>
              <div
                class="collapse"
                id="collapsePages"
                aria-labelledby="headingTwo"
                data-bs-parent="#sidenavAccordion"
              >
                <nav
                  class="sb-sidenav-menu-nested nav accordion"
                  id="sidenavAccordionPages"
                >
                  <a
                    class="nav-link collapsed"
                    href="#"
                    data-bs-toggle="collapse"
                    data-bs-target="#pagesCollapseAuth"
                    aria-expanded="false"
                    aria-controls="pagesCollapseAuth"
                  >
                    Authentication
                    <div class="sb-sidenav-collapse-arrow">
                      <i class="fas fa-angle-down"></i>
                    </div>
                  </a>
                  <div
                    class="collapse"
                    id="pagesCollapseAuth"
                    aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordionPages"
                  >
                    <nav class="sb-sidenav-menu-nested nav">
                      <a class="nav-link" href="login.html">Login</a>
                      <a class="nav-link" href="register.html">Register</a>
                      <a class="nav-link" href="password.html"
                        >Forgot Password</a
                      >
                    </nav>
                  </div>
                  <a
                    class="nav-link collapsed"
                    href="#"
                    data-bs-toggle="collapse"
                    data-bs-target="#pagesCollapseError"
                    aria-expanded="false"
                    aria-controls="pagesCollapseError"
                  >
                    Error
                    <div class="sb-sidenav-collapse-arrow">
                      <i class="fas fa-angle-down"></i>
                    </div>
                  </a>
                  <div
                    class="collapse"
                    id="pagesCollapseError"
                    aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordionPages"
                  >
                    <nav class="sb-sidenav-menu-nested nav">
                      <a class="nav-link" href="401.html">401 Page</a>
                      <a class="nav-link" href="404.html">404 Page</a>
                      <a class="nav-link" href="500.html">500 Page</a>
                    </nav>
                  </div>
                </nav>
              </div>
              <div class="sb-sidenav-menu-heading">Addons</div>
              <a class="nav-link" href="charts.html">
                <div class="sb-nav-link-icon">
                  <i class="fas fa-chart-area"></i>
                </div>
                Charts
              </a>
              <a class="nav-link" href="tables.html">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                Tables
              </a>
            </div>
          </div>
          <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Start Bootstrap
          </div>
        </nav>
      </div>
      <div id="layoutSidenav_content">
        <!-- Body of the page -->
        <main>
          <div class="container-fluid">
            <slot></slot>
          </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
          <div class="container-fluid px-4">
            <div
              class="d-flex align-items-center justify-content-between small"
            >
              <div class="text-muted">Copyright &copy; Your Website 2022</div>
              <div>
                <a href="#">Privacy Policy</a>
                &middot;
                <a href="#">Terms &amp; Conditions</a>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
  </div>
</template>

<script >
import { authState } from "../states/auth";
import { appState } from "../states/appState";
import { ref } from "@vue/reactivity";

export default {
  setup(context) {
    const appStates = appState();
    const auths = authState();
    const sidebarToggle = ref(false);

    const toggleNavBar = () => {
      sidebarToggle.value = !sidebarToggle.value;
    };
    return { auths, appStates, sidebarToggle, toggleNavBar };
  },
};
</script>

<style>
.nav a.router-link-exact-active {
  color: white;
  background: crimson;
  padding: 15px;
  border-radius: 5px;
}
.light {
  background-color: #dee4ea;
  color: black;
  transition: background 0.7s ease-in-out;
}
.dark {
  background-color: #1f2a34;
  color: white;
  transition: background 0.7s ease-in-out;
}
</style>
