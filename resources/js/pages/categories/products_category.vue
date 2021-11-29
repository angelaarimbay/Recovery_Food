<template>
  <!-- Div -->
  <div style="min-width: 310px">
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
            >Products Category</v-btn
          >
        </v-card-actions>
      </v-layout>
    </v-container>

    <!-- Main Card -->
    <v-card elevation="1" class="mt-2" style="border-radius: 10px">
      <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
        <v-card-actions class="px-0">
          <v-row align="center" no-gutters>
            <!-- Add Button -->
            <v-btn
              color="primary"
              style="text-transform: none"
              depressed
              dark
              :small="$vuetify.breakpoint.smAndDown"
              @click="openDialog"
            >
              Add Product Category
            </v-btn>
            <v-spacer></v-spacer>
            <v-card color="red darken-3" flat style="border-radius: 20px">
              <!-- Refresh -->
              <v-tooltip bottom>
                <template #activator="data">
                  <v-btn
                    class="mr-2"
                    color="white"
                    depressed
                    :small="$vuetify.breakpoint.smAndDown"
                    dark
                    @click="refresh"
                    v-on="data.on"
                    icon
                    ><v-icon size="20">mdi-refresh</v-icon></v-btn
                  >
                </template>
                <span>Refresh</span>
              </v-tooltip>
              <!-- Filter -->
              <v-tooltip bottom>
                <template #activator="data">
                  <v-btn
                    color="white"
                    depressed
                    :small="$vuetify.breakpoint.smAndDown"
                    dark
                    @click="filterDialog = true"
                    v-on="data.on"
                    icon
                    ><v-icon size="20">mdi-filter-variant</v-icon></v-btn
                  >
                </template>
                <span>Filter</span>
              </v-tooltip>
            </v-card>
          </v-row>

          <!-- Filter Dialog -->
          <v-dialog v-model="filterDialog" max-width="400px">
            <v-card dark tile class="pa-2">
              <v-toolbar dense flat class="transparent">
                Search Filter
                <v-spacer></v-spacer>
                <v-icon text @click="filterDialog = false">mdi-close </v-icon>
              </v-toolbar>
              <v-divider class="my-0"></v-divider>
              <v-row no-gutters align="center" class="pa-2">
                <!-- Items Per Page -->
                <v-col cols="4"
                  ><span class="text-caption text-xl-subtitle-2"
                    >Items / Page</span
                  ></v-col
                >
                <v-col cols="8">
                  <v-card-actions class="px-0">
                    <v-select
                      dense
                      v-model="itemsPerPage"
                      @change="itemperpage"
                      :items="[5, 10, 15, 20]"
                      hide-details
                      background-color="grey darken-3"
                      flat
                      solo
                      style="font-size: 12px"
                    >
                    </v-select>
                  </v-card-actions>
                </v-col>

                <!-- Search Field -->
                <v-col cols="4"
                  ><span class="text-caption text-xl-subtitle-2"
                    >Search</span
                  ></v-col
                >
                <v-col cols="8">
                  <v-card-actions class="px-0">
                    <v-text-field
                      v-model="search"
                      placeholder="Product Category"
                      single-line
                      dense
                      clearable
                      hide-details
                      background-color="grey darken-3"
                      flat
                      solo
                      style="font-size: 12px"
                    ></v-text-field>
                    <v-tooltip bottom>
                      <template #activator="data">
                        <v-btn
                          small
                          :x-small="$vuetify.breakpoint.smAndDown"
                          color="red darken-2"
                          icon
                          v-on="data.on"
                          @click="get"
                          class="ml-1"
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
          id="table1"
          :headers="headers"
          :items="table.data"
          :loading="progressbar"
          :page.sync="page"
          ref="progress"
          :items-per-page="itemsPerPage"
          hide-default-footer
          @page-count="pageCount = $event"
          class="table-striped border mt-2"
        >
          <!-- Progress Bar -->
          <v-progress-linear
            color="red darken-2"
            class="px-0 mx-0"
            slot="progress"
            indeterminate
            rounded
          ></v-progress-linear>

          <template v-slot:[`item.count`]="{ item }"> {{ item.row }}</template>
          <template v-slot:[`item.status`]="{ item }">
            <v-chip
              style="justify-content: center"
              small
              :x-small="$vuetify.breakpoint.smAndDown"
              :color="
                item.status == '1'
                  ? '#43A047'
                  : item.status == '0'
                  ? '#FF6F00'
                  : ''
              "
              dark
            >
              {{ item.status == 1 ? "Available" : "Unavailable" }}
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
        <div
          class="pbutton text-center pt-7 pb-xl-4 pb-lg-4 pb-md-4 pb-sm-3 pb-3"
        >
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
          <v-card tile class="pa-3">
            <v-toolbar dark dense flat rounded class="red darken-3">
              Product Category
              <v-spacer></v-spacer>
              <v-icon text @click="cancel">mdi-close </v-icon>
            </v-toolbar>
            <v-container class="px-1">
              <v-row class="py-4">
                <v-col
                  class="tfield py-0"
                  cols="12"
                  xl="12"
                  lg="12"
                  sm="12"
                  md="12"
                >
                  <v-text-field v-model="form.id" class="d-none" dense>
                    <template slot="label">
                      <div style="font-size: 12px">ID</div>
                    </template>
                  </v-text-field>

                  <v-select
                    :rules="formRulesNumberRange"
                    v-model="form.status"
                    dense
                    :items="status"
                    item-text="name"
                    item-value="id"
                    background-color="white"
                    flat
                    solo
                    style="font-size: 12px"
                  >
                    <template slot="label">
                      <div style="font-size: 12px">
                        Status <span style="color: red">*</span>
                      </div>
                    </template>
                  </v-select>
                </v-col>

                <v-col
                  class="tfield py-0"
                  cols="12"
                  xl="12"
                  lg="12"
                  sm="12"
                  md="12"
                >
                  <v-text-field
                    :rules="formRules"
                    v-model="form.product_cat_name"
                    clearable
                    dense
                    counter
                    @keydown="valueKeydown($event)"
                    maxlength="25"
                    background-color="white"
                    flat
                    solo
                    style="font-size: 12px"
                  >
                    <template slot="label">
                      <div style="font-size: 12px">
                        Product Category <span style="color: red">*</span>
                      </div>
                    </template>
                  </v-text-field>
                </v-col>
              </v-row>
            </v-container>
            <v-divider class="my-0"></v-divider>
            <!-- Dialog Form Buttons -->
            <v-card-actions class="px-0 pb-0 pt-3">
              <v-spacer></v-spacer>
              <v-btn
                color="grey"
                depressed
                :disabled="button"
                dark
                @click="cancel"
                :small="$vuetify.breakpoint.smAndDown"
                outlined
              >
                <span style="color: #1976d2">Cancel</span>
              </v-btn>
              <v-btn
                color="primary"
                depressed
                :disabled="button"
                dark
                @click="save"
                :small="$vuetify.breakpoint.smAndDown"
              >
                Save
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-form>
    </v-card>
  </div>
