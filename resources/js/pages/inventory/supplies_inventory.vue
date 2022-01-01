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
            to="/supplies_inventory"
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
          >
            Supplies Inventory
          </v-btn>
        </v-card-actions>
      </v-layout>
    </v-container>

    <!-- Main Card -->
    <v-card elevation="1" class="mt-2" style="border-radius: 10px">
      <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-4 py-4">
        <v-card-actions class="px-0">
          <v-row align="center" no-gutters>
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
                    ><v-icon>mdi-refresh</v-icon></v-btn
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
        </v-card-actions>

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
                      v-model="category"
                      :items="suppcatlist"
                      item-text="supply_cat_name"
                      item-value="id"
                      clearable
                      dense
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
              </v-row>
            </v-card-text>
          </v-card>
        </v-dialog>

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
          <template v-slot:[`item.supply_full`]="{ item }"
            >{{ item.supply_name.supply_name }}
            {{ item.supply_name.description }}</template
          >
          <template v-slot:[`item.outgoing_date`]="{ item }">
            {{ getFormatDate(item.outgoing_date, "YYYY-MM-DD") }}</template
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
                  <v-icon>mdi-delete</v-icon>
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
                >Deduct Supply</span
              >
              <v-spacer></v-spacer>
              <v-icon :small="$vuetify.breakpoint.xsOnly" text @click="cancel"
                >mdi-close
              </v-icon>
            </v-toolbar>
            <v-card-text style="height: auto">
              <v-row class="mt-4 px-1">
                <v-col class="py-0" cols="12" xl="12" lg="12" sm="12" md="12">
                  <v-text-field v-model="form.id" class="d-none" dense>
                    <template slot="label">
                      <div style="font-size: 12px">ID</div>
                    </template>
                  </v-text-field>
                </v-col>

                <v-col
                  class="tfield py-0 px-1"
                  cols="12"
                  xl="12"
                  lg="12"
                  sm="12"
                  md="12"
                >
                  <!-- Quantity -->
                  <v-text-field
                    :rules="formRulesQuantity"
                    v-model="form.quantity"
                    dense
                    autocomplete="off"
                    @focus="clearQ"
                    @blur="resetQ"
                    @keydown="quantityKeydown($event)"
                    counter
                    maxlength="3"
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
                      Ok
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
                  Ok
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
import template from "../template.vue";
export default {
  components: { template },
  middleware: "auth",
  metaInfo() {
    return { title: "Inventory" };
  },
  //Computed
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
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
    category: "",
    table: [],
    suppcatlist: [],
    suppnamelist: [],

    //Form rules
    formRules: [(v) => !!v || "This is required"],
    formRulesQuantity: [
      (v) => !!v || "This is required",
      (v) => /^[1-9][0-9]*$/.test(v) || "Quantity must be valid",
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
      quantity: 1,
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
        value: "supply_full",
        class: "black--text",
        width: "20%",
      },
      {
        text: "UNIT",
        value: "supply_name.unit",
        filterable: false,
        class: "black--text",
        width: "10%",
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
        text: "AMT",
        value: "outgoing_amount",
        align: "right",
        filterable: false,
        class: "black--text",
        width: "15%",
      },
      {
        text: "ACTION",
        value: "id",
        align: "center",
        sortable: false,
        filterable: false,
        class: "black--text",
        width: "10%",
      },
    ],
    page: 1,
    pageCount: 0,
    itemsPerPage: 10,
    dateFrom: null,
    dateUntil: null,
    date1: false,
    date2: false,
    date3: false,
    getQuantity: 0,
  }),

  //Onload
  created() {
    if (this.user.permissionslist.includes("Access Branch Inventory")) {
      this.get();
      this.suppCat();
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

    resetQ() {
      if (this.form.quantity == null) {
        this.form.quantity = 1;
      }
    },

    clearQ() {
      if (this.form.quantity == 1) {
        this.form.quantity = null;
      }
    },

    //Saving data to database
    async save() {
      if (this.$refs.form.validate()) {
        //Validate first before compare
        if (this.getQuantity < this.form.quantity) {
          this.snackbar = {
            active: true,
            iconText: "alert-circle",
            iconColor: "error",
            message: "Insufficient stocks.",
          };
          return;
        }
        if (this.user.permissionslist.includes("Access Branch Inventory")) {
          this.form.branch = this.user.branch;
        }
        //Save or update data in the table
        await axios.post("/api/suppinven/save", this.form).then((result) => {
          //If the value is true then save to database
          this.snackbar = {
            active: true,
            iconText: "check",
            iconColor: "success",
            message: "Successfully saved.",
          };
          this.get();
          this.cancel();
        });
      }
    },

    //For retrieving supplies inventory
    async get() {
      this.progressbar = true; // Show the progress bar
      // Get data from tables
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;

      await axios
        .get("/api/suppinven/get", {
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
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    //For retrieving supply categories
    async suppCat() {
      await axios.get("/api/osupp/suppCat").then((supp_cat) => {
        this.suppcatlist = supp_cat.data;
      });
    },

    //For retrieving supply names
    async suppName() {
      this.form.supply_name = null;
      await axios
        .get("/api/osupp/suppName", {
          params: { category: this.form.category },
        })
        .then((supp_name) => {
          this.suppnamelist = supp_name.data;
        });
    },

    //Editing/updating of row
    edit(row) {
      this.getQuantity = row.quantity;
      this.form.category = row.category.id;
      this.form.supply_name = row.supply_name.id;
      this.form.ref = row.id;
      this.dialog = true;
    },

    //Open Dialog Form
    openDialog() {
      this.$refs.form.reset();
      this.dialog = true;
    },

    //Reset Forms
    cancel() {
      this.quantity = 1;
      this.dialog = false;
    },

    //For refresh
    refresh() {
      this.get();
      this.suppCat();
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