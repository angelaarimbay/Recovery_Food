<template>
  <!-- Div -->
  <div style="min-width: 280px">
    <template v-if="user">
      <!-- Inventory -->
      <!-- App Bar -->
      <v-app-bar
        v-if="!user.permissionslist.includes('Access POS')"
        dense
        dark
        class="red darken-2"
        app
        flat
      >
        <template class="d-none">
          <v-app-bar-nav-icon
            v-if="$vuetify.breakpoint.xsOnly"
            @click.stop="
              mini = false;
              drawer = !drawer;
            "
          ></v-app-bar-nav-icon>
          <v-app-bar-nav-icon
            v-else
            @click.stop="mini = !mini"
          ></v-app-bar-nav-icon>
        </template>
        <v-list-item-title class="font-weight-bold hidden-sm-and-down"
          >Inventory and Sales Monitoring System</v-list-item-title
        >

        <v-spacer></v-spacer>

        <!-- Account -->
        <v-menu offset-y>
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              dark
              text
              v-bind="attrs"
              v-on="on"
              style="text-transform: none"
              large
              :small="$vuetify.breakpoint.smAndDown"
              class="px-2"
            >
              <v-icon class="round">mdi-account</v-icon
              ><span>{{ user.first_name }}</span>
              <v-icon>mdi-menu-down</v-icon>
            </v-btn>
          </template>
          <v-list dense>
            <!-- Password -->
            <v-list-item
              :to="{ name: 'password' }"
              style="text-decoration: none"
            >
              <v-list-item-title style="cursor: pointer"
                >Password</v-list-item-title
              >
            </v-list-item>
            <!-- Log Out -->
            <v-list-item>
              <v-list-item-title @click="logout" style="cursor: pointer"
                >Log Out
              </v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </v-app-bar>

      <!-- POS -->
      <v-app-bar
        v-if="user.permissionslist.includes('Access POS')"
        dense
        dark
        class="red darken-2"
        app
        flat
      >
        <v-list-item-avatar class="my-0">
          <v-img :src="logo_path"></v-img>
        </v-list-item-avatar>
        <v-list-item-title class="font-weight-bold hidden-sm-and-down"
          >Point of Sale System</v-list-item-title
        >
        <v-list-item class="hidden-xs-only">{{
          user.branch_details.branch_name
        }}</v-list-item>
        <v-spacer></v-spacer>
        <v-menu offset-y>
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              dark
              text
              v-bind="attrs"
              v-on="on"
              style="text-transform: none"
              large
              :small="$vuetify.breakpoint.smAndDown"
              class="px-2"
            >
              <v-icon class="round">mdi-account</v-icon><span></span
              ><span>{{ user.first_name }}</span>
              <v-icon>mdi-menu-down</v-icon>
            </v-btn>
          </template>
          <v-list dense>
            <!-- Password -->
            <v-list-item
              :to="{ name: 'password' }"
              style="text-decoration: none"
            >
              <v-list-item-title style="cursor: pointer"
                >Password</v-list-item-title
              >
            </v-list-item>
            <!-- Log Out -->
            <v-list-item>
              <v-list-item-title @click="logout" style="cursor: pointer"
                >Logout
              </v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </v-app-bar>

      <!-- Navigation Drawer -->
      <v-navigation-drawer
        height="100%"
        app
        v-if="
          user.permissionslist.length > 0 &&
          !user.permissionslist.includes('Access POS')
        "
        v-model="drawer"
        :permanent="$vuetify.breakpoint.smAndUp"
        :mini-variant.sync="mini"
        dark
        class="grey darken-4"
      >
        <template v-slot:prepend>
          <v-list-item class="px-2 red darken-4">
            <v-list-item-avatar class="my-0">
              <v-img :src="logo_path"></v-img>
            </v-list-item-avatar>
            <v-list-item-title class="font-weight-bold"
              >Recovery Food
            </v-list-item-title>
          </v-list-item>
        </template>

        <v-list nav dense>
          <v-list-item
            v-if="user.permissionslist.includes('Access Dashboard')"
            style="text-decoration: none"
            :to="{ name: 'dashboard' }"
          >
            <v-list-item-icon>
              <v-icon size="23">mdi-view-dashboard</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Dashboard</v-list-item-title>
          </v-list-item>

          <v-list-group
            v-if="user.permissionslist.includes('Access Branches')"
            no-action
            color="#FFFFFF"
            active-class="bg-grey"
            class="mb-1"
          >
            <template v-slot:activator>
              <v-list-item-icon>
                <v-icon size="23">mdi-storefront</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Branches</v-list-item-title>
            </template>

            <v-list class="p-0" flat>
              <v-list-item
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'manage-branches' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Manage Branches</v-list-item-title>
              </v-list-item>

              <v-list-item
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'branches-inventory' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Branches Inventory</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-list-group>

          <v-list-group
            v-if="user.permissionslist.includes('Access Categories')"
            no-action
            color="#FFFFFF"
            active-class="bg-grey"
            class="mb-1"
          >
            <template v-slot:activator>
              <v-list-item-icon>
                <v-icon size="23">mdi-tag-multiple</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Categories</v-list-item-title>
            </template>

            <v-list class="p-0" flat>
              <v-list-item
                v-if="user.roles[0].name != 'Production Assistant'"
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'supplies-category' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Supplies Category</v-list-item-title>
              </v-list-item>

              <v-list-item
                v-if="user.roles[0].name != 'Stockman'"
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'products-category' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Products Category</v-list-item-title>
              </v-list-item>

              <v-list-item
                v-if="user.roles[0].name != 'Stockman'"
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'products-sub-category' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Products Subcategory</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-list-group>

          <v-list-group
            v-if="
              user.permissionslist.includes('Access Inventory') ||
              user.permissionslist.includes('Access Branch Inventory')
            "
            no-action
            color="#FFFFFF"
            active-class="bg-grey"
            class="mb-1"
          >
            <template v-slot:activator>
              <v-list-item-icon>
                <v-icon size="23">mdi-package</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Inventory</v-list-item-title>
            </template>

            <v-list class="p-0" flat>
              <v-list-item
                v-if="!user.permissionslist.includes('Access Branch Inventory')"
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'masterlist-supplies' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Masterlist Supplies</v-list-item-title>
              </v-list-item>

              <v-list-item
                v-if="!user.permissionslist.includes('Access Branch Inventory')"
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'incoming-supplies' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Incoming Supplies</v-list-item-title>
              </v-list-item>

              <v-list-item
                v-if="!user.permissionslist.includes('Access Branch Inventory')"
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'outgoing-supplies' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Outgoing Supplies</v-list-item-title>
              </v-list-item>

              <v-list-item
                v-if="!user.permissionslist.includes('Access Branch Inventory')"
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'main-inventory' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Main Inventory</v-list-item-title>
              </v-list-item>

              <v-list-item
                v-if="!user.permissionslist.includes('Access Branch Inventory')"
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'inventory-summary' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Inventory Summary</v-list-item-title>
              </v-list-item>

              <v-list-item
                v-if="user.permissionslist.includes('Access Branch Inventory')"
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'supplies-inventory' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Supplies Inventory</v-list-item-title>
              </v-list-item>

              <v-list-item
                v-if="user.permissionslist.includes('Access Branch Inventory')"
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'deducted-supplies' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Deducted Supplies</v-list-item-title>
              </v-list-item>

              <v-list-item
                v-if="user.permissionslist.includes('Access Branch Inventory')"
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'request-supplies' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Supplies Request</v-list-item-title>
              </v-list-item>

              <v-list-item
                v-if="user.permissionslist.includes('Access Branch Inventory')"
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'request-products' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Products Request</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-list-group>

          <v-list-group
            v-if="user.permissionslist.includes('Access Products')"
            no-action
            color="#FFFFFF"
            active-class="bg-grey"
            class="mb-1"
          >
            <template v-slot:activator>
              <v-list-item-icon>
                <v-icon size="23">mdi-package-variant-closed</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Products</v-list-item-title>
            </template>

            <v-list class="p-0" flat>
              <v-list-item
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'masterlist-products' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Masterlist Products</v-list-item-title>
              </v-list-item>

              <v-list-item
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'incoming-products' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Incoming Products</v-list-item-title>
              </v-list-item>

              <v-list-item
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'outgoing-products' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Outgoing Products</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-list-group>

          <v-list-group
            v-if="user.permissionslist.includes('Access Suppliers')"
            no-action
            color="#FFFFFF"
            active-class="bg-grey"
            class="mb-1"
          >
            <template v-slot:activator>
              <v-list-item-icon>
                <v-icon size="23">mdi-truck</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Suppliers</v-list-item-title>
            </template>

            <v-list class="p-0" flat>
              <v-list-item
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'suppliers-list' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Suppliers List</v-list-item-title>
              </v-list-item>

              <v-list-item
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'purchase-orders' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Purchase Orders</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-list-group>

          <v-list-item
            v-if="
              (user.permissionslist.includes('Access Reports') &&
                !user.permissionslist.includes('Access POS')) &&
              !user.permissionslist.includes('Access Branch Inventory')
            "
            style="text-decoration: none"
            :to="{ name: 'reports' }"
          >
            <v-list-item-icon>
              <v-icon size="23">mdi-file</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Reports</v-list-item-title>
          </v-list-item>

          <v-list-item
            v-if="
              user.permissionslist.includes('Access User Accounts') &&
              !user.permissionslist.includes('Access POS') &&
              !user.permissionslist.includes('Access Branch Inventory')
            "
            style="text-decoration: none"
            :to="{ name: 'user-accounts' }"
          >
            <v-list-item-icon>
              <v-icon size="23">mdi-account-multiple</v-icon>
            </v-list-item-icon>
            <v-list-item-title>User Accounts</v-list-item-title>
          </v-list-item>

          <v-list-group
            v-if="
              user.permissionslist.includes('Access Settings') &&
              !user.permissionslist.includes('Access POS') &&
              !user.permissionslist.includes('Access Branch Inventory')
            "
            no-action
            color="#FFFFFF"
            active-class="bg-grey"
            class="mb-1"
          >
            <template v-slot:activator>
              <v-list-item-icon>
                <v-icon size="23">mdi-wrench</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Settings</v-list-item-title>
            </template>

            <v-list class="p-0" flat>
              <v-list-item
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'roles-permissions' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Roles/Permissions</v-list-item-title>
              </v-list-item>

              <v-list-item
                style="text-decoration: none"
                class="pl-8 mb-1"
                :to="{ name: 'company' }"
              >
                <v-list-item-icon class="me-3">
                  <v-icon size="16">mdi-circle</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Company</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-list-group>
        </v-list>

        <template v-slot:append>
          <v-divider class="m-0"></v-divider>
          <v-list-item
            color="#FFFFFF"
            style="text-decoration: none"
            @click="logout"
            nav
            dense
          >
            <v-list-item-icon>
              <v-icon size="23">mdi-logout</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Log Out</v-list-item-title>
          </v-list-item>
        </template>
      </v-navigation-drawer>
    </template>
  </div>
