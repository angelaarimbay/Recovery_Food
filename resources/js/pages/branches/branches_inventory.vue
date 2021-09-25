<template>
  <div style="min-width: 280px">
    <v-container>
      <v-layout row wrap>
        <h4
          class="font-weight-bold heading my-auto"
          :class="{ h5: $vuetify.breakpoint.smAndDown }"
        >
          Branches
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
            >Branches Inventory</v-btn
          >
        </v-card-actions>
      </v-layout>
    </v-container>

    <v-card elevation="6" class="mt-2" style="border-radius: 10px">
      <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
        <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
          <v-list dense nav class="px-0 py-1">
            <v-list-group no-action color="#757575">
              <template v-slot:activator>
                <v-list-item-icon class="mx-0">
                  <v-icon size="20">mdi-filter</v-icon>
                </v-list-item-icon>
                <v-list-item-title
                  style="color: #757575; font-weight: bold"
                  class="px-3"
                  >Search Filter</v-list-item-title
                >
              </template>

              <v-list class="p-0">
                <v-row no-gutters>
                  <!-- Items Per Page -->
                  <v-col cols="4" xl="2" lg="2" md="3" sm="4" class="my-auto">
                    <v-card-actions>
                      <v-select
                        style="max-width: 82px"
                        dense
                        v-model="itemsPerPage"
                        label="Items per page"
                        @change="itemperpage"
                        :items="[
                          1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15,
                        ]"
                      >
                      </v-select>
                    </v-card-actions>
                  </v-col>

                  <v-spacer></v-spacer>

                  <!-- Search Field -->
                  <v-col
                    cols="8"
                    xl="4"
                    lg="4"
                    md="6"
                    sm="8"
                    style="max-width: 230px"
                    class="my-auto"
                  >
                    <v-card-actions>
                      <v-text-field
                        v-model="search"
                        label="Supply Name"
                        single-line
                        dense
                        clearable
                      ></v-text-field>
                      <v-tooltip bottom>
                        <template #activator="data">
                          <v-btn
                            :small="$vuetify.breakpoint.smAndDown"
                            :large="$vuetify.breakpoint.mdAndUp"
                            color="red darken-2"
                            icon
                            v-on="data.on"
                            @click="get"
                            class="mb-3"
                          >
                            <v-icon>mdi-magnify</v-icon></v-btn
                          >
                        </template>
                        <span>Search</span>
                      </v-tooltip>
                    </v-card-actions>
                  </v-col>
                </v-row>

                <v-row no-gutters>
                  <!-- Branch Field -->
                  <v-col cols="6" xl="2" lg="2" md="2" sm="6" class="my-auto">
                    <v-card-actions class="py-0">
                      <v-select
                        :items="branchlist"
                        v-model="branch"
                        item-text="branch_name"
                        item-value="id"
                        class="my-0"
                        clearable
                        dense
                        @change="get"
                        label="Branch"
                      >
                      </v-select>
                    </v-card-actions>
                  </v-col>

                  <!-- Category Field -->
                  <v-col cols="6" xl="2" lg="2" md="2" sm="6" class="my-auto">
                    <v-card-actions class="py-0">
                      <v-select
                        :items="suppcatlist"
                        item-text="supply_cat_name"
                        item-value="id"
                        class="my-0"
                        v-model="category"
                        @change="get"
                        clearable
                        dense
                        label="Category"
                      >
                      </v-select>
                    </v-card-actions>
                  </v-col>

                  <v-spacer></v-spacer>

                  <!-- Date Picker -->
                  <v-col cols="6" xl="2" lg="3" md="3" sm="6" class="my-auto">
                    <v-card-actions class="py-0">
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
                            clearable
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          v-model="dateFrom"
                          @input="date1 = false"
                          scrollable
                          no-title
                          color="red darken-2"
                          dark
                        ></v-date-picker>
                      </v-menu>
                    </v-card-actions>
                  </v-col>

                  <v-col cols="6" xl="2" lg="3" md="3" sm="6" class="my-auto">
                    <v-card-actions class="py-0">
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
                            clearable
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          v-model="dateUntil"
                          @input="date2 = false"
                          scrollable
                          no-title
                          color="red darken-2"
                          dark
                        ></v-date-picker>
                      </v-menu>
                    </v-card-actions>
                  </v-col>
                </v-row>
              </v-list>
            </v-list-group>
          </v-list>

          <!-- Table -->
          <v-data-table
            :headers="headers"
            :items="table.data"
            :loading="progressbar"
            :page.sync="page"
            ref="progress"
            :items-per-page="itemsPerPage"
            hide-default-footer
            @page-count="pageCount = $event"
          >
            <!-- Progress Bar -->
            <v-progress-linear
              color="red darken-2"
              class="px-0 mx-0"
              slot="progress"
              indeterminate
              rounded
            ></v-progress-linear>
            <template v-slot:[`item.count`]="{ item }">
              {{ item.row }}</template
            >
            <template v-slot:[`item.id`]="{ item }">
              <v-btn
                icon
                color="red darken-2"
                @click="edit(item)"
                :x-small="$vuetify.breakpoint.smAndDown"
              >
                <v-icon>mdi-pencil</v-icon>
              </v-btn>
            </template>
          </v-data-table>

          <!-- Paginate -->
          <div class="text-center pt-2">
            <v-pagination
              v-model="page"
              :total-visible="5"
              :length="table.last_page"
              color="red darken-2"
            ></v-pagination>
          </div>
        </v-container>
      </v-container>
    </v-card>
  </div>
