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

    <v-row no-gutters>
      <v-col cols="12" xl="6" lg="6" md="6" sm="12" class="pa-1">
        <v-card style="border-radius: 10px" class="pa-2">
          <v-card
            dark
            flat
            height="50"
            color="red darken-4"
            style="border-radius: 10px"
            class="d-flex align-center justify-center"
          >
            <span>Products List</span>
          </v-card>

          <v-row no-gutters class="mt-2">
            <!-- Items Per Page -->
            <v-col cols="4" xl="2" lg="2" md="3" sm="4" class="my-auto">
              <v-card-actions>
                <v-select
                  style="max-width: 82px"
                  dense
                  v-model="itemsPerPage"
                  label="Items"
                  @change="itemperpage"
                  :items="[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15]"
                >
                </v-select>
              </v-card-actions>
            </v-col>

            <v-spacer></v-spacer>

            <!-- Search Field -->
            <v-col cols="8" xl="5" lg="5" md="7" sm="8" class="my-auto">
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
                      :small="$vuetify.breakpoint.smAndDown"
                      :large="$vuetify.breakpoint.mdAndUp"
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

          <!-- Products List Table -->
          <v-data-table
            :headers="headers1"
            :items="table1.data"
            :loading="progressbar1"
            :page.sync="page"
            ref="progress1"
            :items-per-page="itemsPerPage"
            hide-default-footer
            @page-count="pageCount = $event"
          >
            <!-- Progress Bar -->
            <v-progress-linear
              color="red darken-2"
              class="px-0 mx-0"
              slot="progress1"
              indeterminate
              rounded
            ></v-progress-linear>
            <template v-slot:[`item.count`]="{ item }">
              {{ item.row }}</template
            >
            <template v-slot:[`item.id`]="{ item }">
              <v-btn
                icon
                color="red darken-2"
                @click="selectItem(item)"
                :x-small="$vuetify.breakpoint.smAndDown"
              >
                <v-icon>mdi-cart</v-icon>
              </v-btn>
            </template>
          </v-data-table>

          <!-- Paginate -->
          <div class="text-center pt-2">
            <v-pagination
              v-model="page"
              :total-visible="5"
              :length="table1.last_page"
              color="red darken-2"
            ></v-pagination>
          </div>
        </v-card>
      </v-col>

      <!-- Quantity Dialog Form -->
      <v-form ref="form">
        <v-dialog v-model="dialog" max-width="450px">
          <v-toolbar
            dense
            dark
            class="pl-xl-6 pl-lg-6 pl-md-6 pl-sm-5 pl-3 red darken-2"
          >
            Enter Quantity
          </v-toolbar>
          <v-card tile style="background-color: #f5f5f5">
            <v-card-text class="py-2">
              <br />
              <v-container class="pa-xl-3 pa-lg-3 pa-md-2 pa-sm-0 pa-0">
                <v-row>
                  <v-col class="py-0" cols="12" xl="12" lg="12" sm="12" md="12">
                    <span
                      >Item Selected:
                      {{ selectedrow.product_name.product_name }}</span
                    >
                  </v-col>
                </v-row>
                <hr />
                <v-row>
                  <v-col class="py-0" cols="12" xl="12" lg="12" sm="12" md="12">
                    <v-text-field
                      v-model="quantity"
                      :rules="formRules"
                      outlined
                      clearable
                      dense
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
                style="text-transform: none"
                :small="$vuetify.breakpoint.smAndDown"
                @click="addItem"
              >
                Save
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-form>

      <v-col cols="12" xl="6" lg="6" md="6" sm="12" class="pa-1">
        <v-card style="border-radius: 10px" class="pa-2">
          <v-card
            dark
            flat
            height="50"
            color="red darken-4"
            style="border-radius: 10px"
            class="d-flex align-center justify-center"
          >
            <span>Order Details</span>
          </v-card>

          <v-row no-gutters class="mt-2">
            <!-- Items Per Page -->
            <v-card-actions>
              <span
                style="color: #616161"
                :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
                >Sales Count: {{ table2.length }}</span
              >
            </v-card-actions>

            <v-spacer></v-spacer>

            <!-- Mode Field -->
            <v-col cols="6" xl="4" lg="4" md="6" sm="7" class="my-0 py-0">
              <v-card-actions>
                <v-select
                  outlined
                  dense
                  :items="['Walk In', 'Take Out', 'Delivery']"
                  hide-details="auto"
                  class="mb-0 mb-xl-4 mb-lg-4 mb-md-4 mb-sm-2"
                >
                  <template slot="label">
                    <div style="font-size: 14px">Mode</div>
                  </template>
                </v-select>
              </v-card-actions>
            </v-col>
          </v-row>

          <!-- Order List Table -->
          <v-data-table
            :headers="headers2"
            :items="table2"
            fixed-header
            dense
            height="230"
            :loading="progressbar2"
            ref="progress2"
            :items-per-page="table2.length"
            hide-default-footer
          >
            <!-- Progress Bar -->
            <v-progress-linear
              color="red darken-2"
              class="px-0 mx-0"
              slot="progress2"
              indeterminate
              rounded
            ></v-progress-linear>
            <template v-slot:[`item.row`]="{ item }">
            <v-btn
              icon
              color="red darken-2"
              @click="deleteItem(item)"
              :x-small="$vuetify.breakpoint.smAndDown"
            >
              <v-icon>mdi-delete</v-icon>
            </v-btn>
          </template>





          </v-data-table>
        
          <!-- Paginate -->
          <!-- <div class="text-center pt-2">
            <v-pagination
              v-model="page"
              :total-visible="5"
              :length="table2.last_page"
              color="red darken-2"
            ></v-pagination>
          </div> -->
        </v-card>

        <v-col cols="12" xl="12" lg="12" md="12" sm="12" class="pa-0 mt-2">
          <v-card
            height="50"
            class="d-flex align-center pa-3"
            style="border-radius: 10px"
          >
            <strong style="color: #616161">Total: </strong>
            <v-spacer></v-spacer>
            <strong>{{ totalamount }}</strong>
          </v-card>
        </v-col>

        <v-col cols="12" xl="12" lg="12" md="12" sm="12" class="pa-0 mt-2">
          <v-card style="border-radius: 10px" class="pa-3">
            <v-row align="center" justify="center">
              <v-col cols="6" xl="4" lg="4" md="6" sm="6" class="pb-0">
                <v-text-field
                  v-model="payment"
                  @change="getChange"
                  outlined
                  clearable
                  dense
                  hide-details
                >
                  <template slot="label">
                    <div style="font-size: 14px">Payment</div>
                  </template>
                </v-text-field>
              </v-col>

              <v-col cols="6" xl="4" lg="4" md="6" sm="6" class="pb-0">
                <v-text-field
                  v-model="discount"
                  @change="getChange"
                  outlined
                  clearable
                  dense
                  hide-details
                >
                  <template slot="label">
                    <div style="font-size: 14px">Discount</div>
                  </template>
                </v-text-field>
              </v-col>

              <v-col cols="12" xl="4" lg="4" md="12" sm="12" class="pb-0">
                <v-text-field
                  v-model="change"
                  outlined
                  dense
                  disabled
                  hide-details
                >
                  <template slot="label">
                    <div style="font-size: 14px">Change</div>
                  </template>
                </v-text-field>
              </v-col>
            </v-row>

            <v-row class="mt-2">
              <v-col>
                <v-btn
                  dark
                  block
                  color="green darken-3"
                  style="text-transform: none"
                >
                  Done
                </v-btn>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import axios from "axios"; // Library for sending api request
