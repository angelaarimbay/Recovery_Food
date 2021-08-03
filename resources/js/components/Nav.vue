<template>
  <nav>
    <v-app-bar app dense dark class="red darken-3">
      <v-app-bar-nav-icon @click.stop="mini = !mini"></v-app-bar-nav-icon>

      <v-list-item-title class="hidden-sm-and-down"
        >Online Inventory and Sales Monitoring System for Recovery
        Food</v-list-item-title
      >

      <v-spacer></v-spacer>
      <v-menu offset-y>
        <template v-slot:activator="{ on, attrs }">
          <v-btn dark text v-bind="attrs" v-on="on">
            <v-icon class="round">mdi-account</v-icon> <small>Account</small>
          </v-btn>
        </template>
        <v-list>
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
      <template v-slot:prepend>
        <v-list-item class="px-2">
          <v-list-item-avatar class="mb-0">
            <v-img src="/img/Logo_No_BG.png"></v-img>
          </v-list-item-avatar>
          <v-list-item-title>RECOVERY FOOD</v-list-item-title>
        </v-list-item>
      </template>

      <v-divider class="m-0"></v-divider>

      <v-list nav dense>
        <v-list-item style="text-decoration: none" to="/dashboard">
          <v-list-item-icon>
            <v-icon size="23">mdi-view-dashboard</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Dashboard</v-list-item-title>
        </v-list-item>

        <v-list-item style="text-decoration: none" :to="{ name: 'home' }">
          <v-list-item-icon>
            <v-icon size="23">mdi-storefront</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Branches</v-list-item-title>
        </v-list-item>

        <v-list-group no-action>
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon size="23">mdi-tag-multiple</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Categories</v-list-item-title>
          </template>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Supplies Category</v-list-item-title>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Products Category</v-list-item-title>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Products-Sub Category</v-list-item-title>
          </v-list-item>
        </v-list-group>

        <v-list-group no-action>
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon size="23">mdi-package</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Inventory</v-list-item-title>
          </template>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Masterlist Supplies</v-list-item-title>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Incoming Supplies</v-list-item-title>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Outgoing Supplies</v-list-item-title>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Main Inventory</v-list-item-title>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Inventory Summary</v-list-item-title>
          </v-list-item>
        </v-list-group>

        <v-list-group no-action>
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon size="23">mdi-package-variant-closed</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Products</v-list-item-title>
          </template>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Products List</v-list-item-title>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Outgoing Products</v-list-item-title>
          </v-list-item>
        </v-list-group>

        <v-list-group no-action>
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon size="23">mdi-truck</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Suppliers</v-list-item-title>
          </template>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Suppliers List</v-list-item-title>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Purchase Orders</v-list-item-title>
          </v-list-item>
        </v-list-group>

        <v-list-group no-action>
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon size="23">mdi-file-multiple</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Reports</v-list-item-title>
          </template>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Inventory Report</v-list-item-title>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Sales Report</v-list-item-title>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Transaction Report</v-list-item-title>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Purchase Orders Report</v-list-item-title>
          </v-list-item>
        </v-list-group>

        <v-list-item style="text-decoration: none" :to="''">
          <v-list-item-icon>
            <v-icon size="23">mdi-account-multiple</v-icon>
          </v-list-item-icon>
          <v-list-item-title>User Accounts</v-list-item-title>
        </v-list-item>

        <v-list-group no-action>
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon size="23">mdi-wrench</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Settings</v-list-item-title>
          </template>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Permissions</v-list-item-title>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Company</v-list-item-title>
          </v-list-item>
        </v-list-group>
      </v-list>

      <template v-slot:append>
        <v-divider class="m-0"></v-divider>
        <v-list-item style="text-decoration: none" :to="''">
          <v-list-item-icon>
            <v-icon size="23">mdi-logout</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Log Out</v-list-item-title>
        </v-list-item>
      </template>
    </v-navigation-drawer>
  </nav>
</template>

<style>
.v-navigation-drawer__content::-webkit-scrollbar {
  width: 0px;
}
.v-list-item {
  flex: 0;
}
</style>

<script>
export default {
  data() {
    return {
      drawer: false,
      mini: false,
    };
  },
};
</script>