</template>

<style>
.v-pagination button {
  background-color: #212121 !important;
  color: #ffffff !important;
}
.v-pagination i.v-icon.v-icon {
  color: #ffffff !important;
}
.v-pagination__navigation:disabled {
  background-color: #000000 !important;
}
</style>

<script>
import { mapGetters } from "vuex";
import axios from "axios"; // Library for sending api request
export default {
  middleware: "auth",
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
  },
  data: () => ({
    progressbar: false,
    search: "",
    branch: "",
    category: "",
    loading: false,
    table: [],
    suppcatlist: [],
    branchlist: [],
    // Table Headers
    headers: [
      { text: "#", value: "count", align: "start", filterable: false },
      {
        text: "Branch",
        value: "requesting_branch.branch_name",
        filterable: false,
      },
      {
        text: "Category",
        value: "category.supply_cat_name",
        filterable: false,
      },
      {
        text: "Supply Name",
        value: "supply_name.supply_name",
      },
      {
        text: "Quantity",
        value: "quantity",
        align: "right",
      },
      {
        text: "Amount",
        value: "outgoing_amount",
        align: "right",
      },
    ],
    page: 1,
    pageCount: 0,
    itemsPerPage: 5,
    dateFrom: null,
    dateUntil: null,
    date1: false,
    date2: false,
  }),

  // Onload
  created() {
    if (this.user.permissionslist.includes("Access Branches")) {
      this.get();
      this.suppCat();
      this.branchName();
    } else {
      this.$router.push({ name: "invalid-page" }).catch((errr) => {});
    }
  },

  methods: {
    itemperpage() {
      this.page = 1;
      this.get();
    },

    async get() {
      this.progressbar = true;
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;
      await axios
        .get("api/branches/inventory/get", {
          params: {
            branch: this.branch,
            category: this.category,
            page: this.page,
            itemsPerPage: this.itemsPerPage,
            search: this.search,
          },
        })
        .then((result) => {
          this.table = result.data;
          this.progressbar = false;
        });
    },

    async suppCat() {
      await axios.get("api/msupp/suppCat").then((supp_cat) => {
        this.suppcatlist = supp_cat.data;
      });
    },

    async branchName() {
      await axios.get("api/osupp/branchName").then((bran_name) => {
        this.branchlist = bran_name.data;
      });
    },
  },
};
</script>