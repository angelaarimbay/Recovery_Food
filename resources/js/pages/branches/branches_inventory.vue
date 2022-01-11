<template>
  <!-- Div -->
  <div style="min-width: 310px">
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

    <v-card elevation="1" class="mt-2" style="border-radius: 10px">
      <v-tabs
        slider-size="4"
        color="red darken-2"
        :centered="$vuetify.breakpoint.xsOnly"
        :height="height"
        :class="{ 'pt-2': $vuetify.breakpoint.smAndUp }"
      >
        <v-tabs-slider style="border-radius: 20px 20px 0px 0px"></v-tabs-slider>
        <v-tab
          class="
            text-caption
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
            text-caption
            text-xl-subtitle-1
            text-lg-subtitle-1
            text-md-subtitle-2
            text-sm-body-1
          "
          style="text-transform: none"
          >Products List</v-tab
        >

        <!-- Branch Supplies Inventory -->
        <v-tab-item>
          <v-divider class="my-0"></v-divider>
          <v-container class="py-2 px-3">
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
            </v-card-actions>

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
                        v-model="itemsPerPage1"
                        @change="itemperpage1"
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
                        v-model="search1"
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
                            @click="getSupplies"
                            class="ml-1"
                          >
                            <v-icon>mdi-magnify</v-icon></v-btn
                          >
                        </template>
                        <span>Search</span>
                      </v-tooltip>
                    </v-card-actions>
                  </v-col>

                  <!-- Branch Field -->
                  <v-col cols="4"
                    ><span class="text-caption text-xl-subtitle-2"
                      >Branch</span
                    ></v-col
                  >
                  <v-col cols="8">
                    <v-card-actions class="px-0">
                      <v-select
                        hide-details
                        :items="branchlist"
                        v-model="branch1"
                        item-text="branch_name"
                        item-value="id"
                        clearable
                        dense
                        @change="getSupplies"
                        placeholder="Branch"
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
                        :items="suppcatlist"
                        item-text="supply_cat_name"
                        item-value="id"
                        class="my-0"
                        v-model="category1"
                        @change="getSupplies"
                        clearable
                        dense
                        placeholder="Category"
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

            <!-- Table -->
            <v-data-table
              id="table1"
              :headers="headers1"
              :items="table1.data"
              :loading="progressbar"
              :page.sync="page1"
              ref="progress"
              :items-per-page="itemsPerPage1"
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
              <template v-slot:[`item.supply_full`]="{ item }"
                >{{ item.supply_name.supply_name }}
                {{ item.supply_name.description }}</template
              >
              <template v-slot:[`item.count`]="{ item }">
                {{ item.row }}</template
              >
            </v-data-table>

            <!-- Paginate -->
            <div
              class="
                pbutton
                text-center
                pt-7
                pb-xl-3 pb-lg-3 pb-md-3 pb-sm-2 pb-2
              "
            >
              <v-pagination
                v-model="page1"
                :length="table1.last_page"
                color="red darken-2"
              ></v-pagination>
            </div>
          </v-container>
        </v-tab-item>

        <!-- Branch Products List -->
        <v-tab-item>
          <v-divider class="my-0"></v-divider>
          <v-container class="py-2 px-3">
            <v-card-actions class="px-0">
              <v-row no-gutters>
                <v-spacer></v-spacer>
                <v-card color="red darken-3" flat style="border-radius: 20px">
                  <v-tooltip bottom>
                    <template #activator="data">
                      <v-btn
                        class="mr-2"
                        color="white"
                        depressed
                        :small="$vuetify.breakpoint.smAndDown"
                        dark
                        @click="getProducts"
                        v-on="data.on"
                        icon
                        ><v-icon size="20">mdi-refresh</v-icon></v-btn
                      >
                    </template>
                    <span>Refresh</span>
                  </v-tooltip>
                  <v-tooltip bottom>
                    <template #activator="data">
                      <v-btn
                        color="white"
                        depressed
                        :small="$vuetify.breakpoint.smAndDown"
                        dark
                        @click="filterDialog1 = true"
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
            <v-dialog v-model="filterDialog1" max-width="400px">
              <v-card dark tile class="pa-2">
                <v-toolbar dense flat class="transparent">
                  Search Filter
                  <v-spacer></v-spacer>
                  <v-icon text @click="filterDialog1 = false"
                    >mdi-close
                  </v-icon>
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
                        v-model="itemsPerPage2"
                        @change="itemperpage2"
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
                        v-model="search2"
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
                            @click="getProducts"
                            class="ml-1"
                          >
                            <v-icon>mdi-magnify</v-icon></v-btn
                          >
                        </template>
                        <span>Search</span>
                      </v-tooltip>
                    </v-card-actions>
                  </v-col>

                  <!-- Branch Field -->
                  <v-col cols="4"
                    ><span class="text-caption text-xl-subtitle-2"
                      >Branch</span
                    ></v-col
                  >
                  <v-col cols="8">
                    <v-card-actions class="px-0">
                      <v-select
                        hide-details
                        :items="branchlist"
                        v-model="branch2"
                        item-text="branch_name"
                        item-value="id"
                        clearable
                        dense
                        @change="getProducts"
                        placeholder="Branch"
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
                        :items="prodcatlist"
                        item-text="product_cat_name"
                        item-value="id"
                        v-model="category2"
                        @change="getProducts"
                        clearable
                        dense
                        placeholder="Category"
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

            <!-- Table -->
            <v-data-table
              id="table1"
              :headers="headers2"
              :items="table2.data"
              :loading="progressbar"
              :page.sync="page2"
              ref="progress"
              :items-per-page="itemsPerPage2"
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
              <template v-slot:[`item.product_full`]="{ item }"
                >{{ item.product_name.product_name }}
                {{ item.product_name.description }}</template
              >
              <template v-slot:[`item.count`]="{ item }">
                {{ item.row }}</template
              >
            </v-data-table>

            <!-- Paginate -->
            <div
              class="
                pbutton
                text-center
                pt-7
                pb-xl-3 pb-lg-3 pb-md-3 pb-sm-2 pb-2
              "
            >
              <v-pagination
                v-model="page2"
                :total-visible="7"
                :length="table2.last_page"
                color="red darken-2"
              ></v-pagination>
            </div>
          </v-container>
        </v-tab-item>
      </v-tabs>
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
    return { title: "Branches" };
  },
  //Computed
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
    height() {
      if (this.$vuetify.breakpoint.smAndDown) {
        return 35;
      }
    },
  },

  //Data
  data: () => ({
    progressbar: false,
    search1: "",
    search2: "",
    branch1: "",
    branch2: "",
    category1: "",
    category2: "",
    loading: false,
    table1: [],
    table2: [],
    suppcatlist: [],
    prodcatlist: [],
    prodsubcatlist: [],
    branchlist: [],
    filterDialog: false,
    filterDialog1: false,

    //Table Headers 1
    headers1: [
      {
        text: "#",
        value: "count",
        align: "right",
        filterable: false,
        class: "black--text",
        sortable: false,
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

    //Table Headers 2
    headers2: [
      {
        text: "#",
        value: "count",
        align: "right",
        filterable: false,
        class: "black--text",
        sortable: false,
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
    itemsPerPage1: 10,
    itemsPerPage2: 10,
  }),

  //Watch
  watch: {
    page1(val) {
      this.page1 = val;
      this.getSupplies();
    },
    page2(val) {
      this.page1 = val;
      this.getProducts();
    },
  },

  //Onload
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

  //Methods
  methods: {
    itemperpage1() {
      this.page1 = 1;
      this.getSupplies();
    },

    itemperpage2() {
      this.page2 = 1;
      this.getProducts();
    },

    //For retrieving supplies
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

    //For retrieving products
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

    //For retrieving supply categories
    async suppCat() {
      await axios.get("/api/branches/inventory/suppCat").then((supp_cat) => {
        this.suppcatlist = supp_cat.data;
      });
    },

    //For retrieving branch name
    async branchName() {
      await axios
        .get("/api/branches/inventory/branchName")
        .then((bran_name) => {
          this.branchlist = bran_name.data;
        });
    },

    //For retrieving product categories
    async prodCat() {
      await axios.get("/api/branches/inventory/prodCat").then((prod_cat) => {
        this.prodcatlist = prod_cat.data;
      });
    },

    //For refresh
    refresh() {
      this.getSupplies();
      this.getProducts();
      this.suppCat();
      this.branchName();
      this.prodCat();
    },
  },
};
</script>