export default {
  middleware: "auth",
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
  },
  data: () => ({
    progressbar1: false,
    progressbar2: false,
    snackbar: {
      active: false,
      message: "",
    },
    search: "",
    button: false,
    quantity: 0,
    dialog: false,
    selectedrow: { product_name: "" },
    totalamount: 0,
    payment: 0,
    discount: 0,
    change: 0,
    table1: [],
    table2: [],
    prodcatlist: [],
    prodsubcatlist: [],

    // Form Rules
    formRules: [(v) => !!v || "This is required"],
    formRulesNumberRange: (v) => {
      if (!isNaN(parseFloat(v)) && v >= 1 && v <= 100) return true;
      return "Number has to be between 1% and 100%";
    },
    formRulesNumber: [
      (v) => Number.isInteger(Number(v)) || "The value must be an integer",
    ],

    form: {
      id: null,
      quantity: null,
    },

    // Table Headers
    headers1: [
      { text: "#", value: "count", align: "start", filterable: false },
      {
        text: "Category",
        value: "category.product_cat_name",
        filterable: false,
      },
      {
        text: "Sub Category",
        value: "sub_category.prod_sub_cat_name",
        filterable: false,
      },
      {
        text: "Product Name",
        value: "product_name.product_name",
        align: "right",
      },
      {
        text: "Unit Price",
        value: "product_name.price",
        align: "right",
        filterable: false,
      },
      {
        text: "Qty",
        value: "quantity",
        align: "right",
        filterable: false,
      },
      {
        text: "",
        value: "id",
        align: "center",
        sortable: false,
        filterable: false,
      },
    ],
    page: 1,
    pageCount: 0,
    itemsPerPage: 5,

    // Table Headers
    headers2: [
      { text: "#", value: "id", align: "start", filterable: false },
      {
        text: "Product Name",
        value: "product_name",
        filterable: false,
      },
      { text: "Unit Price", value: "unit", align: "right", filterable: false },
      {
        text: "Qty",
        value: "quantity",
        align: "right",
        filterable: false,
      },
      {
        text: "Sub-Total",
        value: "sub_total",
        align: "right",
        filterable: false,
      },
      {
        text: "",
        value: "row",
        align: "center",
        sortable: false,
        filterable: false,
      },
    ],
    page: 1,
    pageCount: 0,
    itemsPerPage: 5,
  }),

  methods: {
    getTotal() {
      // for (var key in this.table2.sub_total) {
      //       arrayshit.push( this.table2[key].sub_total);
      // }
      this.totalamount = this.table2.reduce((a, b) => a + b.sub_total, 0);
    },
    itemperpage() {
      this.page = 1;
      this.get();
    },

    async get() {
      this.progressbar1 = true;
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;
      await axios
        .get("/api/pos/prodlist/get", {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,
            search: this.search,
          },
        })
        .then((result) => {
          this.table1 = result.data;
          this.progressbar1 = false;
        });
    },

    selectItem(item) {
      this.dialog = true;
      this.selectedrow = item;
      console.log(item);
      // 1. open dialog
      // 2. input ka
      // 3. pag ok mo ito ung code
      //     this.table1.push(item); //add new row/data to datable
      // 4. pag mag add quantity ka same item. depende sayo.
      // ako kasi ni checheck ko kung existing ung item pag exisitng add quantity lang ndi new row

      //gawin mo na
      //ito ung code para mapapunta sa 2nd table mo
      //pero ito ay update. for example na check mo na exsiting ung item. then update mo ung quantity.
      // var index = this.selected.documents.indexOf(item);
      // Object.assign(this.table2[index], item); //get specific index values
      //ito nmn ung add new row sa isang table.

      //    ikaw na gumawa ng condition.
    },
    addItem() {
      this.table2.push({
        id: this.table2.length + 1,
        product_name: this.selectedrow.product_name.product_name,
        unit: this.selectedrow.product_name.price,
        quantity: this.quantity,
        sub_total: this.quantity * this.selectedrow.product_name.price,
      });
      this.getTotal();
    },
    deleteItem(item) {
      this.editedIndex = this.table2.indexOf(item);
      this.table2.splice(this.editedIndex, 1);
      this.getTotal();
    },
    getChange() {
      this.change = this.payment - (this.discount / 100) * this.totalamount;
    },

    // Reset Forms
    cancel() {
      this.$refs.form.reset();
      this.dialog = false;
    },
  },

  created() {
    if (this.user.permissionslist.includes("Access POS")) {
      this.get();
    } else {
      this.$router.push({ name: "invalid-page" }).catch((errr) => {});
    }
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