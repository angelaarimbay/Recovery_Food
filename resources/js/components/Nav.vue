<template>
  <div>
    <v-app-bar app dark class="red darken-3">
      <v-app-bar-nav-icon @click.stop="mini = !mini"></v-app-bar-nav-icon>

      Online Inventory and Sales Monitoring System for Recovery Food

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
      app
      v-model="drawer"
      :mini-variant.sync="mini"
      permanent
      dark
      class="grey darken-4"
    >
      <template v-slot:prepend>
        <v-list-item>
          <v-list-item-content>
            <v-img
              class="mx-auto"
              max-height="50"
              max-width="50"
              src="/img/Logo_No_BG.png"
            ></v-img>
          </v-list-item-content>
        </v-list-item>
      </template>

      <v-divider class="m-0"></v-divider>

      <v-list>
        <v-list-item style="text-decoration: none" to="/dashboard">
          <v-list-item-icon>
            <v-icon size="23">mdi-view-dashboard</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <span>Dashboard</span>
          </v-list-item-content>
        </v-list-item>

        <v-list-item style="text-decoration: none" :to="{ name: 'home' }">
          <v-list-item-icon>
            <v-icon size="23">mdi-storefront</v-icon>
          </v-list-item-icon>
          <v-list-item-content>Branches</v-list-item-content>
        </v-list-item>

        <v-list-group no-action>
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon size="23">mdi-tag-multiple</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Categories</v-list-item-content>
          </template>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Supplies Category</v-list-item-content>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Products Category</v-list-item-content>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Products-Sub Category</v-list-item-content>
          </v-list-item>
        </v-list-group>

        <v-list-group no-action>
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon size="23">mdi-package</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Inventory</v-list-item-content>
          </template>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Masterlist Supplies</v-list-item-content>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Incoming Supplies</v-list-item-content>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Outgoing Supplies</v-list-item-content>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Main Inventory</v-list-item-content>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Inventory Summary</v-list-item-content>
          </v-list-item>
        </v-list-group>

        <v-list-group no-action>
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon size="23">mdi-package-variant-closed</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Products</v-list-item-content>
          </template>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Products List</v-list-item-content>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Outgoing Products</v-list-item-content>
          </v-list-item>
        </v-list-group>

        <v-list-group no-action>
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon size="23">mdi-truck</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Suppliers</v-list-item-content>
          </template>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Suppliers List</v-list-item-content>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Purchase Orders</v-list-item-content>
          </v-list-item>
        </v-list-group>

        <v-list-group no-action>
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon size="23">mdi-file-multiple</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Reports</v-list-item-content>
          </template>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Inventory Report</v-list-item-content>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Sales Report</v-list-item-content>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Transaction Report</v-list-item-content>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Purchase Orders Report</v-list-item-content>
          </v-list-item>
        </v-list-group>

        <v-list-item style="text-decoration: none" :to="''">
          <v-list-item-icon>
            <v-icon size="23">mdi-account-multiple</v-icon>
          </v-list-item-icon>
          <v-list-item-content>User Accounts</v-list-item-content>
        </v-list-item>

        <v-list-group no-action>
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon size="23">mdi-wrench</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Settings</v-list-item-content>
          </template>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Permissions</v-list-item-content>
          </v-list-item>

          <v-list-item style="text-decoration: none" class="pl-8" :to="''">
            <v-list-item-icon class="me-3">
              <v-icon size="16">mdi-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>Company</v-list-item-content>
          </v-list-item>
        </v-list-group>
      </v-list>
    </v-navigation-drawer>
  </div>
</template>

<script>
export default {
  data() {
    return {
      drawer: true,
      mini: false,
    };
  },
};
</script>