</template>

<!-- Style -->
<style>
.container {
  max-width: 1500px !important;
}

#table1 .v-data-table-header th {
  white-space: nowrap;
}
#table1 .v-data-table-header th {
  font-size: 12px !important;
  text-align: center !important;
}
#table1 td {
  font-size: 12px !important;
}

.pbutton .v-pagination button {
  background-color: #212121 !important;
  color: #ffffff !important;
  margin: 2px;
  height: 30px;
}
.pbutton .v-pagination i.v-icon.v-icon {
  color: #ffffff !important;
}
.pbutton .v-pagination__navigation:disabled {
  background-color: #000000 !important;
  height: 30px;
}

.v-application .tfield .white {
  border: 1px solid #bdbdbd !important;
}
.tfield .v-input--is-focused .v-input__slot {
  border: 1px solid #42a5f5 !important;
}

.v-list-item__content {
  color: white !important;
}
.v-menu__content.theme--light .v-list {
  background: #212121 !important;
}
.theme--light.v-list-item:hover:before {
  opacity: 0.2 !important;
}
</style>

<!-- Script -->
<script>
import { mapGetters } from "vuex";
import axios from "axios"; // Library for sending api request
export default {
  middleware: "auth",
  metaInfo() {
    return { title: "Categories" };
  },
  //Data
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
      { name: "Available", id: 1 },
      { name: "Unavailable", id: 0 },
    ],
    progressBar: false,
    table: [],

    //Form Rules
    formRules: [
      (v) => (!!v && v.length >= 3) || "This is required",
      (v) =>
        /^(?:([A-Za-z])(?!\1{2})|([0-9])(?!\2{7})|([\s,'-_/&+])(?!\3{1}))+$/i.test(
          v
        ) || "This field must have a valid value",
    ],
    formRulesNumberRange: [
      (v) => {
        if (!isNaN(parseFloat(v)) && v >= 0 && v <= 1) return true;
        return "This is required";
      },
    ],

    //Form Data
    form: {
      id: null,
      status: null,
      product_cat_name: null,
    },

    //For comparing data
    currentdata: {},

    //Table Headers
    headers: [
      {
        text: "#",
        value: "count",
        align: "right",
        filterable: false,
        class: "black--text",
        sortable: false,
      },
      {
        text: "PRODUCT CATEGORY",
        value: "product_cat_name",
        class: "black--text",
      },
      {
        text: "STATUS",
        value: "status",
        filterable: false,
        class: "black--text",
      },
      {
        text: "ACTION",
        value: "id",
        align: "center",
        sortable: false,
        filterable: false,
        class: "black--text",
      },
    ],
    page: 1,
    pageCount: 0,
    itemsPerPage: 10,
  }),

  //Computed
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
  },

  //Onload
  created() {
    if (this.user.permissionslist.includes("Access Categories")) {
      this.get();
    } else {
      this.$router.push({ name: "invalid-page" }).catch((errr) => {});
    }
  },

  //Methods
  methods: {
    //Keydown
    valueKeydown(e) {
      if (/[~`!@#$%^()_={}[\]\\"*|:;.<>\?]/.test(e.key)) {
        e.preventDefault();
      }
    },
    itemperpage() {
      this.page = 1;
      this.get();
    },

    //Format for everytime we call on database
    //Always add await and async
    compare() {
      //Compare exsiting data vs edited data
      //If nothing change then no request
      if (!this.currentdata) {
        return true;
      }
      //Check if not existed
      //Check each value if the same or not
      var found = 0;
      for (var key in this.form) {
        if (this.currentdata[key] != this.form[key]) {
          found += 1;
        }
      }
      //If has changes
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

    //Saving data to database
    async save() {
      if (this.$refs.form.validate()) {
        //Validate first before compare
        if (this.compare()) {
          //Save or update data in the table
          await axios
            .post("/api/products/save", this.form)
            .then((result) => {
              //If the value is true then save to database
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
              //If false or error when saving
            });
        }
      }
    },

    //For retrieving product categories
    async get() {
      this.progressbar = true; //Show the progress bar
      //Get data from tables
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;
      await axios
        .get("/api/products/get", {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,
            search: this.search,
          },
        })
        .then((result) => {
          //If the value is true then get the data
          this.table = result.data;
          this.progressbar = false; //Hide the progress bar
        })
        .catch((result) => {
          //If false or error when saving
        });
    },

    //Editing/updating of row
    edit(row) {
      this.currentdata = JSON.parse(JSON.stringify(row));
      this.form.id = row.id;
      this.form.status = row.status;
      this.form.product_cat_name = row.product_cat_name;
      this.dialog = true;
    },

    //Open Dialog Form
    openDialog() {
      this.$refs.form.reset();
      this.dialog = true;
    },

    //Reset Forms
    cancel() {
      this.$refs.form.reset();
      this.dialog = false;
    },

    //For refresh
    refresh() {
      this.get();
    },
  },

  //Watch
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
