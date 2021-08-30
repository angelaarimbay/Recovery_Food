<template>
  <div style="min-width: 280px">
    <v-container>
      <v-layout row wrap>
        <h5 class="heading my-auto">Branches</h5>
        <v-spacer></v-spacer>
        <v-breadcrumbs class="p-1" :items="items"></v-breadcrumbs>
      </v-layout>
    </v-container>

<!-- kaw na mag lipat -->

  <v-list>
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
              to="/sett1"
            >
              <v-list-item-icon class="me-3">
                <v-icon size="16">mdi-circle</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Permissions</v-list-item-title>
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
              cols="6"
              xl="2"
              lg="2"
              md="4"
              sm="6"
              class="my-auto py-1 px-xl-2 px-lg-2 px-md-1 px-sm-1 px-1"
            >
              <v-combobox clearable dense label="Branch"> </v-combobox>
            </v-col>

            <v-col
              cols="6"
              xl="2"
              lg="2"
              md="4"
              sm="6"
              class="my-auto py-1 px-xl-2 px-lg-2 px-md-1 px-sm-1 px-1"
            >
              <v-combobox clearable dense label="Inventory"> </v-combobox>
            </v-col>

            <v-col
              cols="12"
              xl="2"
              lg="2"
              md="4"
              sm="12"
              class="my-auto py-1 px-xl-2 px-lg-2 px-md-1 px-sm-1 px-1"
            >
              <v-combobox clearable dense label="Category"> </v-combobox>
            </v-col>

            <v-spacer></v-spacer>

            <v-col
              cols="6"
              xl="2"
              lg="3"
              md="6"
              sm="6"
              class="my-auto py-2 px-xl-2 px-lg-2 px-md-1 px-sm-1 px-1"
            >
              <v-menu
                v-model="date1"
                :close-on-content-click="false"
                :nudge-right="35"
                lazy
                transition="scale-transition"
                offset-y
                full-width
                min-width="290px"
              >
                <template v-slot:activator="{ on }">
                  <v-text-field
                    v-model="dateFrom"
                    label="Date From"
                    prepend-icon="mdi-calendar-range"
                    readonly
                    v-on="on"
                    class="py-0"
                    dense
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="dateFrom"
                  @input="date1 = false"
                  scrollable
                ></v-date-picker>
              </v-menu>
            </v-col>

            <v-col
              cols="6"
              xl="2"
              lg="3"
              md="6"
              sm="6"
              class="my-auto py-2 px-xl-2 px-lg-2 px-md-1 px-sm-1 px-1"
            >
              <v-menu
                v-model="date2"
                :close-on-content-click="false"
                :nudge-right="35"
                lazy
                transition="scale-transition"
                offset-y
                full-width
                min-width="290px"
              >
                <template v-slot:activator="{ on }">
                  <v-text-field
                    v-model="dateUntil"
                    label="Date Until"
                    prepend-icon="mdi-calendar-range"
                    readonly
                    v-on="on"
                    class="py-0"
                    dense
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="dateUntil"
                  @input="date2 = false"
                  scrollable
                ></v-date-picker>
              </v-menu>
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
      { text: "Category", value: "category", filterable: false },
      { text: "Supply Name", value: "supply name" },
      { text: "Quantity", value: "quantity", filterable: false },
      { text: "Date Acquired", value: "date acquired", filterable: false },
    ],
    items: [
      {
        text: "Home",
        disabled: false,
        to: "/dashboard",
      },
      {
        text: "Branches Inventory",
        disabled: true,
      },
    ],
    dateFrom: new Date().toISOString().substr(0, 10),
    dateUntil: new Date().toISOString().substr(0, 10),
    date1: false,
    date2: false,
    search: "",
    page: 1,
    pageCount: 0,
    itemsPerPage: 10,
  }),
};
</script>