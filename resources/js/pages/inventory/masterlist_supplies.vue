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
            >Masterlist Supplies</v-btn
          >
        </v-card-actions>
      </v-layout>
    </v-container>

    <!-- Main Card -->
    <v-card elevation="1" class="mt-2" style="border-radius: 10px">
      <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
        <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
          <v-card-actions class="px-0">
            <v-row no-gutters>
              <!-- Add Button -->
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
              <!-- Refresh -->
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
              <!-- Filter -->
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
                        :items="[
                          1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15,
                        ]"
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

                  <!-- Supplier Field -->
                  <v-col cols="4"
                    ><span class="text-caption text-xl-subtitle-2"
                      >Supplier</span
                    ></v-col
                  >
                  <v-col cols="8">
                    <v-card-actions class="px-0">
                      <v-select
                        hide-details
                        v-model="supplier"
                        :items="supplierlist"
                        item-text="supplier_name"
                        item-value="id"
                        clearable
                        dense
                        placeholder="Supplier"
                        @change="get"
                        background-color="grey darken-3"
                        flat
                        solo
                        style="font-size: 12px"
                      >
                      </v-select>
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
              </v-card>
            </v-dialog>
          </v-card-actions>

          <!-- :item-class="itemRowBackground" -->
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
            class="table-striped border"
          >
            <!-- Progress Bar -->
            <v-progress-linear
              color="red darken-2"
              class="px-0 mx-0"
              slot="progress"
              indeterminate
              rounded
            ></v-progress-linear>
            <template v-slot:[`item.supply_name`]="{ item }"
              ><v-tooltip bottom>
                <template #activator="data"
                  ><v-icon
                    v-on="data.on"
                    :hidden="
                      item.days != null
                        ? item.days < 8
                          ? item.days < 1
                            ? false
                            : false
                          : false
                        : true
                    "
                    :color="
                      item.days != null
                        ? item.days < 8
                          ? item.days < 1
                            ? 'red'
                            : 'orange'
                          : ''
                        : ''
                    "
                    >mdi-alert-circle
                  </v-icon></template
                >
                <span v-if="item.days >= 1 && item.days < 8"
                  >Nearly Expired</span
                >
                <span v-else-if="item.days < 1">Expired</span> </v-tooltip
              >{{ item.supply_name }} {{ item.description }}
            </template>
            <template v-slot:[`item.count`]="{ item }">
              {{ item.row }}</template
            >
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
          <div class="pbutton text-center pt-7">
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
            max-width="700px"
            persistent
            no-click-animation
          >
            <v-card tile class="pa-3">
              <v-toolbar dark dense flat rounded class="red darken-3">
                Supply
                <v-spacer></v-spacer>
                <v-icon text @click="cancel">mdi-close </v-icon>
              </v-toolbar>
              <v-container class="px-1">
                <v-row no-gutters>
                  <v-col
                    cols="12"
                    xl="6"
                    lg="6"
                    md="6"
                    sm="12"
                    class="pl-0 pr-0 pr-lg-2 pr-md-2 pr-sm-2 py-4"
                  >
                    <v-row>
                      <v-col
                        class="tfield py-0"
                        cols="12"
                        xl="12"
                        lg="12"
                        sm="12"
                        md="12"
                      >
                        <!-- ID -->
                        <v-text-field v-model="form.id" class="d-none" dense>
                          <template slot="label">
                            <div style="font-size: 12px">ID</div>
                          </template>
                        </v-text-field>

                        <!-- Status -->
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
                        <!-- Supplier -->
                        <v-select
                          :rules="formRules1"
                          v-model="form.supplier"
                          dense
                          :items="supplierlist"
                          item-text="supplier_name"
                          return-object
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
                        class="tfield py-0"
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
                          :items="suppcatlist"
                          dense
                          item-text="supply_cat_name"
                          item-value="id"
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
                        class="tfield py-0"
                        cols="12"
                        xl="12"
                        lg="12"
                        sm="12"
                        md="12"
                      >
                        <!-- Supply Name -->
                        <v-text-field
                          :rules="formRules"
                          v-model="form.supply_name"
                          clearable
                          dense
                          counter
                          @keydown="valueKeydown($event)"
                          maxlength="35"
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
                        </v-text-field>
                      </v-col>
                    </v-row>
                  </v-col>

                  <v-col
                    cols="12"
                    xl="6"
                    lg="6"
                    md="6"
                    sm="12"
                    class="pl-0 pl-xl-2 pl-lg-2 pl-md-2 pl-sm-2 pr-0 py-4"
                  >
                    <v-row>
                      <v-col
                        class="tfield py-0 pr-1"
                        cols="6"
                        xl="6"
                        lg="6"
                        sm="6"
                        md="6"
                      >
                        <!-- Description -->
                        <v-text-field
                          :rules="formRulesDesc"
                          v-model="form.description"
                          clearable
                          dense
                          counter
                          @keydown="descKeydown($event)"
                          maxlength="35"
                          background-color="white"
                          flat
                          solo
                          style="font-size: 12px"
                        >
                          <template slot="label">
                            <div style="font-size: 12px">Description</div>
                          </template>
                        </v-text-field>
                      </v-col>
                      <v-col
                        class="tfield py-0 pl-1"
                        cols="6"
                        xl="6"
                        lg="6"
                        sm="6"
                        md="6"
                      >
                        <!-- Unit -->
                        <v-select
                          :items="unit"
                          :rules="formRulesUnit"
                          v-model="form.unit"
                          dense
                          background-color="white"
                          flat
                          solo
                          style="font-size: 12px"
                        >
                          <template slot="label">
                            <div style="font-size: 12px">
                              Unit <span style="color: red">*</span>
                            </div>
                          </template>
                        </v-select>
                      </v-col>

                      <v-col
                        class="tfield py-0 pr-1"
                        cols="6"
                        xl="6"
                        lg="6"
                        sm="6"
                        md="6"
                      >
                        <!-- Net Price -->
                        <v-text-field
                          :rules="formRulesPrice"
                          v-model="form.net_price"
                          clearable
                          dense
                          counter
                          @keydown="numberKeydown($event)"
                          @input="compute"
                          @click:clear="compute"
                          maxlength="15"
                          background-color="white"
                          flat
                          solo
                          style="font-size: 12px"
                        >
                          <template slot="label">
                            <div style="font-size: 12px">
                              Net Price <span style="color: red">*</span>
                            </div>
                          </template>
                        </v-text-field>
                      </v-col>

                      <v-col
                        class="tfield py-0 pl-1"
                        cols="6"
                        xl="6"
                        lg="6"
                        sm="6"
                        md="6"
                      >
                        <v-layout align-center>
                          <!-- VAT -->
                          <v-text-field
                            :rules="formRulesVAT"
                            v-model="temp_vat"
                            disabled
                            clearable
                            dense
                            @keydown="numberKeydown($event)"
                            background-color="white"
                            flat
                            solo
                            style="font-size: 12px"
                          >
                            <template slot="label">
                              <div style="font-size: 12px">VAT</div>
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
                        class="tfield py-0 d-none"
                        cols="6"
                        xl="6"
                        lg="6"
                        sm="6"
                        md="6"
                      >
                        <!-- Price w/o VAT -->
                        <v-text-field disabled outlined clearable dense>
                          <template slot="label">
                            <div style="font-size: 12px">Price w/o VAT</div>
                          </template>
                        </v-text-field>
                      </v-col>

                      <v-col
                        class="tfield py-0 pr-1"
                        cols="6"
                        xl="6"
                        lg="6"
                        sm="6"
                        md="6"
                      >
                        <!-- Lead Time -->
                        <v-text-field
                          :rules="formRulesOthers"
                          v-model="form.lead_time"
                          clearable
                          dense
                          counter
                          @keydown="numberKeydown($event)"
                          @input="compute"
                          @click:clear="compute"
                          maxlength="5"
                          background-color="white"
                          flat
                          solo
                          style="font-size: 12px"
                        >
                          <template slot="label">
                            <div style="font-size: 12px">Lead Time</div>
                          </template>
                        </v-text-field>
                      </v-col>
                      <v-col
                        class="tfield py-0 pl-1"
                        cols="6"
                        xl="6"
                        lg="6"
                        sm="6"
                        md="6"
                      >
                        <!-- Min Order Qty -->
                        <v-text-field
                          :rules="formRulesOthers"
                          v-model="form.minimum_order_quantity"
                          clearable
                          dense
                          counter
                          @keydown="numberKeydown($event)"
                          maxlength="5"
                          background-color="white"
                          flat
                          solo
                          style="font-size: 12px"
                        >
                          <template slot="label">
                            <div style="font-size: 12px">Min Order Qty</div>
                          </template>
                        </v-text-field>
                      </v-col>
                      <v-col
                        class="tfield py-0 pr-1"
                        cols="6"
                        xl="6"
                        lg="6"
                        sm="6"
                        md="6"
                      >
                        <!-- Order Frequency -->
                        <v-text-field
                          :rules="formRulesOthers"
                          v-model="form.order_frequency"
                          clearable
                          dense
                          counter
                          @keydown="numberKeydown($event)"
                          @input="compute"
                          @click:clear="compute"
                          maxlength="5"
                          background-color="white"
                          flat
                          solo
                          style="font-size: 12px"
                        >
                          <template slot="label">
                            <div style="font-size: 12px">Order Frequency</div>
                          </template>
                        </v-text-field>
                      </v-col>
                      <v-col
                        class="tfield py-0 pl-1"
                        cols="6"
                        xl="6"
                        lg="6"
                        sm="6"
                        md="6"
                      >
                        <v-menu
                          v-model="menu"
                          :close-on-content-click="false"
                          :nudge-right="35"
                          transition="scale-transition"
                          offset-y
                          min-width="290px"
                        >
                          <template v-slot:activator="{ on }">
                            <!-- Expiration Date -->
                            <v-text-field
                              :prepend-inner-icon="
                                showIcon ? 'mdi-calendar-range' : ''
                              "
                              v-model="form.exp_date"
                              label=""
                              readonly
                              v-on="on"
                              class="py-0"
                              dense
                              clearable
                              background-color="white"
                              flat
                              solo
                              style="font-size: 12px"
                            >
                              <template slot="label">
                                <div style="font-size: 12px">
                                  Expiration Date
                                </div>
                              </template>
                            </v-text-field>
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
                    </v-row>
                  </v-col>
                </v-row>
              </v-container>
              <v-divider class="my-0"></v-divider>
              <!-- Dialog Form Buttons -->
              <v-card-actions class="px-0 pb-0">
                <v-spacer></v-spacer>
                <v-btn
                  color="error"
                  depressed
                  :disabled="button"
                  dark
                  @click="cancel"
                  :small="$vuetify.breakpoint.smAndDown"
                  text
                >
                  Cancel
                </v-btn>
                <v-btn
                  color="primary"
                  depressed
                  :disabled="button"
                  dark
                  @click="save"
                  :small="$vuetify.breakpoint.smAndDown"
                  text
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

