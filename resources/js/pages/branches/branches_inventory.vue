<template>
  <div style="min-width: 280px">
    <v-container>
      <v-layout row wrap>
        <span
          class="
            text-h6 text-xl-h5 text-lg-h5 text-md-h6 text-sm-h6
            font-weight-bold
            my-auto
          "
        >
          Branches
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
            >Branches Inventory</v-btn
          >
        </v-card-actions>
      </v-layout>
    </v-container>

    <v-card elevation="6" class="mt-2" style="border-radius: 10px">
      <v-tabs
        slider-size="4"
        v-model="tab"
        color="red darken-2"
        :height="height"
        show-arrows
        center-active
        centered
      >
        <v-tabs-slider style="display: none"></v-tabs-slider>
        <v-tab
          class="
            text-body-2
            text-xl-subtitle-1
            text-lg-subtitle-1
            text-md-subtitle-2
            text-sm-body-1
          "
          style="text-transform: none"
          >Supplies Inventory</v-tab
        >
        <v-tab
          class="
            text-body-2
            text-xl-subtitle-1
            text-lg-subtitle-1
            text-md-subtitle-2
            text-sm-body-1
          "
          style="text-transform: none"
          >Products List</v-tab
        >
      </v-tabs>

      <v-tabs-items v-model="tab">
        <!-- Branch Supplies Inventory -->
        <v-tab-item>
          <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
            <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
              <v-list dense nav class="px-0 py-1">
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
                      <v-col
                        cols="4"
                        xl="2"
                        lg="2"
                        md="3"
                        sm="4"
                        class="my-auto"
                      >
                        <v-card-actions>
                          <v-select
                            style="max-width: 82px"
                            dense
                            v-model="itemsPerPage1"
                            label="Items per page"
                            @change="itemperpage1"
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
                            v-model="search1"
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
                                @click="getSupplies"
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
                      <v-col
                        cols="6"
                        xl="2"
                        lg="2"
                        md="4"
                        sm="6"
                        class="my-auto"
                      >
                        <v-card-actions class="py-0">
                          <v-select
                            :items="branchlist"
                            v-model="branch1"
                            item-text="branch_name"
                            item-value="id"
                            class="my-0"
                            clearable
                            dense
                            @change="getSupplies"
                            label="Branch"
                          >
                          </v-select>
                        </v-card-actions>
                      </v-col>

                      <!-- Category Field -->
                      <v-col
                        cols="6"
                        xl="2"
                        lg="2"
                        md="4"
                        sm="6"
                        class="my-auto"
                      >
                        <v-card-actions class="py-0">
                          <v-select
                            :items="suppcatlist"
                            item-text="supply_cat_name"
                            item-value="id"
                            class="my-0"
                            v-model="category1"
                            @change="getSupplies"
                            clearable
                            dense
                            label="Category"
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
                :headers="headers1"
                :items="table1.data"
                :loading="progressbar"
                :page.sync="page1"
                ref="progress"
                :items-per-page="itemsPerPage1"
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
                  >{{ item.supply_name.supply_name }}
                  {{ item.supply_name.description }}</template
                >
                <template v-slot:[`item.count`]="{ item }">
                  {{ item.row }}</template
                >
              </v-data-table>

              <!-- Paginate -->
              <div class="text-center pt-2">
                <v-pagination
                  v-model="page1" 
                  :length="table1.last_page"
                  color="red darken-2"
                ></v-pagination>
              </div>
            </v-container>
          </v-container>
        </v-tab-item>

        <!-- Branch Products List -->
        <v-tab-item>
          <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
            <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
              <v-list dense nav class="px-0 py-1">
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
                      <v-col
                        cols="4"
                        xl="2"
                        lg="2"
                        md="3"
                        sm="4"
                        class="my-auto"
                      >
                        <v-card-actions>
                          <v-select
                            style="max-width: 82px"
                            dense
                            v-model="itemsPerPage2"
                            label="Items per page"
                            @change="itemperpage2"
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
                            v-model="search2"
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
                                @click="getProducts"
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
                      <v-col
                        cols="6"
                        xl="2"
                        lg="2"
                        md="4"
                        sm="6"
                        class="my-auto"
                      >
                        <v-card-actions class="py-0">
                          <v-select
                            :items="branchlist"
                            v-model="branch2"
                            item-text="branch_name"
                            item-value="id"
                            class="my-0"
                            clearable
                            dense
                            @change="getProducts"
                            label="Branch"
                          >
                          </v-select>
                        </v-card-actions>
                      </v-col>

                      <!-- Category Field -->
                      <v-col
                        cols="6"
                        xl="2"
                        lg="2"
                        md="4"
                        sm="6"
                        class="my-auto"
                      >
                        <v-card-actions class="py-0">
                          <v-select
                            :items="prodcatlist"
                            item-text="product_cat_name"
                            item-value="id"
                            class="my-0"
                            v-model="category2"
                            @change="getProducts"
                            clearable
                            dense
                            label="Category"
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
                :headers="headers2"
                :items="table2.data"
                :loading="progressbar"
                :page.sync="page2"
                ref="progress"
                :items-per-page="itemsPerPage2"
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
                <template v-slot:[`item.product_full`]="{ item }"
                  >{{ item.product_name.product_name }}
                  {{ item.product_name.description }}</template
                >
                <template v-slot:[`item.count`]="{ item }">
                  {{ item.row }}</template
                >
              </v-data-table>

              <!-- Paginate -->
              <div class="text-center pt-2">
                <v-pagination
                  v-model="page2"
                  :total-visible="5"
                  :length="table2.last_page"
                  color="red darken-2"
                ></v-pagination>
              </div>
            </v-container>
          </v-container>
        </v-tab-item>
      </v-tabs-items>
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
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),

    height() {
      switch (this.$vuetify.breakpoint.name) {
        case "xs":
          return 35;
        default:
          return 42;
      }
    },
  },
  data: () => ({
    progressbar: false,
    search1: "",
    search2: "",
    branch1: "",
    branch2: "",
    category1: "",
    category2: "",
    loading: false,
    tab: null,
    table1: [],
    table2: [],
    suppcatlist: [],
    prodcatlist: [],
    prodsubcatlist: [],
    branchlist: [],
    // Table Headers 1
    headers1: [
      {
        text: "#",
        value: "count",
        align: "start",
        filterable: false,
        class: "black--text",
      },
      {
        text: "BRANCH",
        value: "requesting_branch.branch_name",
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
        text: "SUPPLIER",
        value: "supply_name.supplier_name_details.supplier_name",
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
        text: "QTY",
        value: "quantity",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "TOTAL AMT",
        value: "outgoing_amount",
        align: "right",
        filterable: false,
        class: "black--text",
      },
    ],

    // Table Headers 2
    headers2: [
      {
        text: "#",
        value: "count",
        align: "start",
        filterable: false,
        class: "black--text",
      },
      {
        text: "BRANCH",
        value: "requesting_branch.branch_name",
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
        value: "product_full",
        class: "black--text",
      },
      {
        text: "QTY",
        value: "quantity",
        align: "right",
        class: "black--text",
      },
      {
        text: "TOTAL AMT",
        value: "outgoing_amount",
        align: "right",
        class: "black--text",
      },
    ],
    page1: 1,
    page2: 1,
    pageCount: 0,
    itemsPerPage1: 5,
    itemsPerPage2: 5,
  }),

    watch:{
      page1(val) {
          this.page1 = val;
          this.getSupplies();
        },
         page2(val) {
          this.page1 = val;
          this.getProducts();
        },
    },
  // Onload
  created() {
    if (this.user.permissionslist.includes("Access Branches")) {
      this.getSupplies();
      this.getProducts();
      this.suppCat();
      this.branchName();
      this.prodCat();
    } else {
      this.$router.push({ name: "invalid-page" }).catch((errr) => {});
    }
  },

  methods: {
    itemperpage1() {
      this.page1 = 1;
      this.getSupplies();
    },

    itemperpage2() {
      this.page2 = 1;
      this.getProducts();
    },

    async getSupplies() {
      this.progressbar = true;
      this.itemsPerPage1 = parseInt(this.itemsPerPage1) ?? 0;
      await axios
        .get("/api/branches/inventory/get", {
          params: {
            branch: this.branch1,
            category: this.category1,
            page: this.page1,
            itemsPerPage: this.itemsPerPage1,
            search: this.search1,
          },
        })
        .then((result) => { 
          this.table1 = result.data;
          this.progressbar = false;
        });
    },

    async getProducts() {
      this.progressbar = true;
      this.itemsPerPage2 = parseInt(this.itemsPerPage2) ?? 0;
      await axios
        .get("/api/branches/inventory/get2", {
          params: {
            branch: this.branch2,
            category: this.category2,
            page: this.page2,
            itemsPerPage: this.itemsPerPage2,
            search: this.search2,
          },
        })
        .then((result) => {
          this.table2 = result.data;
          this.progressbar = false;
        });
    },

    async suppCat() {
      await axios.get("/api/branches/inventory/suppCat").then((supp_cat) => {
        this.suppcatlist = supp_cat.data;
      });
    },

    async branchName() {
      await axios
        .get("/api/branches/inventory/branchName")
        .then((bran_name) => {
          this.branchlist = bran_name.data;
        });
    },

    async prodCat() {
      await axios.get("/api/branches/inventory/prodCat").then((prod_cat) => {
        this.prodcatlist = prod_cat.data;
      });
    },
  },
};
</script>