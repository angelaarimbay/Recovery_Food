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
        <span
          class="
            text-h6 text-xl-h5 text-lg-h5 text-md-h6 text-sm-h6
            font-weight-bold
            my-auto
          "
        >
          Products
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
            >Incoming Products</v-btn
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
              @click="dialog = true"
            >
              Add Incoming Product
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
                        label="Product Name"
                        single-line
                        dense
                        clearable
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

                <!-- Category Field -->
                <v-row no-gutters>
                  <v-col cols="12" xl="2" lg="2" md="3" sm="12" class="my-auto">
                    <v-card-actions class="py-0">
                      <v-select
                        v-model="category"
                        :items="prodcatlist"
                        item-text="product_cat_name"
                        item-value="id"
                        class="my-0"
                        clearable
                        dense
                        label="Category"
                        @change="get"
                      >
                      </v-select>
                    </v-card-actions>
                  </v-col>

                  <v-spacer></v-spacer>

                  <!-- Date Picker -->
                  <v-col cols="6" xl="2" lg="3" md="4" sm="6" class="my-auto">
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
                          @change="get"
                        ></v-date-picker>
                      </v-menu>
                    </v-card-actions>
                  </v-col>

                  <v-col cols="6" xl="2" lg="3" md="4" sm="6" class="my-auto">
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
                          @change="get"
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
            <template v-slot:[`item.product_name.product_name`]="{ item }"
              >{{ item.product_name.product_name }}
              {{ item.product_name.description }}</template
            >
            <template v-slot:[`item.incoming_date`]="{ item }">
              {{ getFormatDate(item.incoming_date, "YYYY-MM-DD") }}</template
            >
            <template v-slot:[`item.count`]="{ item }">
              {{ item.row }}</template
            >
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

        <!-- Dialog Form -->
        <v-form ref="form">
          <v-dialog v-model="dialog" max-width="450px">
            <v-toolbar
              dense
              dark
              class="pl-xl-6 pl-lg-6 pl-md-6 pl-sm-5 pl-3 red darken-2"
            >
              Incoming Product
              <v-spacer></v-spacer>
              <v-tooltip bottom>
                <template #activator="data">
                  <v-icon
                    class="mr-xl-4 mr-lg-4 mr-md-4 mr-sm-3 mr-1"
                    v-on="data.on"
                    text
                    @click="cancel"
                    >mdi-close
                  </v-icon>
                </template>
                <span>Close</span>
              </v-tooltip>
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
                      <v-text-field v-model="form.id" class="d-none" dense>
                        <template slot="label">
                          <div style="font-size: 14px">ID</div>
                        </template>
                      </v-text-field>

                      <v-menu
                        v-model="date3"
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
                            :rules="formRules"
                            v-model="form.incoming_date"
                            label="Incoming Date *"
                            readonly
                            v-on="on"
                            class="py-0"
                            dense
                            clearable
                            outlined
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          v-model="form.incoming_date"
                          @input="date3 = false"
                          scrollable
                          no-title
                          color="red darken-2"
                          dark
                        ></v-date-picker>
                      </v-menu>
                    </v-col>

                    <v-col class="py-0" cols="12" xl="6" lg="6" sm="6" md="6">
                      <v-select
                        :rules="formRulesNumberRange"
                        v-model="form.category"
                        :items="prodcatlist"
                        outlined
                        dense
                        item-text="product_cat_name"
                        item-value="id"
                        @change="prodName"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Product Category *</div>
                        </template>
                      </v-select>
                    </v-col>

                    <v-col class="py-0" cols="12" xl="6" lg="6" sm="6" md="6">
                      <v-select
                        :rules="formRulesNumberRange"
                        v-model="form.sub_category"
                        :items="prodsubcatlist"
                        outlined
                        dense
                        item-text="prod_sub_cat_name"
                        item-value="id"
                        @change="prodName"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Sub Category *</div>
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
                      <v-autocomplete
                        :rules="formRules"
                        v-model="form.product_name"
                        :items="prodnamelist"
                        item-text="product_name"
                        return-object
                        outlined
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Product Name *</div>
                        </template>
                      </v-autocomplete>
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
                        :rules="formRulesQuantity"
                        v-model="form.quantity"
                        outlined
                        clearable
                        dense
                        @keyup="quantityKeydown($event)"
                        counter
                        maxlength="3"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Quantity *</div>
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
    return { title: "Products" };
  },
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
  },
  data: () => ({
    progressbar: false,
    snackbar: {
      active: false,
      message: "",
    },
    search: "",
    category: "",
    button: false,
    dialog: false,
    sheet: false,
    table: [],
    prodcatlist: [],
    prodsubcatlist: [],
    prodnamelist: [],
    date: null,
    menu: false,

    // Form Rules
    formRules: [(v) => !!v || "This is required"],
    formRulesQuantity: [
      (v) => !!v || "This is required",
      (v) => /^[0-9]+$/.test(v) || "Quantity must be valid",
    ],
    formRulesPrice: [
      (v) => !!v || "This is required",
      (v) =>
        /^[1-9]\d{0,7}(?:\.\d{1,4})?$/.test(v) || "Net Price must be valid",
    ],
    formRulesNumberRange: [
      (v) => {
        if (!isNaN(parseFloat(v)) && v >= 0 && v <= 9999999) return true;
        return "This is required";
      },
    ],

    // Form Data
    form: {
      id: null,
      category: null,
      sub_category: null,
      product_name: null,
      description: null,
      quantity: null,
      incoming_date: null,
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
      },
      {
        text: "CATEGORY",
        value: "category.product_cat_name",
        filterable: false,
        class: "black--text",
      },
      {
        text: "SUB-CATEGORY",
        value: "sub_category.prod_sub_cat_name",
        filterable: false,
        class: "black--text",
      },
      {
        text: "PRODUCT NAME",
        value: "product_name.product_name",
        class: "black--text",
      },
      {
        text: "PRICE",
        value: "price",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "QTY",
        value: "quantity",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "TOTAL AMT",
        value: "amount",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "DATE",
        value: "incoming_date",
        filterable: false,
        class: "black--text",
      },
      {
        text: "ACTION(S)",
        value: "id",
        align: "center",
        sortable: false,
        filterable: false,
        class: "black--text",
      },
    ],
    page: 1,
    pageCount: 0,
    itemsPerPage: 5,
    dateFrom: null,
    dateUntil: null,
    incomingDate: null,
    date1: false,
    date2: false,
    date3: false,
  }),

  // Onload
  created() {
    if (this.user.permissionslist.includes("Access Products")) {
      this.dateFrom = this.getFormatDate(
        new Date(new Date().getFullYear(), new Date().getMonth(), 1),
        "YYYY-MM-DD"
      );
      this.dateUntil = this.getFormatDate(
        new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0),
        "YYYY-MM-DD"
      );
      this.get();
      this.prodCat();
      this.prodSubCat();
    } else {
      this.$router.push({ name: "invalid-page" }).catch((errr) => {});
    }
  },

  methods: {
    quantityKeydown(e) {
      if (/[\s~`!@#$%^&()_={}[\]\\"*|:;,.<>+'\/?-]/.test(e.key)) {
        e.preventDefault();
      }
    },
    numberKeydown(e) {
      if (/[\s~`!@#$%^&()_={}[\]\\"*|:;,<>+'\/?-]/.test(e.key)) {
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
          if (key == "category") {
            if (this.currentdata.category) {
              if (this.currentdata.category.id != this.form.category) {
                found += 1;
              }
            }
          } else if (key == "sub_category") {
            if (this.currentdata.sub_category) {
              if (this.currentdata.sub_category.id != this.form.sub_category) {
                found += 1;
              }
            }
          } else if (key == "product_name") {
            if (this.currentdata.product_name) {
              if (
                this.currentdata.product_name.id != this.form.product_name.id
              ) {
                found += 1;
              }
            }
          } else if (key == "incoming_date") {
            if (
              this.getFormatDate(
                this.currentdata.incoming_date,
                "YYYY-MM-DD"
              ) != this.getFormatDate(this.form.incoming_date, "YYYY-MM-DD")
            ) {
              found += 1;
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
            .post("/api/inprod/save", this.form)
            .then((result) => {
              //if the value is true then save to database
              this.snackbar = {
                active: true,
                iconText: "check",
                iconColor: "success",
                message: "Successfully saved.",
              };
              this.get();
              this.cancel();
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
        .get("/api/inprod/get", {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,
            search: this.search,
            category: this.category,
            dateFrom: this.dateFrom,
            dateUntil: this.dateUntil,
          },
        })
        .then((result) => {
          console.log(result.data);
          // If the value is true then get the data
          this.table = result.data;
          this.progressbar = false; // Hide the progress bar
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    async prodCat() {
      await axios.get("/api/inprod/prodCat").then((prod_cat) => {
        this.prodcatlist = prod_cat.data;
      });
    },

    async prodSubCat() {
      await axios.get("/api/inprod/prodSubCat").then((prodsub_cat) => {
        this.prodsubcatlist = prodsub_cat.data;
      });
    },

    async prodName() {
      this.form.product_name = null;
      await axios
        .get("/api/inprod/prodName", {
          params: {
            category: this.form.category,
            sub_category: this.form.sub_category,
          },
        })
        .then((prod_name) => {
          this.prodnamelist = prod_name.data;
        });
    },

    getFormatDate(e, format) {
      const date = moment(e);
      return date.format(format);
    },

    // Editing/updating of row
    edit(row) {
      this.currentdata = JSON.parse(JSON.stringify(row));
      this.form.id = row.id;
      this.form.category = row.category.id;
      this.form.sub_category = row.sub_category.id;
      this.prodName();
      this.form.product_name = row.product_name;
      this.form.quantity = row.quantity;
      this.form.incoming_date = this.getFormatDate(
        row.incoming_date,
        "YYYY-MM-DD"
      );
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
