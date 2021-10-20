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
            >Masterlist Supplies</v-btn
          >
        </v-card-actions>
      </v-layout>
    </v-container>

    <!-- Main Card -->
    <v-card elevation="6" class="mt-2" style="border-radius: 10px">
      <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-1">
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
              Add Supply
            </v-btn>

            <v-spacer></v-spacer>

            <!-- <v-tooltip bottom>
              <template #activator="data">
                <v-btn
                  :large="$vuetify.breakpoint.mdAndDown"
                  x-large
                  icon
                  dark
                  @click="sheet = !sheet"
                  color="red darken-2"
                  class="mb-xl-2 mb-lg-2 mb-md-1 mb-sm-1 mb-1"
                  v-on="data.on"
                >
                  <v-icon>mdi-calendar</v-icon>
                </v-btn>
              </template>
              <span>Manage Dates</span>
            </v-tooltip> -->

            <!-- <v-bottom-sheet v-model="sheet" inset width="400px">
              <v-sheet
                class="text-center"
                style="border-radius: 10px 10px 0px 0px"
              >
                <v-btn
                  color="#FF5252"
                  depressed
                  dark
                  style="text-transform: none"
                  small
                  class="mt-5"
                  @click="sheet = !sheet"
                >
                  Close
                </v-btn>

                <v-row no-gutters>
                  <v-col
                    cols="12"
                    xl="12"
                    lg="12"
                    md="12"
                    sm="12"
                    class="pa-xl-6 pa-lg-5 pa-md-4 pa-sm-3 pa-3"
                  >
                    <v-text-field
                      outlined
                      label="Date"
                      hide-details
                      dense
                      clearable
                    >
                    </v-text-field>
                  </v-col>

                  <v-col
                    cols="12"
                    xl="12"
                    lg="12"
                    md="12"
                    sm="12"
                    class="pa-xl-6 pa-lg-5 pa-md-4 pa-sm-3 pa-3"
                  >
                    <v-select
                      outlined
                      label="Month Days"
                      hide-details
                      dense
                      :items="dayslist"
                      clearable
                    >
                    </v-select>
                  </v-col>
                </v-row>
              </v-sheet>
            </v-bottom-sheet> -->
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
                        v-model="category"
                        :items="suppcatlist"
                        item-text="supply_cat_name"
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
            <template v-slot:[`item.supply_full`]="{ item }"
              >{{ item.supply_name }} {{ item.description }}</template
            >
            <template v-slot:[`item.exp_date`]="{ item }">
              {{ getFormatDate(item.exp_date, "MM/DD/YYYY") }}</template
            >
            <template v-slot:[`item.count`]="{ item }">
              {{ item.row }}</template
            >
            <template v-slot:[`item.status`]="{ item }">
              <!-- <small> Lead time: {{ item.lead_time }} /
              Max order: {{ item.minimum_order_quantity }} /
              Frequency:  {{ item.order_frequency }}<br> </small> -->

              <v-chip
                style="justify-content: center"
                x-small
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
              :total-visible="5"
              :length="table.last_page"
              color="red darken-2"
            ></v-pagination>
          </div>
        </v-container>

        <!--Dialog Form-->
        <v-form ref="form">
          <v-dialog v-model="dialog" persistent max-width="450px">
            <v-toolbar
              dense
              dark
              class="pl-xl-6 pl-lg-6 pl-md-6 pl-sm-5 pl-3 red darken-2"
            >
              Supply
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
                    <v-col class="py-0" cols="12" xl="4" lg="4" sm="4" md="4">
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
                          <div style="font-size: 14px">Status *</div>
                        </template>
                      </v-select>
                    </v-col>

                    <v-col class="py-0" cols="12" xl="8" lg="8" sm="8" md="8">
                      <v-select
                        :rules="formRulesNumberRange"
                        v-model="form.supplier"
                        outlined
                        dense
                        :items="supplierlist"
                        item-text="supplier_name"
                        item-value="id"
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
                        :items="suppcatlist"
                        dense
                        item-text="supply_cat_name"
                        item-value="id"
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
                      <v-text-field
                        :rules="formRules"
                        v-model="form.supply_name"
                        outlined
                        clearable
                        dense
                        counter
                        @keydown="valueKeydown($event)"
                        maxlength="35"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Supply Name *</div>
                        </template>
                      </v-text-field>
                    </v-col>

                    <v-col class="py-0" cols="12" xl="8" lg="8" sm="8" md="8">
                      <v-text-field
                        :rules="formRulesDesc"
                        v-model="form.description"
                        outlined
                        clearable
                        dense
                        counter
                        @keydown="descKeydown($event)"
                        maxlength="35"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Description</div>
                        </template>
                      </v-text-field>
                    </v-col>

                    <v-col class="py-0" cols="12" xl="4" lg="4" sm="4" md="4">
                      <v-select
                        :items="unit"
                        :rules="formRules"
                        v-model="form.unit"
                        outlined
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Unit *</div>
                        </template>
                      </v-select>
                    </v-col>

                    <v-col class="py-0" cols="12" xl="7" lg="7" sm="7" md="7">
                      <v-text-field
                        :rules="formRulesPrice"
                        v-model="form.net_price"
                        outlined
                        clearable
                        dense
                        counter
                        @keydown="numberKeydown($event)"
                        @input="compute"
                        @click:clear="compute"
                        maxlength="15"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Net Price *</div>
                        </template>
                      </v-text-field>
                    </v-col>

                    <v-col class="py-0" cols="12" xl="5" lg="5" sm="5" md="5">
                      <v-layout align-center>
                        <v-text-field
                          :rules="formRulesVAT"
                          v-model="temp_vat"
                          outlined
                          disabled
                          clearable
                          dense
                          @keydown="numberKeydown($event)"
                        >
                          <template slot="label">
                            <div style="font-size: 14px">VAT</div>
                          </template>
                        </v-text-field>

                        <v-checkbox
                          :disabled="!disabled"
                          v-model="vat"
                          hide-details
                          class="shrink pt-0 mt-0 mb-7 ml-3"
                          color="red darken-3"
                          @change="compute"
                        ></v-checkbox>
                      </v-layout>
                    </v-col>

                    <v-col
                      class="py-0 d-none"
                      cols="8"
                      xl="8"
                      lg="8"
                      sm="12"
                      md="12"
                    >
                      <v-text-field disabled outlined clearable dense>
                        <template slot="label">
                          <div style="font-size: 14px">Price w/o VAT</div>
                        </template>
                      </v-text-field>
                    </v-col>

                    <v-col class="py-0" cols="12" xl="6" lg="6" sm="6" md="6">
                      <v-menu
                        v-model="menu"
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
                            v-model="form.exp_date"
                            label="Expiration Date"
                            readonly
                            v-on="on"
                            class="py-0"
                            dense
                            clearable
                            outlined
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          v-model="form.exp_date"
                          @input="menu = false"
                          scrollable
                          no-title
                          color="red darken-2"
                          dark
                        ></v-date-picker>
                      </v-menu>
                    </v-col>
                    <v-col class="py-0" cols="12" xl="6" lg="6" sm="6" md="6">
                      <v-text-field
                        v-model="form.minimum_order_quantity"
                        outlined
                        clearable
                        dense
                        counter
                        maxlength="10"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Min Order Quantity</div>
                        </template>
                      </v-text-field>
                    </v-col>
                    <v-col class="py-0" cols="12" xl="6" lg="6" sm="6" md="6">
                      <v-text-field
                        v-model="form.lead_time"
                        :rules="formRulesQuantity"
                        outlined
                        clearable
                        dense
                        counter
                        @keydown="numberKeydown($event)"
                        @input="compute"
                        @click:clear="compute"
                        maxlength="4"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Lead Time</div>
                        </template>
                      </v-text-field>
                    </v-col>
                    <v-col class="py-0" cols="12" xl="6" lg="6" sm="6" md="6">
                      <v-text-field
                        :rules="formRulesPrice"
                        v-model="form.order_frequency"
                        outlined
                        clearable
                        dense
                        counter
                        @keydown="numberKeydown($event)"
                        @input="compute"
                        @click:clear="compute"
                        maxlength="4"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Order Frequency *</div>
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
  data: () => ({
    progressbar: false,
    snackbar: {
      active: false,
      message: "",
    },
    search: "",
    button: false,
    dialog: false,
    sheet: false,
    unit: [
      "pack",
      "can",
      "bot",
      "kg",
      "gal",
      "tin",
      "jar",
      "tab",
      "pcs",
      "cont",
      "roll",
      "box",
      "pad",
      "rim",
      "book",
      "set",
      "unit",
    ],
    status: [
      { name: "Active", id: 1 },
      { name: "Inactive", id: 0 },
    ],
    supply_id: "",
    disable: "",
    table: [],
    category: "",
    suppcatlist: [],
    suppnamelist: [],
    dayslist: [],
    date: null,
    menu: false,

    // Form Rules
    formRules: [(v) => !!v || "This is required"],
    formRulesDesc: [
      (v) =>
        /^$|^(?:([A-Za-z])(?!\1{2})|([0-9])(?!\2{7})|([\s,'-_/.()])(?!\3{1}))+$/i.test(
          v
        ) || "This field must have a valid value",
    ],
    formRulesPrice: [
      (v) => !!v || "This is required",
      (v) =>
        /^[1-9]\d{0,7}(?:\.\d{1,4})?$/.test(v) || "Net Price must be valid",
    ],
    formRulesVAT: [
      (v) => !!v || "This is required",
      (v) =>
        /^[0-9]\d{0,7}(?:\.\d{1,4})?$/.test(v) || "Net Price must be valid",
    ],
    formRulesNumberRange: [
      (v) => {
        if (!isNaN(parseFloat(v)) && v >= 0 && v <= 9999999) return true;
        return "This is required";
      },
    ],
    formRulesQuantity: [
      (v) => !!v || "This is required",
      (v) => /^[0-9]+$/.test(v) || "Quantity must be valid",
    ],

    // Form Data
    form: {
      id: null,
      status: [
        { name: "Active", id: 1 },
        { name: "Inactive", id: 0 },
      ],
      supply_name: null,
      supplier: null,
      category: null,
      description: null,
      unit: null,
      net_price: null,
      vat: null,
      exp_date: null,
      vatable: null,
      lead_time: null,
      order_frequency: null,
      minimum_order_quantity: null,
    },
    temp_vat: null, //form.vat = this.
    vat: false,
    supplierlist: [],

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
        text: "SUPPLIER",
        value: "supplier.supplier_name",
        filterable: false,
        class: "black--text",
      },
      {
        text: "CATEGORY",
        value: "category.supply_cat_name",
        filterable: false,
        class: "black--text",
      },
      { text: "SUPPLY NAME", value: "supply_full", class: "black--text" },
      { text: "UNIT", value: "unit", filterable: false, class: "black--text" },
      {
        text: "NET PRICE",
        value: "format_net_price",
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
        text: "WITHOUT VAT",
        value: "without_vat_price",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "STATUS",
        value: "status",
        align: "center",
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
  }),

  // Dynamic Width
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
    disabled() {
      if (this.form.net_price !== null) {
        return true;
      } else {
        return false;
      }
    },
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
    if (this.user.permissionslist.includes("Access Inventory")) {
      this.get();
      this.suppCat();
      this.suppliers();
    } else {
      this.$router.push({ name: "invalid-page" }).catch((errr) => {});
    }
    // this.getDays();
  },

  methods: {
    valueKeydown(e) {
      if (/[~`!@#$%^&()_={}[\]\\"*|:;.<>+\?]/.test(e.key)) {
        e.preventDefault();
      }
    },
    descKeydown(e) {
      if (/[~`!@#$%^&={}[\]\\*|:;<>+\?]/.test(e.key)) {
        e.preventDefault();
      }
    },
    numberKeydown(e) {
      if (/[\s~`!@#$%^&()_={}[\]\\"*|:;,<>+'\/?-]/.test(e.key)) {
        e.preventDefault();
      }
    },
    async getVat() {
      await axios
        .get("/api/settings/vat/get", { params: { type: "s" } })
        .then((result) => {
          this.temp_vat = result.data.vat;
        });
    },
    async suppName() {
      this.form.supply_name = null;
      await axios
        .get("/api/msupp/suppName", {
          params: { supplier: this.form.supplier },
        })
        .then((supp_name) => {
          this.suppnamelist = supp_name.data;
        });
    },

    getFormatDate(e, format) {
      const date = moment(e);
      return date.format(format);
    },

    // getDays() {
    //   var days = new Date(
    //     this.getFormatDate(Date.now(), "Y"),
    //     this.getFormatDate(Date.now(), "M"),
    //     0
    //   ).getDate();

    //   for (let i = 1; i < days + 1; i++) {
    //     this.dayslist.push(i);
    //   }
    // },

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
          console.log(key);
          if (key == "category") {
            if (this.currentdata.category) {
              if (
                parseInt(this.currentdata.category.id) !=
                parseInt(this.form.category)
              ) {
                found += 1;
              }
            }
          } else if (key == "exp_date") {
            if (
              this.getFormatDate(this.currentdata.exp_date, "YYYY-MM-DD") !=
              this.getFormatDate(this.form.exp_date, "YYYY-MM-DD")
            ) {
              found += 1;
            }
          } else if (key == "supplier") {
            if (this.currentdata.supplier) {
              if (
                parseInt(this.currentdata.supplier.id) !=
                parseInt(this.form.supplier)
              ) {
                found += 1;
              }
            }
          } else {
            found += 1;
          }
        }
      }
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
        this.compute();
        // Validate first before compare
        if (this.compare()) {
          // Save or update data in the table
          await axios
            .post("/api/msupp/save", this.form)
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
        .get("/api/msupp/get", {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,
            search: this.search,
            category: this.category,
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
    async suppliers() {
      await axios.get("/api/isupp/suppliers", {}).then((result) => {
        this.supplierlist = result.data;
      });
    },

    async sum() {
      await axios
        .get("/api/msupp/sum", {
          params: {
            id: this.supply_id,
          },
        })
        .then((result) => {
          // If the value is true then get the data
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    async validateItem() {
      await axios
        .get("/api/msupp/validateItem", {
          params: {
            name: this.form.supply_name,
          },
        })
        .then((result) => {
          try {
            this.supply_id = result.data.id;
          } catch (error) {}
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    async suppCat() {
      await axios.get("/api/msupp/suppCat").then((supp_cat) => {
        this.suppcatlist = supp_cat.data;
      });
    },

    // 1. get specific item info ,eg total amount, total quantity
    // 2. check if true then total / tem_vat
    // 3. else wo/vat = total (total amt / quantity)
    async compute() {
      //check if vatable or not
      if (this.vat) {
        if (this.temp_vat) {
          this.form.vatable = 1;
        } else {
          this.form.vatable = 0;
        }
      } else {
        this.getVat();
        this.form.vatable = 0;
      }
      this.form.vat = this.temp_vat;
      this.sum();
    },

    // Editing/updating of row
    edit(row) {
      this.currentdata = JSON.parse(JSON.stringify(row));
      this.form.supplier = row.supplier.id;
      this.form.id = row.id;
      this.form.status = row.status;
      this.form.category = row.category.id;
      this.form.supply_name = row.supply_name;
      this.form.description = row.description;
      this.form.unit = row.unit;
      this.form.net_price = row.net_price;
      this.form.vat = row.vat;
      this.vat = row.vatable == 0 ? false : true;
      this.temp_vat = row.vat;
      this.form.lead_time = row.lead_time;
      this.form.order_frequency = row.order_frequency;
      this.form.minimum_order_quantity = row.minimum_order_quantity;

      this.form.exp_date = this.getFormatDate(row.exp_date, "YYYY-MM-DD");

      this.dialog = true;
      this.compute();
    },

    // Open Dialog Form
    openDialog() {
      if (this.form.temp_vat !== null) {
        this.$refs.form.resetValidation();
        this.getVat();
        this.dialog = true;
      } else {
        this.$refs.form.reset();
        this.getVat();
        this.dialog = true;
      }
    },

    // Reset Forms
    cancel() {
      for (var key in this.form) {
        if (key == "vat") {
          this.getVat();
        } else {
          this.form[key] = "";
          this.vat = false;
          this.disable = true;
        }
      }
      this.dialog = false;
    },
  },

  watch: {
    dialog(val) {
      val || this.cancel();
    },
    temp_vat() {
      this.compute();
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
