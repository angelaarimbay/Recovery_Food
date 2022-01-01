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
              Add Incoming Supply
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
          <v-dialog v-model="filterDialog" max-width="400px" scrollable>
            <v-card dark tile>
              <v-toolbar dense flat class="transparent px-1">
                <span
                  class="
                    text-xl-subtitle-1
                    text-lg-subtitle-1
                    text-md-subtitle-1
                    text-sm-subtitle-1
                    text-subtitle-2
                  "
                  >Search Filter</span
                >
                <v-spacer></v-spacer>
                <v-icon
                  :small="$vuetify.breakpoint.xsOnly"
                  text
                  @click="filterDialog = false"
                  >mdi-close
                </v-icon>
              </v-toolbar>
              <v-divider class="my-0"></v-divider>
              <v-card-text class="px-5 py-2" style="height: auto">
                <v-row no-gutters align="center">
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
                        placeholder="Supply Name"
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

                  <!-- Category Field -->
                  <v-col cols="4"
                    ><span class="text-caption text-xl-subtitle-2"
                      >Category</span
                    ></v-col
                  >
                  <v-col cols="8">
                    <v-card-actions class="px-0">
                      <v-select
                        hide-details
                        :items="suppcatlist"
                        item-text="supply_cat_name"
                        item-value="id"
                        clearable
                        dense
                        v-model="category"
                        placeholder="Category"
                        @change="get"
                        background-color="grey darken-3"
                        flat
                        solo
                        style="font-size: 12px"
                      >
                      </v-select>
                    </v-card-actions>
                  </v-col>

                  <!-- Date Picker -->
                  <v-col cols="4"
                    ><span class="text-caption text-xl-subtitle-2"
                      >Date From</span
                    ></v-col
                  >
                  <v-col cols="8">
                    <v-menu
                      v-model="date1"
                      :close-on-content-click="false"
                      :nudge-right="35"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-card-actions class="px-0">
                          <v-text-field
                            hide-details
                            v-model="dateFrom"
                            placeholder="Date From"
                            prepend-inner-icon="mdi-calendar-range"
                            readonly
                            v-on="on"
                            dense
                            clearable
                            background-color="grey darken-3"
                            flat
                            solo
                            style="font-size: 12px"
                          ></v-text-field>
                        </v-card-actions>
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
                  </v-col>

                  <!-- Date Picker -->
                  <v-col cols="4"
                    ><span class="text-caption text-xl-subtitle-2"
                      >Date Until</span
                    ></v-col
                  >
                  <v-col cols="8">
                    <v-menu
                      v-model="date2"
                      :close-on-content-click="false"
                      :nudge-right="35"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-card-actions class="px-0">
                          <v-text-field
                            hide-details
                            v-model="dateUntil"
                            placeholder="Date Until"
                            prepend-inner-icon="mdi-calendar-range"
                            readonly
                            v-on="on"
                            dense
                            clearable
                            background-color="grey darken-3"
                            flat
                            solo
                            style="font-size: 12px"
                          ></v-text-field>
                        </v-card-actions>
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
                  </v-col>
                </v-row>
              </v-card-text>
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
          <template v-slot:[`item.supply_name.net_price`]="{ item }"
            >{{ getFormatCurrency(item.supply_name.net_price, "0,0.00") }}
          </template>
          <template v-slot:[`item.incoming_date`]="{ item }">
            {{ getFormatDate(item.incoming_date, "YYYY-MM-DD") }}</template
          >
          <template v-slot:[`item.count`]="{ item }"> {{ item.row }}</template>
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
          scrollable
        >
          <v-card>
            <v-toolbar dark dense flat class="red darken-3 px-1">
              <span
                class="
                  text-xl-subtitle-1
                  text-lg-subtitle-1
                  text-md-subtitle-1
                  text-sm-subtitle-1
                  text-subtitle-2
                "
                >Incoming Supply</span
              >
              <v-spacer></v-spacer>
              <v-icon :small="$vuetify.breakpoint.xsOnly" text @click="cancel"
                >mdi-close
              </v-icon>
            </v-toolbar>
            <v-card-text style="height: auto">
              <v-row class="mt-4 px-1">
                <v-col
                  class="tfield py-0 px-1"
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

                  <v-menu
                    v-model="date3"
                    :close-on-content-click="false"
                    :nudge-right="35"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <!-- Incoming Date -->
                      <v-text-field
                        :prepend-inner-icon="
                          showIcon ? 'mdi-calendar-range' : ''
                        "
                        :rules="formRules"
                        v-model="form.incoming_date"
                        readonly
                        v-on="on"
                        class="py-0"
                        dense
                        clearable
                        label=""
                        background-color="white"
                        flat
                        solo
                        style="font-size: 12px"
                      >
                        <template slot="label">
                          <div style="font-size: 12px">
                            Incoming Date <span style="color: red">*</span>
                          </div>
                        </template>
                      </v-text-field>
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
                  class="tfield py-0 px-1"
                  cols="12"
                  xl="12"
                  lg="12"
                  sm="12"
                  md="12"
                >
                  <!-- Supplier -->
                  <v-select
                    :rules="formRules"
                    v-model="form.supplier"
                    dense
                    :items="supplierlist"
                    item-text="supplier_name"
                    item-value="id"
                    @change="suppName"
                    autocomplete
                    background-color="white"
                    flat
                    solo
                    style="font-size: 12px"
                  >
                    <template slot="label">
                      <div style="font-size: 12px">
                        Supplier <span style="color: red">*</span>
                      </div>
                    </template>
                  </v-select>
                </v-col>

                <v-col
                  class="tfield py-0 px-1"
                  cols="12"
                  xl="12"
                  lg="12"
                  sm="12"
                  md="12"
                >
                  <!-- Supply Category -->
                  <v-select
                    :rules="formRulesNumberRange"
                    v-model="form.category"
                    dense
                    :items="suppcatlist"
                    item-text="supply_cat_name"
                    item-value="id"
                    @change="suppName"
                    background-color="white"
                    flat
                    solo
                    style="font-size: 12px"
                  >
                    <template slot="label">
                      <div style="font-size: 12px">
                        Supply Category <span style="color: red">*</span>
                      </div>
                    </template>
                  </v-select>
                </v-col>

                <v-col
                  class="tfield py-0 px-1"
                  cols="12"
                  xl="12"
                  lg="12"
                  sm="12"
                  md="12"
                >
                  <!-- Supply Name -->
                  <v-autocomplete
                    :rules="formRules"
                    v-model="form.supply_name"
                    :items="suppnamelist"
                    item-text="supply_name"
                    return-object
                    dense
                    background-color="white"
                    flat
                    solo
                    style="font-size: 12px"
                  >
                    <template slot="label">
                      <div style="font-size: 12px">
                        Supply Name <span style="color: red">*</span>
                      </div>
                    </template>
                  </v-autocomplete>

                  <v-card color="#f1f3f4" flat class="px-4 mb-6" v-if="form.supply_name">
                    <table style="width: 100%; font-size: 11px">
                      <tr>
                        <td
                          class="text-left pr-2"
                          style="width: 50%"
                          v-if="form.supply_name.description"
                        >
                          Description:
                        </td>
                        <th>{{ form.supply_name.description }}</th>
                      </tr>
                      <tr>
                        <td class="text-left pr-2" style="width: 50%">
                          Net Price:
                        </td>
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
                        <td class="text-left pr-2" style="width: 50%">Unit:</td>
                        <th>{{ form.supply_name.unit }}</th>
                      </tr>
                    </table>
                  </v-card>
                </v-col>
                <v-col
                  class="tfield py-0 px-1"
                  cols="6"
                  xl="5"
                  lg="5"
                  sm="5"
                  md="5"
                >
                  <!-- Quantity -->
                  <v-text-field
                    :rules="formRulesQuantity"
                    v-model="form.quantity"
                    clearable
                    dense
                    @keydown="quantityKeydown($event)"
                    counter
                    maxlength="4"
                    background-color="white"
                    flat
                    solo
                    style="font-size: 12px"
                  >
                    <template slot="label">
                      <div style="font-size: 12px">
                        Quantity <span style="color: red">*</span>
                      </div>
                    </template>
                  </v-text-field>
                </v-col>

                <v-col
                  class="tfield py-0 px-1"
                  cols="6"
                  xl="7"
                  lg="7"
                  sm="7"
                  md="7"
                >
                  <!-- Amount -->
                  <v-text-field
                    :rules="formRulesPrice"
                    v-model="form.amount"
                    clearable
                    dense
                    @keydown="numberKeydown($event)"
                    counter
                    maxlength="15"
                    background-color="white"
                    flat
                    solo
                    style="font-size: 12px"
                  >
                    <template slot="label">
                      <div style="font-size: 12px">
                        Amount <span style="color: red">*</span>
                      </div>
                    </template>
                  </v-text-field>
                </v-col>
              </v-row>
            </v-card-text>
            <v-divider class="my-0"></v-divider>
            <!-- Dialog Form Buttons -->
            <v-card-actions class="pa-3">
              <template v-if="$vuetify.breakpoint.xsOnly">
                <v-row no-gutters>
                  <v-col cols="6" class="px-1">
                    <v-spacer></v-spacer>
                    <v-btn
                      style="text-transform: none"
                      color="grey"
                      depressed
                      :disabled="button"
                      dark
                      @click="cancel"
                      :small="$vuetify.breakpoint.xsOnly"
                      outlined
                      block
                    >
                      <span style="color: #1976d2">Cancel</span>
                    </v-btn>
                  </v-col>
                  <v-col cols="6" class="px-1">
                    <v-btn
                      style="text-transform: none"
                      color="primary"
                      depressed
                      :disabled="button"
                      dark
                      @click="save"
                      :small="$vuetify.breakpoint.xsOnly"
                      block
                    >
                      Save
                    </v-btn>
                  </v-col>
                </v-row>
              </template>
              <template v-else>
                <v-spacer></v-spacer>
                <v-btn
                  style="text-transform: none"
                  color="grey"
                  depressed
                  :disabled="button"
                  dark
                  @click="cancel"
                  :small="$vuetify.breakpoint.xsOnly"
                  outlined
                >
                  <span style="color: #1976d2">Cancel</span>
                </v-btn>
                <v-btn
                  style="text-transform: none"
                  color="primary"
                  depressed
                  :disabled="button"
                  dark
                  @click="save"
                  :small="$vuetify.breakpoint.xsOnly"
                >
                  Save
                </v-btn>
              </template>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-form>
    </v-card>
  </div>
