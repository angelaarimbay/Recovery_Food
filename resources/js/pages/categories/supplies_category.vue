<template>
  <div style="min-width: 280px">
    <!-- Snackbar -->
    <v-snackbar
      :vertical="$vuetify.breakpoint.xsOnly"
      min-width="auto"
      v-model="snackbar.active"
      timeout="2500"
      :left="$vuetify.breakpoint.smAndUp"
      class="pb-0"
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
        <span
          class="
            text-h6 text-xl-h5 text-lg-h5 text-md-h6 text-sm-h6
            font-weight-bold
            my-auto
          "
        >
          Categories
        </span>
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
            >Supplies Category</v-btn
          >
        </v-card-actions>
      </v-layout>
    </v-container>

    <!-- Main Card -->
    <v-card elevation="6" class="mt-2" style="border-radius: 10px">
      <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
        <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
          <v-card-actions class="px-0">
            <v-row no-gutters>
              <v-btn
                color="primary"
                style="text-transform: none"
                depressed
                dark
                :small="$vuetify.breakpoint.smAndDown"
                class="mb-xl-2 mb-lg-2 mb-md-1 mb-sm-1 mb-1"
                @click="openDialog"
              >
                Add Supply Category
              </v-btn>
              <v-spacer></v-spacer>
              <v-tooltip bottom>
                <template #activator="data">
                  <v-btn
                    class="mr-2"
                    color="success"
                    style="text-transform: none"
                    depressed
                    :small="$vuetify.breakpoint.smAndDown"
                    dark
                    @click="get"
                    v-on="data.on"
                    icon
                    ><v-icon>mdi-refresh</v-icon></v-btn
                  >
                </template>
                <span>Refresh</span>
              </v-tooltip>
              <v-tooltip bottom>
                <template #activator="data">
                  <v-btn
                    color="grey darken-4"
                    style="text-transform: none"
                    depressed
                    :small="$vuetify.breakpoint.smAndDown"
                    dark
                    @click="filterDialog = true"
                    v-on="data.on"
                    icon
                    ><v-icon>mdi-filter-variant</v-icon></v-btn
                  >
                </template>
                <span>Filter</span>
              </v-tooltip>
            </v-row>

            <!-- Filter Dialog -->
            <v-dialog v-model="filterDialog" max-width="380px">
              <v-toolbar
                dense
                dark
                class="pl-xl-6 pl-lg-6 pl-md-6 pl-sm-5 pl-3 red darken-2"
              >
                Filter
                <v-spacer></v-spacer>
                <v-icon
                  class="mr-xl-4 mr-lg-4 mr-md-4 mr-sm-3 mr-1"
                  text
                  @click="filterDialog = false"
                  >mdi-close
                </v-icon>
              </v-toolbar>
              <v-card tile class="px-3 py-0 px-xl-6 px-lg-6">
                <v-row no-gutters align="center" class="pt-2">
                  <!-- Items Per Page -->
                  <v-col cols="4" class="pa-2">
                    <v-select
                      style="max-width: 82px"
                      dense
                      v-model="itemsPerPage"
                      label="Items per page"
                      @change="itemperpage"
                      :items="[
                        1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15,
                      ]"
                      hide-details
                    >
                    </v-select>
                  </v-col>

                  <v-spacer></v-spacer>

                  <!-- Search Field -->
                  <v-col cols="8">
                    <v-card-actions class="px-0">
                      <v-text-field
                        v-model="search"
                        label="Supply Category"
                        single-line
                        dense
                        clearable
                        hide-details
                      ></v-text-field>
                      <v-tooltip bottom>
                        <template #activator="data">
                          <v-btn
                            large
                            :small="$vuetify.breakpoint.smAndDown"
                            color="red darken-2"
                            icon
                            v-on="data.on"
                            @click="get"
                            class="mt-2"
                          >
                            <v-icon>mdi-magnify</v-icon></v-btn
                          >
                        </template>
                        <span>Search</span>
                      </v-tooltip>
                    </v-card-actions>
                  </v-col>
                </v-row>
              </v-card>
            </v-dialog>
          </v-card-actions>

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
            class="table-striped"
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
            <template v-slot:[`item.status`]="{ item }">
              <v-chip
                style="justify-content: center"
                :style="widthSize"
                :small="$vuetify.breakpoint.smAndDown"
                :color="
                  item.status == '1'
                    ? '#43A047'
                    : item.status == '0'
                    ? '#FF6F00'
                    : ''
                "
                dark
              >
                {{ item.status == 1 ? "Active" : "Inactive" }}
              </v-chip>
            </template>
            <template v-slot:[`item.id`]="{ item }">
              <v-tooltip bottom>
                <template #activator="data">
                  <v-btn
                    icon
                    color="red darken-2"
                    @click="edit(item)"
                    small
                    :x-small="$vuetify.breakpoint.smAndDown"
                    v-on="data.on"
                  >
                    <v-icon>mdi-pencil</v-icon>
                  </v-btn>
                </template>
                <span>Edit</span>
              </v-tooltip>
            </template>
          </v-data-table>

          <!-- Paginate -->
          <div class="text-center pt-2">
            <v-pagination
              v-model="page"
              :total-visible="7"
              :length="table.last_page"
              color="red darken-2"
            ></v-pagination>
          </div>
        </v-container>

        <!--Dialog Form-->
        <v-form ref="form">
          <v-dialog
            v-model="dialog"
            max-width="450px"
            persistent
            no-click-animation
          >
            <v-toolbar
              dense
              dark
              class="pl-xl-6 pl-lg-6 pl-md-6 pl-sm-5 pl-3 red darken-2"
            >
              Supply Category
              <v-spacer></v-spacer>
              <v-icon
                class="mr-xl-4 mr-lg-4 mr-md-4 mr-sm-3 mr-1"
                text
                @click="cancel"
                >mdi-close
              </v-icon>
            </v-toolbar>
            <v-card tile>
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
                      <v-text-field v-model="form.id" class="d-none" dense>
                        <template slot="label">
                          <div style="font-size: 14px">ID</div>
                        </template>
                      </v-text-field>

                      <v-select
                        :rules="formRulesNumberRange"
                        v-model="form.status"
                        outlined
                        dense
                        :items="status"
                        item-text="name"
                        item-value="id"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">
                            Status <span style="color: red">*</span>
                          </div>
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
                        v-model="form.supply_cat_name"
                        outlined
                        clearable
                        dense
                        counter
                        @keydown="valueKeydown($event)"
                        maxlength="25"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">
                            Supply Category <span style="color: red">*</span>
                          </div>
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
import { mapGetters } from "vuex";
import axios from "axios"; // Library for sending api request
export default {
  middleware: "auth",
  metaInfo() {
    return { title: "Categories" };
  },
  data: () => ({
    progressbar: false,
    snackbar: {
      active: false,
      message: "",
    },
    search: "",
    button: false,
    dialog: false,
    filterDialog: false,
    status: [
      { name: "Active", id: 1 },
      { name: "Inactive", id: 0 },
    ],
    table: [],

    // Form Rules
    formRules: [
      (v) => (!!v && v.length >= 3) || "This is required",
      (v) =>
        /^(?:([A-Za-z])(?!\1{2})|([0-9])(?!\2{7})|([\s,'-_/])(?!\3{1}))+$/i.test(
          v
        ) || "This field must have a valid value",
    ],
    formRulesNumberRange: [
      (v) => {
        if (!isNaN(parseFloat(v)) && v >= 0 && v <= 1) return true;
        return "This is required";
      },
    ],

    // Form Data
    form: {
      id: null,
      status: null,
      supply_cat_name: null,
    },

    // For comparing data
    currentdata: {},

    // Table Headers
    headers: [
      {
        text: "#",
        value: "count",
        align: "start",
        filterable: false,
        class: "black--text",
        width: "12%",
      },
      {
        text: "SUPPLY CATEGORY",
        value: "supply_cat_name",
        class: "black--text",
      },
      {
        text: "STATUS",
        value: "status",
        align: "center",
        filterable: false,
        class: "black--text",
        width: "20%",
      },
      {
        text: "ACTION(S)",
        value: "id",
        align: "center",
        sortable: false,
        filterable: false,
        class: "black--text",
        width: "20%",
      },
    ],
    page: 1,
    pageCount: 0,
    itemsPerPage: 5,
  }),

  // Dynamic Width
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
    widthSize() {
      switch (this.$vuetify.breakpoint.name) {
        case "xs":
          return { width: "65px" };
        case "sm":
          return { width: "65px" };
        default:
          return { width: "72px" };
      }
    },
  },

  // Onload
  created() {
    if (this.user.permissionslist.includes("Access Categories")) {
      this.get();
    } else {
      this.$router.push({ name: "invalid-page" }).catch((errr) => {});
    }
  },

  methods: {
    valueKeydown(e) {
      if (/[~`!@#$%^&()_={}[\]\\"*|:;.<>+\?]/.test(e.key)) {
        e.preventDefault();
      }
    },

    itemperpage() {
      this.page = 1;
      this.get();
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
          found += 1;
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
            .post("/api/supplies/save", this.form)
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
                    message: "The supply category already exists.",
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
        .get("/api/supplies/get", {
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

    // Editing/updating of row
    edit(row) {
      this.currentdata = JSON.parse(JSON.stringify(row));
      this.form.id = row.id;
      this.form.status = row.status;
      this.form.supply_cat_name = row.supply_cat_name;
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
