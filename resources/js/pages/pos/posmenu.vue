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

    <v-snackbar
      :vertical="$vuetify.breakpoint.xsOnly"
      min-width="auto"
      v-model="snackbar2.active"
      timeout="10000"
      :left="$vuetify.breakpoint.smAndUp"
      class="pb-0"
    >
      <span
        ><v-icon :color="snackbar2.iconColor">{{
          `mdi-${snackbar2.iconText}`
        }}</v-icon></span
      >
      {{ snackbar2.message }}
      <template v-slot:action="{ attrs }">
        <v-btn
          :small="$vuetify.breakpoint.smAndDown"
          v-bind="attrs"
          color="primary"
          text
          @click="action(snackbar2.type)"
          >Yes</v-btn
        >

        <v-btn
          :small="$vuetify.breakpoint.smAndDown"
          v-bind="attrs"
          color="primary"
          text
          @click="snackbar2.active = false"
          >Cancel</v-btn
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
            <span
              class="text-h6 text-xl-h4 text-lg-h4 text-md-h5 text-sm-h5 mb-0"
              >Products List</span
            >
          </v-card>

          <v-row no-gutters class="mt-2" style="height: 60px" align="center">
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
            </v-card>
          </v-dialog>

          <!-- Products List Table -->
          <v-data-table
            id="table2"
            class="prod_table table-striped border mt-4"
            :headers="headers1"
            :items="table1.data"
            :loading="progressbar1"
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
            <template v-slot:[`item.product_name.product_name`]="{ item }">
              {{ item.product_name.product_name }}
              {{ item.product_name.description }}</template
            >
            <template v-slot:[`item.count`]="{ item }">
              {{ item.row }}</template
            >

            <template v-slot:[`item.id`]="{ item }">
              <v-tooltip bottom>
                <template #activator="data">
                  <v-btn
                    :large="$vuetify.breakpoint.mdAndUp"
                    v-on="data.on"
                    icon
                    color="red darken-2"
                    @click="selectItem(item, 'add')"
                    :small="$vuetify.breakpoint.smAndDown"
                  >
                    <v-icon>mdi-cart</v-icon>
                  </v-btn>
                </template>
                <span>Add Order</span>
              </v-tooltip>
            </template>
          </v-data-table>

          <!-- Paginate -->
          <div
            class="
              pbutton
              text-center
              pt-7
              pb-xl-4 pb-lg-4 pb-md-4 pb-sm-3 pb-3
            "
          >
            <v-pagination
              v-model="page"
              :total-visible="7"
              :length="table1.last_page"
              color="red darken-2"
            ></v-pagination>
          </div>
        </v-card>

        <!-- Preview Receipt -->
        <v-dialog v-model="dialog1">
          <v-toolbar
            dense
            dark
            class="pl-xl-6 pl-lg-6 pl-md-6 pl-sm-5 pl-3 red darken-2"
          >
            Preview Receipt
            <v-spacer></v-spacer>
            <v-icon
              class="mr-xl-4 mr-lg-4 mr-md-4 mr-sm-3 mr-1"
              text
              @click="dialog1 = false"
              >mdi-close
            </v-icon>
          </v-toolbar>
          <iframe :src="pdfview" width="500" height="500"></iframe>
        </v-dialog>

        <!-- Dialog Form -->
        <v-dialog v-model="dialog2" max-width="900px">
          <v-card tile class="pt-3 pl-3 pr-3 pb-0 mb-0">
            <v-toolbar dark dense flat rounded class="red darken-3">
              Current Month Sales History
              <v-spacer></v-spacer>
              <v-icon text @click="dialog2 = false">mdi-close </v-icon>
            </v-toolbar>

            <salesreport v-if="renderComponent" />
          </v-card>
          <!-- <iframe :src="pdfview1" width="500" height="500"></iframe> -->
        </v-dialog>
      </v-col>

      <!-- Quantity Dialog Form -->
      <v-form ref="form" lazy-validation>
        <v-dialog v-model="dialog" max-width="450px">
          <v-card tile class="pa-3">
            <v-toolbar dark dense flat rounded class="red darken-3">
              Enter Quantity
              <v-spacer></v-spacer>
              <v-icon text @click="cancel">mdi-close </v-icon>
            </v-toolbar>
            <v-card-text class="px-0 py-0">
              <v-container class="px-2">
                <v-row>
                  <v-col class="pt-3" cols="12" xl="12" lg="12" sm="12" md="12">
                    <span
                      >Item Selected:
                      <strong
                        >{{ selectedrow.product_name.product_name }}
                        {{ selectedrow.product_name.description }}
                        {{ selectedrow.description }}</strong
                      >
                    </span>
                  </v-col>
                </v-row>
                <v-row class="mt-0">
                  <v-col
                    class="tfield py-0"
                    cols="12"
                    xl="12"
                    lg="12"
                    sm="12"
                    md="12"
                  >
                    <v-text-field
                      class="centered-input"
                      :rules="formRulesQuantity"
                      v-model="quantity"
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
                      style="font-size: 22px"
                    >
                      <template slot="label">
                        <div style="font-size: 18px">
                          Quantity <span style="color: red">*</span>
                        </div>
                      </template>
                    </v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>
            <v-divider class="my-0"></v-divider>
            <!-- Dialog Form Buttons -->
            <v-card-actions class="px-0 pb-0 pt-3">
              <v-spacer></v-spacer>
              <v-btn
                color="grey"
                depressed
                :disabled="button"
                dark
                @click="cancel"
                :small="$vuetify.breakpoint.smAndDown"
                outlined
              >
                <span style="color: #1976d2">Cancel</span>
              </v-btn>
              <v-btn
                color="primary"
                depressed
                :disabled="button"
                dark
                v-if="dialog_add"
                :small="$vuetify.breakpoint.smAndDown"
                @click="validateQty('add')"
              >
                Save
              </v-btn>
              <v-btn
                color="primary"
                depressed
                v-else
                :disabled="button"
                dark
                :small="$vuetify.breakpoint.smAndDown"
                @click="validateQty('delete')"
              >
                Remove
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
            <span
              class="text-h6 text-xl-h4 text-lg-h4 text-md-h5 text-sm-h5 mb-0"
              >Order Details</span
            >
          </v-card>

          <v-row no-gutters class="mt-2" style="height: 60px" align="center">
            <v-col cols="5" xl="3" lg="4" md="3" class="my-auto">
              <v-card-actions>
                <span
                  style="color: #616161"
                  class="
                    text-body-2
                    text-xl-h6
                    text-lg-h6
                    text-md-body-2
                    text-sm-body-2
                    mb-0
                  "
                  >Sales Count: {{ salescount.count }}</span
                >
              </v-card-actions>
            </v-col>

            <v-col cols="7" xl="5" lg="4" md="4" class="my-auto">
              <v-card-actions>
                <span
                  style="color: #616161"
                  class="
                    text-body-2
                    text-xl-h6
                    text-lg-h6
                    text-md-body-2
                    text-sm-body-2
                    mb-0
                  "
                  >Total Sales: {{ salescount.amount }}</span
                >
              </v-card-actions>
            </v-col>

            <v-spacer></v-spacer>

            <!-- Mode Field -->
            <v-col
              cols="12"
              xl="4"
              lg="4"
              md="5"
              sm="4"
              class="my-auto text-center"
              style="max-width: 150px"
            >
              <v-card-actions>
                <v-select
                  dense
                  v-model="mode"
                  :items="['Walk-In', 'Take-Out']"
                  hide-details
                  placeholder="Mode"
                  class="mb-0 mb-xl-4 mb-lg-4 mb-md-0 mb-sm-2 ml-auto"
                  background-color="grey darken-3"
                  dark
                  flat
                  solo
                  style="font-size: 16px"
                >
                </v-select>
              </v-card-actions>
            </v-col>
          </v-row>

          <!-- Order List Table -->
          <v-data-table
            id="table2"
            class="ord_table table-striped border mt-4"
            :headers="headers2"
            :items="table2"
            height="230"
            :loading="progressbar2"
            ref="progress"
            :items-per-page="table2.length"
            hide-default-footer
          >
            <!-- Progress Bar -->
            <v-progress-linear
              color="red darken-2"
              class="px-0 mx-0"
              slot="progress"
              indeterminate
              rounded
            ></v-progress-linear>

            <template v-slot:[`item.product_name.product_name`]="{ item }">
              {{ item.product_name.product_name }}
              {{ item.description }}
            </template>

            <template v-slot:[`item.row`]="{ item }">
              <v-tooltip bottom>
                <template #activator="data">
                  <v-btn
                    :large="$vuetify.breakpoint.mdAndUp"
                    v-on="data.on"
                    icon
                    color="red darken-2"
                    @click="validateDelete(item)"
                    :small="$vuetify.breakpoint.smAndDown"
                  >
                    <v-icon>mdi-delete</v-icon>
                  </v-btn>
                </template>
                <span>Remove Item</span>
              </v-tooltip>
            </template>
          </v-data-table>

          <!-- Paginate -->
          <!-- <div class="text-center pt-7 pb-xl-4 pb-lg-4 pb-md-4 pb-sm-3 pb-3">
            <v-pagination
              v-model="page"
              :total-visible="7"
              :length="table2.last_page"
              color="red darken-2"
            ></v-pagination>
          </div> -->
        </v-card>

        <v-col cols="12" xl="12" lg="12" md="12" sm="12" class="pa-0 mt-2">
          <v-card height="95" class="pa-3" style="border-radius: 10px">
            <v-card-actions class="p-0 m-0">
              <span
                style="color: #616161"
                class="
                  text-h6 text-xl-h5 text-lg-h5 text-md-h6 text-sm-h6
                  font-weight-bold
                  my-auto
                "
                >Total:</span
              >
              <v-spacer></v-spacer>
              <span
                class="
                  text-h6 text-xl-h5 text-lg-h5 text-md-h6 text-sm-h6
                  font-weight-bold
                  my-auto
                "
                >{{ totalamount }}</span
              >
            </v-card-actions>
            <v-card-actions class="p-0 m-0">
              <span
                style="color: #616161"
                class="
                  text-h5 text-xl-h4 text-lg-h4 text-md-h5 text-sm-h5
                  font-weight-bold
                  my-auto
                "
                >Grand Total:
              </span>
              <v-spacer></v-spacer>
              <span
                class="
                  text-h5 text-xl-h4 text-lg-h4 text-md-h5 text-sm-h5
                  font-weight-bold
                  my-auto
                "
                >{{ discountedamount }}</span
              >
            </v-card-actions>
          </v-card>
        </v-col>

        <v-col cols="12" xl="12" lg="12" md="12" sm="12" class="pa-0 mt-2">
          <v-card style="border-radius: 10px" class="pa-3">
            <v-row align="center" justify="center">
              <v-col cols="6" xl="4" lg="4" md="6" sm="6" class="pb-0">
                <!-- Payment -->
                <v-text-field
                  class="centered-input"
                  :rules="formRulesPrice"
                  ref="payment"
                  v-model="payment"
                  @input="getChange($event)"
                  outlined
                  clearable
                  dense
                  hide-details
                  @click:clear="change = 0"
                  @focus="clearP"
                  @blur="resetP"
                  persistent-placeholder
                  autocomplete="off"
                  :disabled="disabled"
                  @keydown="paymentKeydown($event)"
                  style="font-size: 22px"
                >
                  <template slot="label">
                    <div style="font-size: 18px">Payment</div>
                  </template>
                </v-text-field>
              </v-col>

              <v-col cols="6" xl="4" lg="4" md="6" sm="6" class="pb-0">
                <!-- Discount -->
                <v-text-field
                  class="centered-input"
                  :rules="formRulesDiscount"
                  v-model="discount"
                  @input="getChange($event)"
                  outlined
                  clearable
                  dense
                  hide-details
                  persistent-placeholder
                  @focus="clearD"
                  @blur="resetD"
                  autocomplete="off"
                  :disabled="!payment"
                  @keydown="discountKeydown($event)"
                  style="font-size: 22px"
                >
                  <template slot="label">
                    <div style="font-size: 18px">Discount(%)</div>
                  </template>
                </v-text-field>
              </v-col>

              <v-col cols="12" xl="4" lg="4" md="12" sm="12" class="pb-0">
                <!-- Change -->
                <v-text-field
                  class="centered-input"
                  v-model="change"
                  outlined
                  dense
                  disabled
                  hide-details
                  filled
                  style="font-size: 22px"
                >
                  <template slot="label">
                    <div style="font-size: 18px">Change</div>
                  </template>
                </v-text-field>
              </v-col>
            </v-row>

            <v-row class="mt-2">
              <v-col cols="12" xl="8" lg="8" md="12" sm="12">
                <v-row no-gutters>
                  <v-col cols="3">
                    <!-- Sales History -->
                    <v-tooltip bottom>
                      <template #activator="data">
                        <v-btn
                          v-on="data.on"
                          block
                          @click="getSalesToday"
                          color="orange darken-3"
                          style="text-transform: none; color: white"
                        >
                          <v-icon large>mdi-history</v-icon>
                        </v-btn>
                      </template>
                      <span>Sales History</span>
                    </v-tooltip>
                  </v-col>
                  <v-col cols="3">
                    <!-- Print -->
                    <v-tooltip bottom>
                      <template #activator="data">
                        <v-btn
                          v-on="data.on"
                          block
                          @click="getReceipt"
                          color="blue-grey darken-1"
                          style="text-transform: none; color: white"
                          :disabled="disabled1"
                        >
                          <v-icon large>mdi-printer</v-icon>
                        </v-btn>
                      </template>
                      <span>Print</span>
                    </v-tooltip>
                  </v-col>
                  <v-col cols="3">
                    <!-- Void Order -->
                    <v-tooltip bottom>
                      <template #activator="data">
                        <v-btn
                          v-on="data.on"
                          block
                          color="red darken-3"
                          style="
                            text-transform: none;
                            color: white;
                            font-size: 17px;
                          "
                          :disabled="disabled"
                          @click="validate('void')"
                        >
                          <v-icon large>mdi-do-not-disturb</v-icon>
                        </v-btn>
                      </template>
                      <span>Void Order(s)</span>
                    </v-tooltip>
                  </v-col>
                  <v-col cols="3">
                    <!-- New Order -->
                    <v-tooltip bottom>
                      <template #activator="data">
                        <v-btn
                          v-on="data.on"
                          block
                          color="blue darken-2"
                          style="text-transform: none; color: white"
                          :disabled="disabled"
                          @click="validate('new')"
                        >
                          <v-icon large>mdi-new-box</v-icon>
                        </v-btn>
                      </template>
                      <span>New Order</span>
                    </v-tooltip>
                  </v-col>
                </v-row>
              </v-col>
              <v-col
                cols="12"
                xl="4"
                lg="4"
                md="12"
                sm="12"
                class="pt-0 pt-xl-3 pt-lg-3 pt-md-3 pt-sm-0"
              >
                <!-- Checkout -->
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      v-on="data.on"
                      block
                      color="green darken-3"
                      style="text-transform: none; color: white"
                      :disabled="disabled"
                      @click="validate('save')"
                    >
                      <v-icon large>mdi-cart</v-icon>
                    </v-btn>
                  </template>
                  <span>Checkout</span>
                </v-tooltip>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
      </v-col>
    </v-row>
  </div>
