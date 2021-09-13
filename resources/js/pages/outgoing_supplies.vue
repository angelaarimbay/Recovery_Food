<template>
  <div style="min-width: 280px">
    <!-- Snackbar -->
    <v-snackbar
      :vertical="$vuetify.breakpoint.xsOnly"
      min-width="auto"
      v-model="snackbar.active"
      timeout="2500"
    >
      <span
        ><v-icon :color="snackbar.iconColor">{{
          `mdi-${snackbar.iconText}`
        }}</v-icon></span
      >
      {{ snackbar.message }}
      <template v-slot:action="{ attrs }">
        <v-btn
          :small="$vuetify.breakpoint.smAndDown"
          v-bind="attrs"
          color="primary"
          text
          @click="snackbar.active = false"
          >Close</v-btn
        >
      </template>
    </v-snackbar>

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
            >Outgoing Supplies</v-btn
          >
        </v-card-actions>
      </v-layout>
    </v-container>

    <!-- Main Card -->
    <v-card elevation="6" class="mt-2" style="border-radius: 10px">
      <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
        <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
          <v-card-actions class="pl-0">
            <v-btn
              color="primary"
              style="text-transform: none"
              depressed
              dark
              :small="$vuetify.breakpoint.smAndDown"
              class="mb-xl-2 mb-lg-2 mb-md-1 mb-sm-1 mb-1"
              @click="openDialog"
            >
              Add Outgoing Supply
            </v-btn>
          </v-card-actions>

          <!-- Search Filters -->
          <v-list dense nav class="px-0 py-0">
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
                  <v-col cols="6" xl="2" lg="2" md="3" sm="6" class="my-auto">
                    <v-card-actions class="py-0">
                      <v-select
                        :items="branchlist"
                        item-text="branch_name"
                        item-value="id"
                        class="my-0"
                        clearable
                        dense
                        label="Branch"
                      >
                      </v-select>
                    </v-card-actions>
                  </v-col>

                  <!-- Category Field -->
                  <v-col cols="6" xl="2" lg="2" md="3" sm="6" class="my-auto">
                    <v-card-actions class="py-0">
                      <v-select
                        :items="suppcatlist"

                        item-text="supply_cat_name"
                        item-value="id"
                        class="my-0"
                        clearable
                        dense
                        label="Category"
                      >
                      </v-select>
                    </v-card-actions>
                  </v-col>

                  <v-spacer></v-spacer>

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
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          v-model="dateFrom"
                          @input="date1 = false"
                          scrollable
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
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          v-model="dateUntil"
                          @input="date2 = false"
                          scrollable
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
            <template v-slot:[`item.created_at`]="{ item }">
              {{ getFormatDate(item.created_at, "MM/DD/YYYY") }}</template
            >
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

        <!--Dialog Form-->
        <v-form ref="form">
          <v-dialog v-model="dialog" max-width="450px">
            <v-toolbar
              dense
              dark
              class="pl-xl-6 pl-lg-6 pl-md-6 pl-sm-5 pl-3 red darken-2"
            >
              Outgoing Supply
            </v-toolbar>
            <v-card tile style="background-color: #f5f5f5">
              <v-card-text class="py-2">
                <br />
                <v-container class="pa-xl-3 pa-lg-3 pa-md-2 pa-sm-0 pa-0">
                  <v-row>
                    <v-col
                      class="py-0"
                      cols="12"
                      xl="12"
                      lg="12"
                      sm="12"
                      md="12"
                    >
                      <v-select
                        :rules="formRulesNumber"
                        v-model="form.requesting_branch"
                        :items="branchlist"
                        outlined
                        dense
                        item-text="branch_name"
                        item-value="id"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Requesting Branch *</div>
                        </template>
                      </v-select>
                    </v-col>

                    <v-col
                      class="py-0"
                      cols="12"
                      xl="12"
                      lg="12"
                      sm="12"
                      md="12"
                    >
                      <v-select
                        :rules="formRulesNumber"
                        v-model="form.category"
                        :items="suppcatlist"
                        outlined
                        dense
                        item-text="supply_cat_name"
                        item-value="id"
                        @change="suppName"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Supply Category *</div>
                        </template>
                      </v-select>
                    </v-col>

                    <v-col
                      class="py-0"
                      cols="12"
                      xl="12"
                      lg="12"
                      sm="12"
                      md="12"
                    >
                      <v-select
                        :rules="formRulesNumber"
                        v-model="form.supply_name"
                        :items="suppnamelist"
                        outlined
                        dense
                        item-text="supply_name"
                        item-value="id"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Supply Name *</div>
                        </template>
                      </v-select>
                    </v-col>

                    <v-col
                      class="py-0"
                      cols="12"
                      xl="12"
                      lg="12"
                      sm="12"
                      md="12"
                    >
                      <v-text-field
                        :rules="formRules"
                        v-model="form.quantity"
                        outlined
                        clearable
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Supply Quantity *</div>
                        </template>
                      </v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>

              <!-- Dialog Form Buttons -->
              <v-card-actions class="px-xl-9 px-lg-9 px-md-8 px-sm-6 px-6 py-4">
                <v-spacer></v-spacer>
                <v-btn
                  color="error"
                  depressed
                  :disabled="button"
                  dark
                  @click="cancel"
                  style="text-transform: none"
                  :small="$vuetify.breakpoint.smAndDown"
                >
                  Cancel
                </v-btn>
                <v-btn
                  color="primary"
                  depressed
                  :disabled="button"
                  dark
                  @click="save"
                  style="text-transform: none"
                  :small="$vuetify.breakpoint.smAndDown"
                >
                  Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-form>
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
import axios from "axios"; // Library for sending api request
export default {
  data: () => ({
    progressbar: false,
    snackbar: {
      active: false,
      message: "",
    },
    search: "",
    button: false,
    dialog: false,
    table: [],
    suppcatlist: [],
    suppnamelist: [],
    branchlist: [],

    // Form Rules
    formRules: [(v) => !!v || "This is required"],
    formRulesNumberRange: (v) => {
      if (!isNaN(parseFloat(v)) && v >= 1 && v <= 100) return true;
      return "Number has to be between 1% and 100%";
    },
    formRulesNumber: [
      (v) => Number.isInteger(Number(v)) || "The value must be an integer",
    ],

    // Form Data
    form: {
      category: null,
      supply_name: null,
      quantity: null,
      requesting_branch: null,
    },

    // For comparing data
    currentdata: {},

    // Table Headers
    headers: [
      { text: "#", value: "count", align: "start", filterable: false },
      {
        text: "Category",
        value: "category.supply_cat_name",
        filterable: false,
      },
      { text: "Supply Name", value: "supply_name.supply_name" },
      {
        text: "Quantity",
        value: "quantity",
        align: "right",
        filterable: false,
      },
      {
        text: "Amount",
        value: "outgoing_amount",
        align: "right",
        filterable: false,
      },
      {
        text: "Branch",
        value: "requesting_branch.branch_name",
        filterable: false,
      },
      { text: "Date", value: "created_at", align: "right", filterable: false },
      { text: "Actions", value: "id", align: "center", sortable: false, filterable: false },
    ],
    page: 1,
    pageCount: 0,
    itemsPerPage: 5,
    dateFrom: new Date().toISOString().substr(0, 10),
    dateUntil: new Date().toISOString().substr(0, 10),
    date1: false,
    date2: false,
  }),

  // Onload
  created() {
    this.get();
    this.suppCat();
    this.branchName();
  },

  methods: {
    itemperpage() {
      this.page = 1;
      this.get();
    },

    getFormatDate(e, format) {
      const date = moment(e);
      return date.format(format);
    },

    // Format for everytime we call on database
    // Always add await and async
    compare() {
      // Compare exsiting data vs edited data
      // If nothing change then no request
      if (!this.currentdata) {
        return true;
      }
      // Check if not existed
      // Check each value if the same or not
      var found = 0;
      for (var key in this.form) {
        if (this.currentdata[key] != this.form[key]) {
          if (key == "category") {
            if (this.currentdata.category) {
              if (this.currentdata.category.id != this.form.category) {
                found += 1;
              }
            }
          } else if (key == "supply_name") {
            if (this.currentdata.supply_name) {
              if (this.currentdata.supply_name.id != this.form.supply_name) {
                found += 1;
              }
            }
          } else if (key == "requesting_branch") {
            if (this.currentdata.requesting_branch) {
              if (
                this.currentdata.requesting_branch.id !=
                this.form.requesting_branch
              ) {
                found += 1;
              }
            }
          } else {
            found += 1;
          }
        }
      }
      //if has changes
      if (found > 0) {
        return true;
      } else {
        this.snackbar = {
          active: true,
          iconText: "alert-box",
          iconColor: "warning",
          message: "No changes has been made.",
        };
        this.cancel();
      }
    },

    // Saving data to database
    async save() {
      if (this.$refs.form.validate()) {
        // Validate first before compare
        if (this.compare()) {
          // Save or update data in the table
          await axios
            .post("api/osupp/save", this.form)
            .then((result) => {
              //if the value is true then save to database
              switch (result.data) {
                case 0:
                  this.snackbar = {
                    active: true,
                    iconText: "check",
                    iconColor: "success",
                    message: "Successfully saved.",
                  };
                  this.get();
                  this.cancel();
                  break;
                case 1:
                  this.snackbar = {
                    active: true,
                    iconText: "alert",
                    iconColor: "error",
                    message: "The supply name already exists.",
                  };
                  break;
                default:
                  break;
              }
            })
            .catch((result) => {
              // If false or error when saving
            });
        }
      }
    },
    async get() {
      this.progressbar = true; // Show the progress bar
      // Get data from tables
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;
      await axios
        .get("api/osupp/get", {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,
            search: this.search,
          },
        })
        .then((result) => {
          // If the value is true then get the data
          this.table = result.data;
          this.progressbar = false; // Hide the progress bar
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    async suppCat() {
      await axios.get("api/osupp/suppCat").then((supp_cat) => {
        this.suppcatlist = supp_cat.data;
      });
    },

    async suppName() {
      await axios
        .get("api/osupp/suppName", { params: { category: this.form.category } })
        .then((supp_name) => {
          this.suppnamelist = supp_name.data;
        });
    },

    async branchName() {
      await axios.get("api/osupp/branchName").then((bran_name) => {
        this.branchlist = bran_name.data;
      });
    },

    // Editing/updating of row
    edit(row) {
      this.currentdata = JSON.parse(JSON.stringify(row));
      this.form.id = row.id;
      this.form.category = row.category.id;
      this.suppName();
      this.form.supply_name = row.supply_name.id;
      this.form.quantity = row.quantity;
      this.form.requesting_branch = row.requesting_branch.id;

      this.dialog = true;
    },

    // Open Dialog Form
    openDialog() {
      this.$refs.form.reset();
      this.dialog = true;
    },

    // Reset Forms
    cancel() {
      this.$refs.form.reset();
      this.dialog = false;
    },
  },

  watch: {
    dialog(val) {
      val || this.cancel();
    },
    page(val) {
      this.page = val;
      this.get();
    },
    id: {
      handler: function (v) {},
    },
  },
};
</script>