</template>

<!-- Style -->
<style>
.v-input__control .v-icon.notranslate.v-icon--link.mdi.mdi-close {
  font-size: 16px;
}

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
    return { title: "Inventory" };
  },
  //Computed
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
    showIcon() {
      if (this.$vuetify.breakpoint.smAndUp) {
        return true;
      } else {
        return false;
      }
    },
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
    deleteid: "",
    tempfile: "",
    category: "",
    table: [],
    suppcatlist: [],
    suppnamelist: [],
    supplierlist: [],
    filterDialog: false,

    //Form Rules
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

    //Form Data
    form: {
      category: null,
      supply_name: null,
      supplier: null,
      quantity: null,
      amount: null,
      incoming_date: null,
    },

    //For comparing data
    currentdata: {},

    //Table Headers
    headers: [
      {
        text: "#",
        value: "count",
        align: "center",
        filterable: false,
        class: "black--text",
        sortable: false,
        width: "5%",
      },
      {
        text: "CATEGORY",
        value: "category.supply_cat_name",
        filterable: false,
        class: "black--text",
        width: "10%",
      },
      {
        text: "SUPPLY NAME",
        value: "supply_name.supply_name",
        class: "black--text",
        width: "20%",
      },
      {
        text: "UNIT",
        value: "supply_name.unit",
        filterable: false,
        class: "black--text",
        width: "5%",
      },
      {
        text: "NET PRICE",
        value: "supply_name.net_price",
        align: "right",
        filterable: false,
        class: "black--text",
        width: "10%",
      },
      {
        text: "WITH VAT",
        value: "with_vat_price",
        align: "right",
        filterable: false,
        class: "black--text",
        width: "10%",
      },
      {
        text: "QTY",
        value: "quantity",
        align: "right",
        filterable: false,
        class: "black--text",
        width: "10%",
      },
      {
        text: "TOTAL AMT",
        value: "amount",
        align: "right",
        filterable: false,
        class: "black--text",
        width: "15%",
      },
      {
        text: "INCOMING DATE",
        value: "incoming_date",
        align: "center",
        filterable: false,
        class: "black--text",
        width: "10%",
      },
      {
        text: "ACTION",
        value: "id",
        align: "center",
        sortable: false,
        filterable: false,
        class: "black--text",
        width: "5%",
      },
    ],
    page: 1,
    pageCount: 0,
    itemsPerPage: 10,
    dateFrom: null,
    dateUntil: null,
    incomingDate: null,
    date1: false,
    date2: false,
    date3: false,
  }),

  //Onload
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

  //Methods
  methods: {
    //Keydown
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

    //Format for everytime we call on database
    //Always add await and async
    compare() {
      //Compare existing data vs edited data
      //If nothing change then no request
      if (!this.currentdata) {
        return true;
      }
      //Check if not existed
      //Check each value if the same or not
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
            found += 1;
          }
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
            .post("/api/isupp/save", this.form)
            .then((result) => {
              //If the value is true then save to database
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
              //If false or error when saving
            });
        }
      }
    },

    //For retrieving incoming supplies
    async get() {
      this.progressbar = true; //Show the progress bar
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
          // console.log(result.data);
          //If the value is true then get the data
          this.table = result.data;
          this.progressbar = false; //Hide the progress bar
        });
    },

    //For retrieving supply categories
    async suppCat() {
      await axios.get("/api/isupp/suppCat").then((supp_cat) => {
        this.suppcatlist = supp_cat.data;
      });
    },

    //For retrieving supply names
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

    //For retrieving suppliers
    async suppliers() {
      await axios.get("/api/isupp/suppliers", {}).then((result) => {
        this.supplierlist = result.data;
      });
    },

    //Editing/updating of row
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
