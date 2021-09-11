<template>
  <div style="min-width: 280px">
    <v-container>
      <v-layout row wrap>
        <h4
          class="font-weight-bold heading my-auto"
          :class="{ h5: $vuetify.breakpoint.smAndDown }"
        >
          Inventory
        </h4>
        <v-spacer></v-spacer>

        <!-- Breadcrumbs -->
        <v-card-actions class="px-0 py-0">
          <v-btn
            :small="$vuetify.breakpoint.smAndDown"
            plain
            color="primary"
            v-ripple="false"
            to="/dashboard"
            class="px-0"
            style="text-decoration: none; text-transform: none"
            >Home</v-btn
          >
          /
          <v-btn
            :small="$vuetify.breakpoint.smAndDown"
            text
            disabled
            class="px-0"
            style="text-transform: none"
            >Inventory Summary</v-btn
          >
        </v-card-actions>
      </v-layout>
    </v-container>

    <v-card elevation="6" class="mt-2" style="border-radius: 10px">
      <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
        <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
          <v-data-table
            :headers="headers"
            :data="table"
            hide-default-footer
          >
          </v-data-table>
        </v-container>
      </v-container>
    </v-card>
  </div>
</template>

<script>
export default {
  data: () => ({
    table: [],
    headers: [
      { text: "#", value: "#", align: "start", filterable: false },
      { text: "Category", value: "supply category", filterable: false },
      {
        text: "Beginning Inventory",
        value: "beginning inventory",
        filterable: false,
      },
      { text: "Purchases", value: "purchases", filterable: false },
      { text: "Total Inventory", value: "total inventory", filterable: false },
      {
        text: "Outgoing Supplies",
        value: "outgoing supplies",
        filterable: false,
      },
      { text: "Stocks On Hand", value: "stocks on hand", filterable: false },
      {
        text: "Ending Inventory",
        value: "ending inventory",
        filterable: false,
      },
      {
        text: "Variance",
        value: "variance",
        sortable: false,
        filterable: false,
      },
      {
        text: "Fluctuation Impact",
        value: "fluctuation impact",
        filterable: false,
      },
    ],
    search: "",
  }),
};
</script>