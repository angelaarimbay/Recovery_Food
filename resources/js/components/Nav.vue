<template>
  <div>
    <v-app-bar   dense dark class="red darken-2" app>
    <template v-if="user">
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

      <v-menu offset-y >
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            dark v-if="user"
            text
            v-bind="attrs"
            v-on="on"
            style="text-transform: none"
            :small="$vuetify.breakpoint.smAndDown"
          >
            <v-icon class="round">mdi-account</v-icon
            ><span
              >Account</span
            >
          </v-btn>
        </template>
        <v-list dense>
          <v-list-item>
            <v-list-item-title>Menu 1</v-list-item-title>
          </v-list-item>
          <v-list-item>
            <v-list-item-title>Menu 2</v-list-item-title>
          </v-list-item>
          <v-list-item>
            <v-list-item-title>Menu 3</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>

    <v-navigation-drawer 
      height="100%"
      app
      v-model="drawer"
      :permanent="$vuetify.breakpoint.smAndUp"
      :mini-variant.sync="mini"
      dark
      class="grey darken-4"
    >
      <template v-slot:prepend >
        <v-list-item class="px-2 red darken-4">
          <v-list-item-avatar class="my-0">
            <v-img src="/img/Logo.jpg"></v-img>
          </v-list-item-avatar>
          <v-list-item-title class="font-weight-bold"
            >Recovery Food</v-list-item-title
          >
        </v-list-item>
      </template>

      <v-divider class="m-0"></v-divider>

      <v-list nav dense >
        <v-list-item style="text-decoration: none" to="/dashboard">
          <v-list-item-icon>
            <v-icon size="23">mdi-view-dashboard</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Dashboard</v-list-item-title>
        </v-list-item>

        <v-list-group 
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
              to="/manage_branches"
            >
              <v-list-item-icon class="me-3">
                <v-icon size="16">mdi-circle</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Manage Branches</v-list-item-title>
            </v-list-item>

            <v-list-item
              style="text-decoration: none"
              class="pl-8 mb-1"
              to="/branches_inventory"
            >
              <v-list-item-icon class="me-3">
                <v-icon size="16">mdi-circle</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Branches Inventory</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-list-group>

        <v-list-group
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
              style="text-decoration: none"
              class="pl-8 mb-1"
              to="/supplies_category"
            >
              <v-list-item-icon class="me-3">
                <v-icon size="16">mdi-circle</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Supplies Category</v-list-item-title>
            </v-list-item>

            <v-list-item
              style="text-decoration: none"
              class="pl-8 mb-1"
              to="/products_category"
            >
              <v-list-item-icon class="me-3">
                <v-icon size="16">mdi-circle</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Products Category</v-list-item-title>
            </v-list-item>

            <v-list-item
              style="text-decoration: none"
              class="pl-8 mb-1"
              to="/products_sub_category"
            >
              <v-list-item-icon class="me-3">
                <v-icon size="16">mdi-circle</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Products-Sub Category</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-list-group>

        <v-list-group
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
              style="text-decoration: none"
              class="pl-8 mb-1"
              to="/masterlist_supplies"
            >
              <v-list-item-icon class="me-3">
                <v-icon size="16">mdi-circle</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Masterlist Supplies</v-list-item-title>
            </v-list-item>

            <v-list-item
              style="text-decoration: none"
              class="pl-8 mb-1"
              to="/incoming_supplies"
            >
              <v-list-item-icon class="me-3">
                <v-icon size="16">mdi-circle</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Incoming Supplies</v-list-item-title>
            </v-list-item>

            <v-list-item
              style="text-decoration: none"
              class="pl-8 mb-1"
              to="/outgoing_supplies"
            >
              <v-list-item-icon class="me-3">
                <v-icon size="16">mdi-circle</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Outgoing Supplies</v-list-item-title>
            </v-list-item>

            <v-list-item
              style="text-decoration: none"
              class="pl-8 mb-1"
              to="/main_inventory"
            >
              <v-list-item-icon class="me-3">
                <v-icon size="16">mdi-circle</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Main Inventory</v-list-item-title>
            </v-list-item>

            <v-list-item
              style="text-decoration: none"
              class="pl-8 mb-1"
              to="/inventory_summary"
            >
              <v-list-item-icon class="me-3">
                <v-icon size="16">mdi-circle</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Inventory Summary</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-list-group>

        <v-list-group
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
              to="/products_list"
            >
              <v-list-item-icon class="me-3">
                <v-icon size="16">mdi-circle</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Products List</v-list-item-title>
            </v-list-item>

            <v-list-item
              style="text-decoration: none"
              class="pl-8 mb-1"
              to="/outgoing_products"
            >
              <v-list-item-icon class="me-3">
                <v-icon size="16">mdi-circle</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Outgoing Products</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-list-group>

        <v-list-group
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
              to="/suppliers_list"
            >
              <v-list-item-icon class="me-3">
                <v-icon size="16">mdi-circle</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Suppliers List</v-list-item-title>
            </v-list-item>

            <v-list-item
              style="text-decoration: none"
              class="pl-8 mb-1"
              to="/purchase_orders"
            >
              <v-list-item-icon class="me-3">
                <v-icon size="16">mdi-circle</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Purchase Orders</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-list-group>

        <v-list-item style="text-decoration: none" to="/reports">
          <v-list-item-icon>
            <v-icon size="23">mdi-account-multiple</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Reports</v-list-item-title>
        </v-list-item>

        <v-list-item style="text-decoration: none" to="/user_accounts">
          <v-list-item-icon>
            <v-icon size="23">mdi-account-multiple</v-icon>
          </v-list-item-icon>
          <v-list-item-title>User Accounts</v-list-item-title>
        </v-list-item>

        <v-list-group
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
              to="/roles_permissions"
            >
              <v-list-item-icon class="me-3">
                <v-icon size="16">mdi-circle</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Roles/Permissions</v-list-item-title>
            </v-list-item>

            <v-list-item
              style="text-decoration: none"
              class="pl-8 mb-1"
              to="/sett2"
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
          class="pb-1"
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
  </div>
</template>

<style>
::-webkit-scrollbar {
  width: 0px;
}
.bg-grey {
  background-color: #616161;
}
</style>

<script>
import { mapGetters } from 'vuex' 
export default { 
  middleware: 'auth',
 computed: {
        ...mapGetters({
            user: 'auth/user',
            permissions: 'auth/user_permissions',
            roles: 'auth/user_roles',
        }),

    },
  data() {
    return {
      drawer: true,
      mini: false,
    };
  },    methods: {
        async logout () {
        // Log out the user.
        await this.$store.dispatch('auth/logout')

        // Redirect to login.
        this.$router.push({ name: 'login' })
        }
    }
};
</script>