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
            >Masterlist Products</v-btn
          >
        </v-card-actions>
      </v-layout>
    </v-container>

    <!-- Main Card -->
    <v-card elevation="1" class="mt-2" style="border-radius: 10px">
      <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
        <v-card-actions class="px-0">
          <v-row align="center" no-gutters>
            <!-- Add Buttons -->
            <v-btn
              color="primary"
              style="text-transform: none"
              depressed
              dark
              :small="$vuetify.breakpoint.smAndDown"
              @click="openDialog"
            >
              Add Product
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
                        placeholder="Product Name"
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
                        :items="prodcatlist"
                        item-text="product_cat_name"
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

                  <!-- Subcategory Field -->
                  <v-col cols="4"
                    ><span class="text-caption text-xl-subtitle-2"
                      >Subcategory</span
                    ></v-col
                  >
                  <v-col cols="8">
                    <v-card-actions class="px-0">
                      <v-select
                        hide-details
                        v-model="subcategory"
                        :items="prodsubcatlist"
                        item-text="prod_sub_cat_name"
                        item-value="id"
                        clearable
                        dense
                        placeholder="Subcategory"
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
          <template v-slot:[`item.product_name`]="{ item }"
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
              <span v-if="item.days >= 1 && item.days < 8">Nearly Expired</span>
              <span v-else-if="item.days < 1">Expired</span> </v-tooltip
            >{{ item.product_name }} {{ item.description }}</template
          >
          <template v-slot:[`item.diff_quantity`]="{ item }">
            <div v-if="item.diff_quantity <= item.critical_limit">
              {{ item.diff_quantity
              }}<v-tooltip bottom>
                <template #activator="data"
                  ><v-icon v-on="data.on" color="red">mdi-alert</v-icon>
                </template>
                <span>Critical State</span>
              </v-tooltip>
            </div>
            <div v-else>
              {{ item.diff_quantity }}
            </div>
          </template>
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

      <!-- Dialog Form -->
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
                >Product</span
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
                  class="tfield py-0 px-1"
                  cols="12"
                  xl="6"
                  lg="6"
                  sm="6"
                  md="6"
                >
                  <!-- Product Category -->
                  <v-select
                    :rules="formRulesNumberRange"
                    v-model="form.category"
                    :items="prodcatlist"
                    dense
                    item-text="product_cat_name"
                    item-value="id"
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
                  </v-select>
                </v-col>

                <v-col
                  class="tfield py-0 px-1"
                  cols="12"
                  xl="6"
                  lg="6"
                  sm="6"
                  md="6"
                >
                  <!-- Product Subcategory -->
                  <v-select
                    :rules="formRulesNumberRange"
                    v-model="form.sub_category"
                    :items="prodsubcatlist"
                    dense
                    item-text="prod_sub_cat_name"
                    item-value="id"
                    background-color="white"
                    flat
                    solo
                    style="font-size: 12px"
                  >
                    <template slot="label">
                      <div style="font-size: 12px">
                        Subcategory <span style="color: red">*</span>
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
                  <!-- Product Name -->
                  <v-text-field
                    :rules="formRules"
                    v-model="form.product_name"
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
                        Product Name <span style="color: red">*</span>
                      </div>
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
                  class="tfield py-0 px-1"
                  cols="6"
                  xl="6"
                  lg="6"
                  sm="6"
                  md="6"
                >
                  <v-layout align-center>
                    <!-- VAT -->
                    <v-text-field
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
                      class="shrink pt-0 mt-0 mb-7 ml-3 d-none"
                      color="red darken-3"
                      @change="compute"
                    ></v-checkbox>
                  </v-layout>
                </v-col>

                <v-col
                  class="tfield py-0 px-1"
                  cols="6"
                  xl="6"
                  lg="6"
                  sm="6"
                  md="6"
                >
                  <!-- Price -->
                  <v-text-field
                    :rules="formRulesPrice"
                    v-model="form.price"
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
                        Price <span style="color: red">*</span>
                      </div>
                    </template>
                  </v-text-field>
                </v-col>

                <v-col
                  class="tfield py-0 px-1 d-none"
                  cols="12"
                  xl="12"
                  lg="12"
                  sm="12"
                  md="12"
                >
                  <!-- Price w/ VAT -->
                  <v-text-field
                    disabled
                    v-model="form.without_vat"
                    clearable
                    dense
                    background-color="white"
                    flat
                    solo
                    style="font-size: 12px"
                  >
                    <template slot="label">
                      <div style="font-size: 12px">Price w/ VAT</div>
                    </template>
                  </v-text-field>
                </v-col>

                <v-col
                  class="tfield py-0 px-1"
                  cols="6"
                  xl="6"
                  lg="6"
                  sm="6"
                  md="6"
                >
                  <!-- Critical Limit -->
                  <v-text-field
                    :rules="formRulesPrice"
                    v-model="form.critical_limit"
                    clearable
                    dense
                    @keydown="numberKeydown($event)"
                    counter
                    maxlength="8"
                    background-color="white"
                    flat
                    solo
                    style="font-size: 12px"
                  >
                    <template slot="label">
                      <div style="font-size: 12px">
                        Critical Limit<span style="color: red">*</span>
                      </div>
                    </template>
                  </v-text-field>
                </v-col>

                <!-- Date Picker -->
                <v-col
                  class="tfield py-0 px-1"
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
                      <v-text-field
                        :prepend-inner-icon="
                          showIcon ? 'mdi-calendar-range' : ''
                        "
                        hide-details
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
                          <div style="font-size: 12px">Expiration Date</div>
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
    return { title: "Products" };
  },

  //Data
  data: () => ({
    progressbar: false,
    snackbar: {
      active: false,
      message: "",
    },
    search: "",
    category: "",
    subcategory: "",
    button: false,
    dialog: false,
    sheet: false,
    status: [
      { name: "Available", id: 1 },
      { name: "Unavailable", id: 0 },
    ],
    table: [],
    prodcatlist: [],
    prodsubcatlist: [],
    filterDialog: false,
    date: null,
    menu: false,

    //Form rules
    formRules: [
      (v) => (!!v && v.length >= 3) || "This is required",
      (v) =>
        /^(?:([A-Za-z])(?!\1{2})|([0-9])(?!\2{7})|([\s,'-_/])(?!\3{1}))+$/i.test(
          v
        ) || "This field must have a valid value",
    ],
    formRulesQuantity: [
      (v) => !!v || "This is required",
      (v) => /^[1-9][0-9]*$/.test(v) || "Quantity must be valid",
    ],
    formRulesDesc: [
      (v) =>
        /^$|^(?:([A-Za-z])(?!\1{2})|([0-9])(?!\2{7})|([\s,'-_/.()])(?!\3{1}))+$/i.test(
          v
        ) || "This field must have a valid value",
    ],
    formRulesNumberRange: [
      (v) => {
        if (!isNaN(parseFloat(v)) && v >= 0 && v <= 9999999) return true;
        return "This is required";
      },
    ],
    formRulesPrice: [
      (v) => !!v || "This is required",
      (v) => /^[1-9]\d{0,7}(?:\.\d{1,4})?$/.test(v) || "Price must be valid",
    ],
    formRulesNumber: [
      (v) => Number.isInteger(Number(v)) || "The value must be an integer",
    ],

    //Form Data
    form: {
      id: null,
      status: null,
      category: null,
      sub_category: null,
      product_name: null,
      description: null,
      price: null,
      vat: null,
      without_vat: null,
      critical_limit: null,
      exp_date: null,
    },
    temp_vat: null,
    vat: true,

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
        value: "category.product_cat_name",
        filterable: false,
        class: "black--text",
        width: "15%",
      },
      {
        text: "SUBCATEGORY",
        value: "sub_category.prod_sub_cat_name",
        filterable: false,
        class: "black--text",
        width: "15%",
      },
      { text: "PRODUCT-NAME", value: "product_name", class: "black--text", width: "15%", },
      {
        text: "PRICE",
        value: "format_price",
        align: "right",
        filterable: false,
        class: "black--text",
        width: "10%",
      },
      {
        text: "WITHOUT VAT",
        value: "without_vat",
        align: "right",
        filterable: false,
        class: "black--text",
        width: "10%",
      },
      {
        text: "STOCKS ON HAND",
        value: "diff_quantity",
        align: "right",
        filterable: false,
        class: "black--text",
        width: "10%",
      },
      {
        text: "STATUS",
        value: "status",
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
        width: "10%",
      },
    ],
    page: 1,
    pageCount: 0,
    disabled: true,
    itemsPerPage: 10,
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
  },

  //Onload
  created() {
    if (this.user.permissionslist.includes("Access Products")) {
      this.get();
      this.prodCat();
      this.prodSubCat();
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
          } else if (key == "exp_date") {
            if (
              this.getFormatDate(this.currentdata.exp_date, "YYYY-MM-DD") !=
              this.getFormatDate(this.form.exp_date, "YYYY-MM-DD")
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
      if (this.temp_vat == null) {
        this.snackbar = {
          active: true,
          iconText: "alert",
          iconColor: "error",
          message: "Set the VAT first.",
        };
      } else {
        this.compute();
        if (this.$refs.form.validate()) {
          //Validate first before compare
          if (this.compare()) {
            //Save or update data in the table
            await axios
              .post("/api/mprod/save", this.form)
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
                      message: "The product name already exists.",
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
      }
    },

    //For retrieving masterlist products
    async get() {
      this.progressbar = true; //Show the progress bar
      //Get data from tables
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;
      await axios
        .get("/api/mprod/get", {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,
            search: this.search,
            category: this.category,
            subcategory: this.subcategory,
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

    //For retrieving product categories
    async prodCat() {
      await axios.get("/api/mprod/prodCat").then((prod_cat) => {
        this.prodcatlist = prod_cat.data;
      });
    },

    //For retrieving product subcategories
    async prodSubCat() {
      await axios.get("/api/mprod/prodSubCat").then((prodsub_cat) => {
        this.prodsubcatlist = prodsub_cat.data;
      });
    },

    getFormatDate(e, format) {
      const date = moment(e);
      return date.format(format);
    },

    //For computing price with VAT
    async compute() {
      this.form.without_vat = (this.form.price / this.temp_vat).toFixed(2);
      this.form.vat = this.temp_vat;
      this.getVat();
    },

    //Editing/updating of row
    edit(row) {
      this.currentdata = JSON.parse(JSON.stringify(row));
      this.form.id = row.id;
      this.form.status = row.status;
      this.form.category = row.category.id;
      this.form.sub_category = row.sub_category.id;
      this.form.product_name = row.product_name;
      this.form.description = row.description;
      this.form.price = row.price;
      this.form.vat = row.vat;
      this.vat = true;
      this.temp_vat = row.vat;
      this.form.without_vat = row.without_vat;
      this.form.critical_limit = row.critical_limit;
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

    //For retrieving VAT
    async getVat() {
      await axios
        .get("/api/settings/vat/get", { params: { type: "p" } })
        .then((result) => {
          this.temp_vat = result.data.vat;
        });
    },

    //Reset Forms
    cancel() {
      for (var key in this.form) {
        if (key == "vat") {
          this.getVat();
        } else {
          this.form[key] = "";
        }
      }
      this.dialog = false;
    },

    //For refresh
    refresh() {
      this.get();
      this.prodCat();
      this.prodSubCat();
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
