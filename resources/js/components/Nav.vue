<template>
  <div>
    <v-app-bar app dark class="red darken-3">
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

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
    <v-navigation-drawer app v-model="drawer" dark class="grey darken-4">
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
            <v-list-item-content>
              <v-list-item-title>Categories</v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item
            style="text-decoration: none"
            class="pl-6"
            :to="'/auth/index'"
          >
            <v-list-item-icon>
              <v-icon size="16">mdi-checkbox-blank-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Supplies Category</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item
            style="text-decoration: none"
            class="pl-6"
            :to="'/auth/index'"
          >
            <v-list-item-icon>
              <v-icon size="16">mdi-checkbox-blank-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Products Category</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item
            style="text-decoration: none"
            class="pl-6"
            :to="'/auth/index'"
          >
            <v-list-item-icon>
              <v-icon size="16">mdi-checkbox-blank-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Products-Sub Category</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>

        <v-list-group no-action>
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon size="23">mdi-link</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title> Links</v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item class="pl-4 ml-4" :to="'/maps/googlemap'">
            <v-list-item-icon>
              <v-icon size="23">mdi-map</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title> Google Map</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item
            class="pl-4 ml-4"
            :to="'#'"
            onclick="window.open(`https://hazardhunter.georisk.gov.ph/#`,'_blank')"
          >
            <v-list-item-icon>
              <v-icon size="23">mdi-link</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title> HazardHunter.PH </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>

        <v-list-group no-action>
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon size="23">mdi-server-security</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title> Settings</v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item class="pl-4 ml-4" :to="'/auth/index'">
            <v-list-item-icon>
              <v-icon size="23">mdi-account-key</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title> Account </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item class="pl-4 ml-4" :to="'/auth/index'">
            <v-list-item-icon>
              <v-icon size="23">mdi-account-key</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title> Change Password </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item class="pl-4 ml-4" :to="'/auth/index'">
            <v-list-item-icon>
              <v-icon size="23">mdi-security</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title> Permissions </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>
      </v-list>
    </v-navigation-drawer>
  </div>
</template>
<style>
.coloroffont {
  color: blue;
}
</style>
<script>
export default {
  data() {
    return {
      drawer: true,
    };
  },
};
</script>