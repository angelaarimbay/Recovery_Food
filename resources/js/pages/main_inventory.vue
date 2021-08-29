<template>
  <div style="min-width: 280px">
    <v-container>
      <v-layout row wrap>
        <h5 class="heading my-auto">Inventory</h5>
        <v-spacer></v-spacer>
        <v-breadcrumbs class="p-1" :items="items"></v-breadcrumbs>
      </v-layout>
    </v-container>

    <v-card elevation="6" class="mt-2" style="border-radius: 10px">
      <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
        <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
          <v-row no-gutters>
            <v-col
              cols="12"
              xl="2"
              lg="2"
              md="3"
              sm="12"
              class="my-auto px-xl-2 px-lg-2 px-md-1 px-sm-1 px-1"
            >
              <v-text-field
                :value="itemsPerPage"
                label="Items per page"
                type="number"
                min="0"
                max="15"
                @input="itemsPerPage = parseInt($event, 10)"
              ></v-text-field>
            </v-col>

            <v-spacer></v-spacer>

            <v-col
              cols="12"
              xl="4"
              lg="4"
              md="5"
              sm="12"
              class="my-auto px-xl-2 px-lg-2 px-md-1 px-sm-1 px-1"
            >
              <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Supply Name"
                single-line
                hide-details
                dense
                clearable
                class="my-0 mb-4 mb-xl-0 mb-lg-0 mb-md-0 mb-sm-0"
              ></v-text-field>
            </v-col>
          </v-row>

          <v-row no-gutters>
            <v-col
              cols="12"
              xl="2"
              lg="2"
              md="3"
              sm="12"
              class="my-auto py-1 px-xl-2 px-lg-2 px-md-1 px-sm-1 px-1"
            >
              <v-combobox clearable dense label="Category"> </v-combobox>
            </v-col>
          </v-row>

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
      { text: "Supply Name", value: "supply name" },
      { text: "Description", value: "description", filterable: false },
      { text: "Unit", value: "unit", filterable: false },
      { text: "Net Price", value: "net price", filterable: false },
      { text: "Stocks On Hand", value: "stocks on hand", filterable: false },
      { text: "Actions", value: "actions", sortable: false, filterable: false},
    ],
    items: [
      {
        text: "Home",
        disabled: false,
        to: "/dashboard",
      },
      {
        text: "Main Inventory",
        disabled: true,
      },
    ],
    search: "",
    page: 1,
    pageCount: 0,
    itemsPerPage: 10,
  }),
};
</script>