<!-- Style -->
<style>
/* #table1 .style-1 {
  color: #fb8c00;
}
#table1 .style-2 {
  color: #e53935;
} */

#table1 .v-data-table-header th {
  white-space: nowrap;
}
#table1 .v-data-table-header th {
  font-size: 12px !important;
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
    sheet: false,
    unit: [
      "pack",
      "bot",
      "can",
      "bar",
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
    filterDialog: false,
    status: [
      { name: "Available", id: 1 },
      { name: "Unavailable", id: 0 },
    ],
    supply_id: "",
    disable: "",
    table: [],
    supplier: "",
    category: "",
    suppcatlist: [],
    suppnamelist: [],
    dayslist: [],
    date: null,
    menu: false,

    //Form Rules
    formRules: [
      (v) => (!!v && v.length >= 3) || "This is required",
      (v) =>
        /^(?:([A-Za-z])(?!\1{2})|([0-9])(?!\2{7})|([\s,'-_/])(?!\3{1}))+$/i.test(
          v
        ) || "This field must have a valid value",
    ],
    formRules1: [(v) => !!v || "This is required"],
    //Form Rules
    formRulesUnit: [(v) => (!!v && v.length >= 2) || "This is required"],
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
      (v) => /^[0-9]\d{0,7}(?:\.\d{1,4})?$/.test(v) || "VAT must be valid",
    ],
    formRulesOthers: [
      (v) =>
        /^$|^([0-9]\d{0,7}(?:\.\d{1,4})?)+$/.test(v) ||
        "This field must be valid",
    ],
    formRulesNumberRange: [
      (v) => {
        if (!isNaN(parseFloat(v)) && v >= 0 && v <= 9999999) return true;
        return "This is required";
      },
    ],

    //Form Data
    form: {
      id: null,
      status: [
        { name: "Available", id: 1 },
        { name: "Unavailable", id: 0 },
      ],
      supply_name: "",
      supplier: null,
      category: "",
      description: "",
      unit: "",
      net_price: "",
      vat: "",
      exp_date: "",
      vatable: 0,
      lead_time: "",
      order_frequency: "",
      minimum_order_quantity: "",
    },
    temp_vat: null, //form.vat = this.
    vat: false,
    supplierlist: [],

    //For comparing data
    currentdata: {},

    //Table Headers
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
      { text: "SUPPLY NAME", value: "supply_name", class: "black--text" },
      { text: "UNIT", value: "unit", sortable: true, class: "black--text" },
      {
        text: "NET PRICE",
        value: "format_net_price",
        align: "right",
        sortable: true,
        class: "black--text",
      },
      {
        text: "WITH VAT",
        value: "with_vat_price",
        align: "right",
        sortable: true,
        class: "black--text",
      },
      {
        text: "WITHOUT VAT",
        value: "without_vat_price",
        align: "right",
        sortable: true,
        class: "black--text",
      },
      {
        text: "STATUS",
        value: "status",
        align: "center",
        sortable: true,
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
    itemsPerPage: 5,
  }),

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
    disabled() {
      if (this.form.net_price !== null) {
        return true;
      } else {
        return false;
      }
    },
  },

  //Onload
  created() {
    if (this.user.permissionslist.includes("Access Inventory")) {
      this.get();
      this.suppCat();
      this.suppliers();
    } else {
      this.$router.push({ name: "invalid-page" }).catch((errr) => {});
    }
  },

  methods: {
    // itemRowBackground: function (item) {
    //   if (item.days != null) {
    //     if (item.days < 8) {
    //       if (item.days < 1) {
    //         return "style-2";
    //       }
    //       return "style-1";
    //     }
    //   }
    // },
    //Keydown
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

    //For retrieving VAT
    async getVat() {
      await axios
        .get("/api/settings/vat/get", { params: { type: "s" } })
        .then((result) => {
          this.temp_vat = result.data.vat;
        });
    },

    //For retrieving supplier names
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
                parseInt(this.form.supplier.id)
              ) {
                found += 1;
              }
            }
          } else if (key == "net_price") {
            if (
              this.getFormatCurrency(this.currentdata.net_price, "0.00") !=
              this.getFormatCurrency(this.form.net_price, "0.00")
            ) {
              found += 1;
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

    //Saving data to database
    async save() {
      if (this.$refs.form.validate()) {
        this.compute();
        //Validate first before compare
        if (this.compare()) {
          //Save or update data in the table
          await axios
            .post("/api/msupp/save", this.form)
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

    //For retrieving masterlist supplies
    async get() {
      this.progressbar = true; //Show the progress bar
      //Get data from tables
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;
      await axios
        .get("/api/msupp/get", {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,
            search: this.search,
            supplier: this.supplier,
            category: this.category,
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

    //For suppliers info
    async suppliers() {
      await axios.get("/api/msupp/suppliers", {}).then((result) => {
        this.supplierlist = result.data;
      });
    },

    //For adding
    async sum() {
      await axios
        .get("/api/msupp/sum", {
          params: {
            id: this.supply_id,
          },
        })
        .then((result) => {
          //If the value is true then get the data
        })
        .catch((result) => {
          //If false or error when saving
        });
    },

    //For validating item
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
          //If false or error when saving
        });
    },

    //For retrieving supply categories
    async suppCat() {
      await axios.get("/api/msupp/suppCat").then((supp_cat) => {
        this.suppcatlist = supp_cat.data;
      });
    },

    //For computing amount with VAT
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

    getFormatCurrency(e, format) {
      const numbr = numeral(e);
      return numbr.format(format);
    },

    //Editing/updating of row
    edit(row) {
      this.currentdata = JSON.parse(JSON.stringify(row));
      this.form.supplier = row.supplier;
      this.form.id = row.id;
      this.form.status = row.status;
      this.form.category = row.category.id;
      this.form.supply_name = row.supply_name;
      this.form.description = row.description;
      this.form.unit = row.unit;
      this.form.net_price = this.getFormatCurrency(row.net_price, "0.00");
      this.form.vat = row.vat;
      this.vat = row.vatable == 0 ? false : true;
      this.temp_vat = row.vat;
      this.form.lead_time = row.lead_time;
      this.form.order_frequency = row.order_frequency;
      this.form.minimum_order_quantity = row.minimum_order_quantity;
      this.form.exp_date = row.exp_date
        ? this.getFormatDate(row.exp_date, "YYYY-MM-DD")
        : "";

      this.dialog = true;
      this.compute();
    },

    //Open Dialog Form
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

    //Reset Forms
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

  //Watch
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