</template>

<!-- Style -->
<style>
.container {
  max-width: 1500px !important;
}

.centered-input input {
  text-align: center;
}

#table2 .v-data-table-header th {
  white-space: nowrap;
}
@media only screen and (min-width: 768px) {
  .v-data-table-header th {
    font-size: 12px !important;
  }
  .v-data-table td {
    font-size: 15px !important;
  }
}
@media only screen and (min-width: 1024px) {
  .prod_table .v-data-table-header th,
  .ord_table .v-data-table-header th {
    font-size: 15px !important;
    text-align: center !important;
  }
  .prod_table td,
  .ord_table td {
    font-size: 17px !important;
  }
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
import salesreport from "../reports/report_types/sales.vue";
export default {
  middleware: "auth",
  metaInfo() {
    return { title: "POS" };
  },
  components: {
    salesreport,
  },

  //Computed
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
    disabled2() {
      for (var key in this.temp_data) {
        for (var key1 in this.temp_data[key]) {
          if (this.temp_data[key][key1] != this.table2[key][key1]) {
            alert("d magkatulad");
            return true;
          } else {
            alert("magkatulad");
          }
        }
      }
    },
  },

  //Data
  data: () => ({
    pdfview: "",
    pdfview1: "",
    progressbar1: false,
    progressbar2: false,
    snackbar: {
      active: false,
      message: "",
    },
    snackbar2: {
      active: false,
      message: "",
    },
    search: "",
    category: "",
    subcategory: "",
    button: false,
    mode: "",
    quantity: 1,
    disabled: true,
    disabled1: true,
    dialog: false,
    filterDialog: false,
    selectedrow: { product_name: "" },
    totalamount: numeral(0).format("0,0.00"),
    discountedamount: numeral(0).format("0,0.00"),
    payment: 0,
    discount: 0,
    change: 0,
    deleteindex: -1,
    dialog_add: true,
    salescount: 0,
    table1: [],
    table2: [],
    temp_data: [],
    prodcatlist: [],
    reference_no: "",
    prodsubcatlist: [],
    dialog1: false,
    dialog2: false,
    type: "",

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
    formRulesDiscount: [
      (v) => /^[0-9]\d{0,7}(?:\.\d{1,4})?$/.test(v) || "Discount must be valid",
    ],

    form: {
      id: null,
      quantity: 1,
    },

    //Table Headers
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
        text: "PRODUCT NAME",
        value: "product_name.product_name",
        class: "black--text",
        class: "black--text",
      },
      {
        text: "UNIT PRICE",
        value: "price",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "QTY",
        value: "quantity_diff",
        align: "right",
        filterable: false,
        class: "black--text",
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
    itemsPerPage: 10,
    renderComponent: true,

    //Table Headers
    headers2: [
      {
        text: "#",
        value: "id",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "PRODUCT NAME",
        value: "product_name.product_name",
        filterable: false,
        class: "black--text",
      },
      {
        text: "UNIT PRICE",
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
        text: "SUB-TOTAL",
        value: "sub_total",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "",
        value: "row",
        align: "center",
        filterable: false,
        sortable: false,
      },
    ],
    page: 1,
    pageCount: 0,
    itemsPerPage: 10,
  }),

  //Methods
  methods: {
    //Keydown
    quantityKeydown(e) {
      if (/[\s~`!@#$%^&()_={}[\]\\"*|:;,.<>+'\/?-]/.test(e.key)) {
        e.preventDefault();
      }
    },

    paymentKeydown(e) {
      if (/[\s~`!@#$%^&()_={}[\]\\"*|:;,<>+'\/?-]/.test(e.key)) {
        e.preventDefault();
      }
    },

    discountKeydown(e) {
      if (/[\s~`!@#$%^&()_={}[\]\\"*|:;,.<>+'\/?-]/.test(e.key)) {
        e.preventDefault();
      }
    },

    getTotal() {
      this.totalamount = numeral(
        this.table2.reduce((a, b) => a + b.temp_sub_total, 0)
      ).format("0,0.00");

      this.discountedamount = numeral(
        this.table2.reduce((a, b) => a + b.temp_sub_total, 0) -
          (this.discount / 100) *
            this.table2.reduce((a, b) => a + b.temp_sub_total, 0)
      ).format("0,0.00");

      for (var key in this.table2) {
        this.table2[key].sub_total_discounted =
          this.table2[key].quantity *
          (this.table2[key].price -
            (this.discount / 100) * this.table2[key].price);

        this.table2[key].payment = this.payment;
        this.table2[key].discount = this.discount;
        this.table2[key].change = this.change;
      }
    },

    itemperpage() {
      this.page = 1;
      this.get();
    },

    //For retrieving product list
    async get() {
      this.progressbar1 = true;
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;
      await axios
        .get("/api/pos/prodlist/get", {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,
            search: this.search,
            category: this.category,
            subcategory: this.subcategory,
          },
        })
        .then((result) => {
          this.temp_data = JSON.parse(JSON.stringify(result.data));
          this.table1 = result.data;
          this.progressbar1 = false;
        })
        .catch((result) => {
          // If false or error when saving
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

    //For generating receipt
    async getReceipt() {
      await axios({
        url: "/api/pos/receipt",
        method: "GET",
        responseType: "blob",
        params: { reference_no: this.reference_no },
      }).then((response) => {
        //  console.log(response.data);
        // return;
        let blob = new Blob([response.data], { type: "application/pdf" });
        this.pdfview = window.URL.createObjectURL(blob);
        this.dialog2 = false;
        this.dialog1 = true;
      });
    },

    //For retrieving current sales
    async getSalesToday() {
      this.dialog2 = true;
      this.$forceUpdate();
      this.renderComponent = false;
      this.$nextTick(() => {
        this.renderComponent = true;
      });
    },

    //For validation
    validate(type) {
      switch (type) {
        case "save":
          this.snackbar2 = {
            active: true,
            iconText: "comment-question-outline",
            iconColor: "warning",
            message: "Do you wish to continue?",
            type: "save",
          };
          break;
        case "void":
          this.snackbar2 = {
            active: true,
            iconText: "comment-question-outline",
            iconColor: "warning",
            message: "Do you want to void the order?",
            type: "void",
          };
          break;
        case "new":
          this.snackbar2 = {
            active: true,
            iconText: "comment-question-outline",
            iconColor: "warning",
            message: "Do you want to make new order?",
            type: "new",
          };
          break;
        default:
          break;
      }
    },

    //For saving transaction info
    async save() {
      this.snackbar2.active = false;
      if (parseInt(this.payment) >= parseInt(this.totalamount)) {
        await axios
          .post("/api/pos/prodlist/save", this.table2)
          .then((result) => {
            this.reference_no = result.data.reference_no;
            this.get();
            this.getSalesCount();
            this.disabled1 = false; //For printer
            this.disabled = true;
            (this.table2 = []), (this.payment = 0);
            this.discount = 0;
            this.change = 0;
            this.totalamount = numeral(0).format("0,0.00");
            this.discountedamount = numeral(0).format("0,0.00");
            this.snackbar = {
              active: true,
              iconText: "check",
              iconColor: "success",
              message: "Successfully checked-out.",
            };
            this.$refs.form.resetValidation();
          });
      } else {
        this.snackbar = {
          active: true,
          iconText: "alert",
          iconColor: "error",
          message: "Error! Please input correct payment first.",
        };
      }
    },

    //For counting sales
    async getSalesCount() {
      await axios.get("/api/sales_report/sales_count").then((result) => {
        this.salescount = result.data;
      });
    },

    //For mode
    selectItem(item) {
      if (this.mode) {
        this.dialog_add = true;
        this.dialog = true;
        this.selectedrow = item;
      } else {
        this.snackbar = {
          active: true,
          iconText: "alert",
          iconColor: "warning",
          message: "Select a mode of transaction first!",
        };
      }
    },

    //For validation
    validateQty(type) {
      if (this.$refs.form.validate()) {
        if (type == "add") {
          var quantity = 0;
          if (this.table2.length > 0) {
            var indexid = -1;
            for (var key in this.table2) {
              //If table have value
              if (
                parseInt(this.selectedrow.product_name.id) ===
                parseInt(this.table2[key].product)
              ) {
                indexid = this.table2.indexOf(this.table2[key]);
              }
            }
            if (indexid > -1) {
              quantity =
                parseInt(this.table2[indexid].quantity) +
                parseInt(this.quantity); //Add current and input
              if (parseInt(this.selectedrow.quantity_diff) < quantity) {
                //Check if greather than stocks
                this.snackbar = {
                  active: true,
                  iconText: "alert",
                  iconColor: "error",
                  message: "Insufficient stocks.",
                };
              } else {
                this.table2[indexid].quantity =
                  parseInt(this.table2[indexid].quantity) +
                  parseInt(this.quantity);
                this.table2[indexid].sub_total = numeral(
                  parseFloat(this.table2[indexid].quantity) *
                    parseFloat(this.selectedrow.product_name.price)
                ).format("0,0.00");
                this.table2[indexid].temp_sub_total =
                  parseFloat(this.table2[indexid].quantity) *
                  parseFloat(this.selectedrow.product_name.price);

                this.snackbar = {
                  active: true,
                  iconText: "check",
                  iconColor: "success",
                  message: "Successfully added.",
                };
              }
            } else {
              if (
                parseInt(this.selectedrow.quantity_diff) <
                parseInt(this.quantity)
              ) {
                this.snackbar = {
                  active: true,
                  iconText: "alert",
                  iconColor: "error",
                  message: "Insufficient stocks.",
                };
              } else {
                this.table2.push({
                  id: this.table2.length + 1,
                  category: this.selectedrow.category.id,
                  sub_category: this.selectedrow.sub_category.id,
                  product_name: {
                    product_name: this.selectedrow.product_name.product_name,
                  },
                  description: this.selectedrow.product_name.description,
                  product: this.selectedrow.product_name.id,
                  price: numeral(this.selectedrow.product_name.price).format(
                    "0,0.00"
                  ),
                  quantity: this.quantity,
                  sub_total: numeral(
                    this.quantity * this.selectedrow.product_name.price
                  ).format("0,0.00"),
                  temp_sub_total:
                    parseFloat(this.quantity) *
                    parseFloat(this.selectedrow.product_name.price),
                  mode: this.mode,
                });

                this.snackbar = {
                  active: true,
                  iconText: "check",
                  iconColor: "success",
                  message: "Successfully added.",
                };
              }
            }
          } else {
            if (parseInt(this.selectedrow.quantity_diff) >= this.quantity) {
              this.table2.push({
                id: this.table2.length + 1,
                category: this.selectedrow.category.id,
                sub_category: this.selectedrow.sub_category.id,
                product_name: {
                  product_name: this.selectedrow.product_name.product_name,
                },
                description: this.selectedrow.product_name.description,
                product: this.selectedrow.product_name.id,
                price: numeral(this.selectedrow.product_name.price).format(
                  "0,0.00"
                ),
                quantity: this.quantity,
                sub_total: numeral(
                  this.quantity * this.selectedrow.product_name.price
                ).format("0,0.00"),
                temp_sub_total:
                  parseFloat(this.quantity) *
                  parseFloat(this.selectedrow.product_name.price),
                mode: this.mode,
              });

              this.snackbar = {
                active: true,
                iconText: "check",
                iconColor: "success",
                message: "Successfully added.",
              };
              this.disabled = false;
              this.disabled1 = true;
            } else {
              this.snackbar = {
                active: true,
                iconText: "alert",
                iconColor: "error",
                message: "Insufficient stocks.",
              };
            }
          }
        } else {
          this.table2[this.deleteindex].quantity =
            this.table2[this.deleteindex].quantity - parseInt(this.quantity);
          this.table2[this.deleteindex].sub_total = numeral(
            parseFloat(this.table2[this.deleteindex].quantity) *
              parseFloat(this.selectedrow.price)
          ).format("0,0.00");
          this.table2[this.deleteindex].temp_sub_total =
            parseFloat(this.table2[this.deleteindex].quantity) *
            parseFloat(this.selectedrow.price);

          if (this.table2[this.deleteindex].quantity <= 0) {
            this.table2.splice(this.deleteindex, 1);

            for (var key in this.table2) {
              this.table2[key].id = this.table2.length;
            }
          }

          if (this.table2.length > 0) {
            this.disabled = false;
            this.disabled1 = true;
          } else {
            this.disabled = true;
          }
          this.snackbar = {
            active: true,
            iconText: "check",
            iconColor: "success",
            message: "Successfully removed.",
          };
        }
        this.payment = 0;
        this.discount = 0;
        this.change = 0;
        this.getTotal();
        this.getChange();
        this.cancel();
      }
    },

    //For validation
    validateDelete(item) {
      this.deleteindex = this.table2.indexOf(item);
      this.selectedrow = item;
      this.dialog_add = false;
      this.dialog = true;
    },

    //For checking table
    checktotable2() {
      var check_existing = 0;
      //table
      for (var i in this.table2) {
        if (this.selectedrow.product_name.id == this.table2[i].product) {
          check_existing = i;
        }
      }
      if (check_existing > 0) {
        return this.updatetotable2(check_existing);
      } else {
        return this.addtotable2();
      }
    },

    //For adding to table
    addtotable2() {
      this.table2.push({
        id: this.table2.length + 1,
        category: this.selectedrow.category.id,
        sub_category: this.selectedrow.sub_category.id,
        product_name: {
          product_name: this.selectedrow.product_name.product_name,
        },
        description: this.selectedrow.product_name.description,
        product: this.selectedrow.product_name.id,
        price: this.selectedrow.product_name.price,
        quantity: this.quantity,
        sub_total: numeral(
          this.quantity * this.selectedrow.product_name.price
        ).format("0,0.00"),
        temp_sub_total: this.quantity * this.selectedrow.product_name.price,
        mode: this.mode,
      });
    },

    //For updating table
    updatetotable2(i) {
      if (i == -1) {
        this.addtotable2();
        return;
      }
      if (this.selectedrow.product_name.id == this.table2[i].product) {
        this.table2[i].quantity =
          this.table2[i].quantity + parseInt(this.quantity);
        this.table2[i].sub_total = numeral(
          this.table2[i].quantity * this.selectedrow.product_name.price
        ).format("0,0.00");
        this.table2[i].temp_sub_total = numeral(
          this.table2[i].quantity * this.selectedrow.product_name.price
        ).format("0,0.00");
      } else {
        this.addtotable2();
      }
    },

    //For appending item
    appendItem(type) {
      if (type == "add") {
        var check_existing = -1;
        if (this.table2.length > 0) {
          for (var i in this.table2) {
            if (this.selectedrow.product_name.id == this.table2[i].product) {
              check_existing = this.table2.indexOf(this.table2[i]);
            }
          }
        }
        this.updatetotable2(check_existing);
      } else {
      }
      this.snackbar = {
        active: true,
        iconText: "check",
        iconColor: "success",
        message: "Successfully added.",
      };
      this.getTotal();
      this.getChange();
      this.cancel();
    },

    //For deleting item
    deleteItem(item) {
      this.editedIndex = this.table2.indexOf(item);
      this.appendItem(item);
      this.snackbar = {
        active: true,
        iconText: "check",
        iconColor: "success",
        message: "Successfully removed.",
      };
    },

    //For computing the change
    getChange() {
      if (this.payment > 0) {
        if (this.discount > 0) {
          this.change = numeral(
            this.payment -
              (this.totalamount - (this.discount / 100) * this.totalamount)
          ).format("0,0.00");
          this.getTotal();
        } else if (this.discount == null || this.discount == 0) {
          this.change = numeral(this.payment - this.totalamount).format(
            "0,0.00"
          );
          this.getTotal();
        }
      }
    },

    //Reset Form
    cancel() {
      this.quantity = 1;
      this.dialog = false;
    },

    //Reset value of quantity text-field
    resetQ() {
      if (this.quantity == null) {
        this.quantity = 1;
      }
    },

    //Clear value of quantity text-field
    clearQ() {
      if (this.quantity == 1) {
        this.quantity = null;
      }
    },

    //Reset value of payment text-field
    resetP() {
      if (this.payment == null) {
        this.payment = 0;
      }
    },

    //Clear value of payment text-field
    clearP() {
      if (this.payment == 0) {
        this.payment = null;
      }
    },

    //Reset value of discount text-field
    resetD() {
      if (this.discount == null) {
        this.discount = 0;
      }
    },

    //Clear value of discount text-field
    clearD() {
      if (this.discount == 0) {
        this.discount = null;
      }
    },

    //For action
    action(type) {
      switch (type) {
        case "save":
          this.save();
          break;
        case "void":
          this.voidOrder();
          break;
        case "new":
          this.newOrder();
          break;
        default:
          break;
      }
      this.snackbar2.active = false;
    },

    //For voiding order
    voidOrder() {
      this.payment = 0;
      this.discount = 0;
      this.change = 0;
      this.disabled = true;
      this.table2 = [];
      this.getTotal();
      this.mode = null;
      this.snackbar = {
        active: true,
        iconText: "check",
        iconColor: "success",
        message: "Successfully voided.",
      };
    },

    //For creating new order
    newOrder() {
      this.payment = 0;
      this.discount = 0;
      this.change = 0;
      this.disabled = true;
      this.table2 = [];
      this.reference_no = "";
      this.getTotal();
      this.mode = null;
      this.snackbar = {
        active: true,
        iconText: "check",
        iconColor: "success",
        message: "Successfully created a new order.",
      };
    },

    //For refresh
    refresh() {
      this.get();
      this.prodCat();
      this.prodSubCat();
      this.getSalesCount();
    },
  },

  //Onload
  created() {
    if (this.user.permissionslist.includes("Access POS")) {
      this.$store.commit("check_layout/container", "");
      this.get();
      this.prodCat();
      this.prodSubCat();
      this.getSalesCount();
    } else {
      this.$router.push({ name: "invalid-page" }).catch((errr) => {});
    }
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