</template>

<!-- Style -->
<style>
/* For Chrome, Microsoft Edge */
html {
  overflow-y: initial !important;
}

.v-navigation-drawer ::-webkit-scrollbar {
  width: 0px;
}

::-webkit-scrollbar-track {
  --webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
  background-color: #fafafa;
}

::-webkit-scrollbar {
  height: 12px;
  width: 12px;
}

::-webkit-scrollbar-thumb {
  border: 2px solid rgba(0, 0, 0, 0);
  background-clip: padding-box;
  border-radius: 9999px;
  background-color: #9e9e9e;
}
/* For Chrome, Microsoft Edge */

/* For FireFox */
html {
  scrollbar-color: #9e9e9e #fafafa;
}

.bg-grey {
  background-color: #616161;
}
</style>

<style scoped>
.v-menu__content.theme--light .v-list {
  background: white !important;
}
.theme--light.v-list-item:hover:before {
  opacity: 0.2 !important;
}
</style>

<!-- Script -->
<script>
import { mapGetters } from "vuex";
import axios from "axios"; //Library for sending api request
// import template from "../pages/template.vue";
export default {
  // components: { template },
  middleware: "auth",
  //Computed
  computed: {
    ...mapGetters({
      user: "auth/user",
      permissions: "auth/user_permissions",
      roles: "auth/user_roles",
    }),
  },

  //Onload
  created() {
    this.getLogo();
  },
  data() {
    return {
      logo_path: "/img/Logo.jpg", //Default if no uploaded image
      drawer: true,
      mini: false,
    };
  },

  //Methods
  methods: {
    reloadPage() {
      window.location.reload();
    },

    //For retrieving logo
    async getLogo() {
      await axios.get("/api/settings/company/logo/get").then((result) => {
        if (result.data.path) {
          console.log(result.data)
          this.logo_path = result.data.path;
        }
      });
    },

    //For logging out
    async logout() {
      //Log out the user.
      await this.$store.dispatch("auth/logout").catch((errr) => {});

      //Redirect to login.
      this.$router.push({ name: "login" });
      this.reloadPage();
    },
  },
};
</script>