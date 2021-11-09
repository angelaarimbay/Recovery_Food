<template>
  <div style="min-width: 280px">
    <!-- Snackbar -->
    <v-snackbar
      :vertical="$vuetify.breakpoint.xsOnly"
      min-width="auto"
      v-model="snackbar.active"
      timeout="2500"
      :right="$vuetify.breakpoint.smAndUp"
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
          Inventory
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
            >Incoming Supplies</v-btn
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
              Add Incoming Supply
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
                        :items="suppcatlist"
                        item-text="supply_cat_name"
                        item-value="id"
                        class="my-0"
                        clearable
                        dense
                        v-model="category"
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
            <template v-slot:[`item.supply_full`]="{ item }"
              >{{ item.supply_name.supply_name }}
              {{ item.supply_name.description }}</template
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

        <!--Dialog Form-->
        <v-form ref="form">
          <v-dialog v-model="dialog" max-width="450px">
            <v-toolbar
              dense
              dark
              class="pl-xl-6 pl-lg-6 pl-md-6 pl-sm-5 pl-3 red darken-2"
            >
              Incoming Supply
              <v-spacer></v-spacer>
              <v-icon
                class="mr-xl-4 mr-lg-4 mr-md-4 mr-sm-3 mr-1"
                text
                @click="cancel"
                >mdi-close
              </v-icon>
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

                    <v-col
                      class="py-0"
                      cols="12"
                      xl="12"
                      lg="12"
                      sm="12"
                      md="12"
                    >
                      <v-select
                        :rules="formRules"
                        v-model="form.supplier"
                        outlined
                        dense
                        :items="supplierlist"
                        item-text="supplier_name"
                        item-value="id"
                        @change="suppName"
                        autocomplete
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Supplier *</div>
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
                        :rules="formRulesNumberRange"
                        v-model="form.category"
                        outlined
                        dense
                        :items="suppcatlist"
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
                      class="pt-0 pb-6"
                      cols="12"
                      xl="12"
                      lg="12"
                      sm="12"
                      md="12"
                    >
                      <v-autocomplete
                        :rules="formRules"
                        v-model="form.supply_name"
                        outlined
                        dense
                        hide-details=""
                        :items="suppnamelist"
                        return-object
                        item-text="supply_name"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Supply Name *</div>
                        </template>
                        <template slot="selection" slot-scope="data">
                          <!-- HTML that describe how select should render selected items -->
                          {{ data.item.supply_name }}
                          {{ data.item.description }}
                        </template>
                        <template slot="item" slot-scope="data">
                          <!-- HTML that describe how select should render items when the select is open -->
                          {{ data.item.supply_name }}
                          {{ data.item.description }}
                        </template>
                      </v-autocomplete>

                      <v-card
                        style="background-color: #f5f5f5"
                        flat
                        class="px-4"
                        v-if="form.supply_name"
                      >
                        <table style="width: 50%; font-size: 11px">
                          <tr>
                            <th class="text-left pr-2" style="width: 50%">
                              Description:
                            </th>
                            <th>{{ form.supply_name.description }}</th>
                          </tr>
                          <tr>
                            <th class="text-left pr-2">Net Price:</th>
                            <th>
                              {{
                                getFormatCurrency(
                                  form.supply_name.net_price,
                                  "0,0.00"
                                )
                              }}
                            </th>
                          </tr>
                          <tr>
                            <th class="text-left pr-2">Unit:</th>
                            <th>{{ form.supply_name.unit }}</th>
                          </tr>
                        </table>
                      </v-card>
                    </v-col>
                    <v-col class="py-0" cols="12" xl="5" lg="5" sm="5" md="5">
                      <v-text-field
                        :rules="formRulesQuantity"
                        v-model="form.quantity"
                        outlined
                        clearable
                        dense
                        @keydown="quantityKeydown($event)"
                        counter
                        maxlength="4"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Quantity *</div>
                        </template>
                      </v-text-field>
                    </v-col>

                    <v-col class="py-0" cols="12" xl="7" lg="7" sm="7" md="7">
                      <v-text-field
                        :rules="formRulesPrice"
                        v-model="form.amount"
                        outlined
                        clearable
                        dense
                        @keydown="numberKeydown($event)"
                        counter
                        maxlength="15"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Amount *</div>
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
    return { title: "Inventory" };
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
    button: false,
    dialog: false,
    deleteid: "",
    tempfile: "",
    category: "",
    table: [],
    suppcatlist: [],
    suppnamelist: [],
    supplierlist: [],

    // Form Rules
    formRules: [(v) => !!v || "This is required"],
    formRulesQuantity: [
      (v) => !!v || "This is required",
      (v) => /^[1-9][0-9]*$/.test(v) || "Quantity must be valid",
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
      category: null,
      supply_name: null,
      supplier: null,
      quantity: null,
      amount: null,
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
        value: "category.supply_cat_name",
        filterable: false,
        class: "black--text",
      },
      {
        text: "SUPPLY NAME",
        value: "supply_full",
        class: "black--text",
      },
      {
        text: "UNIT",
        value: "supply_name.unit",
        filterable: false,
        class: "black--text",
      },
      {
        text: "NET PRICE",
        value: "supply_name.format_net_price",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "WITH VAT",
        value: "with_vat_price",
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
        text: "INCOMING DATE",
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
    if (this.user.permissionslist.includes("Access Inventory")) {
      this.dateFrom = this.getFormatDate(
        new Date(new Date().getFullYear(), new Date().getMonth(), 1),
        "YYYY-MM-DD"
      );
      this.dateUntil = this.getFormatDate(
        new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0),
        "YYYY-MM-DD"
      );
      this.get();
      this.suppCat();
      this.suppliers();
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

    getFormatDate(e, format) {
      const date = moment(e);
      return date.format(format);
    },
    getFormatCurrency(e, format) {
      const numbr = numeral(e);
      return numbr.format(format);
    },

    // Format for everytime we call on database
    // Always add await and async
    compare() {
      // Compare existing data vs edited data
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
              if (this.currentdata.supply_name.id != this.form.supply_name.id) {
                found += 1;
              }
            }
          } else if (key == "supplier") {
            if (this.currentdata.supplier) {
              if (this.currentdata.supplier.id != this.form.supplier) {
                found += 1;
              }
            }
          } else if (key == "amount") {
            if (this.currentdata.amount) {
              if (
                this.currentdata.amount.replace(",", "") != this.form.amount
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
            console.log(key);
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
            .post("/api/isupp/save", this.form)
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
        .get("/api/isupp/get", {
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
          // If the value is true then get the data
          this.table = result.data;
          this.progressbar = false; // Hide the progress bar
        });
    },

    async suppCat() {
      await axios.get("/api/isupp/suppCat").then((supp_cat) => {
        this.suppcatlist = supp_cat.data;
      });
    },

    async suppName() {
      this.form.supply_name = null;
      await axios
        .get("/api/isupp/suppName", {
          params: {
            supplier: this.form.supplier,
            category: this.form.category,
          },
        })
        .then((supp_name) => {
          this.suppnamelist = supp_name.data;
        });
    },

    async suppliers() {
      await axios.get("/api/isupp/suppliers", {}).then((result) => {
        this.supplierlist = result.data;
      });
    },

    // Editing/updating of row
    edit(row) {
      this.currentdata = JSON.parse(JSON.stringify(row));
      this.form.id = row.id;
      this.form.category = row.category.id;
      this.form.supplier = row.supplier.id;
      this.suppName();
      this.form.supply_name = row.supply_name;
      this.form.quantity = row.quantity;
      this.form.amount = row.amount.replace(",", "");
      this.form.incoming_date = this.getFormatDate(
        row.incoming_date,
        "YYYY-MM-DD"
      );
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
