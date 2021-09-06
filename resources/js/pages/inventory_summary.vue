<template>
  <div style="min-width: 280px">
    <v-container>
      <v-layout row wrap>
        <h5 class="heading my-auto">Inventory</h5>
        <v-spacer></v-spacer>
        <v-card-actions class="px-0">
          <v-btn
            plain
            small
            v-ripple="false"
            to="/dashboard"
            class="px-0"
            style="text-decoration: none; text-transform: none; font-size: 11px"
            >Home</v-btn
          >
          /
          <v-btn
            small
            text
            disabled
            class="px-0"
            style="text-transform: none; font-size: 11px"
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
            :page.sync="page"
            :items-per-page="itemsPerPage"
            hide-default-footer
            @page-count="pageCount = $event"
          >
          </v-data-table>
          <div class="text-center pt-2">
            <v-pagination v-model="page" :length="pageCount"></v-pagination>
          </div>
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
    page: 1,
    pageCount: 0,
    itemsPerPage: 10,
  }),
};
</script>