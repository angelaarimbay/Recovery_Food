<template>
  <div style="min-width: 280px">
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
            >Main Inventory</v-btn
          >
        </v-card-actions>
      </v-layout>
    </v-container>

    <!-- Main Card -->
    <v-card elevation="2" class="mt-2" style="border-radius: 10px">
      <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-4 py-4">
        <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
          <v-row no-gutters>
            <v-spacer></v-spacer>
            <v-tooltip bottom>
              <template #activator="data">
                <v-btn
                  class="mr-2 mb-3"
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
            <template v-slot:[`item.triggerpoint`]="{ item }">
              <div v-if="item.triggerpoint == 'Order'">
                <span style="color: red">Order</span>
              </div>
              <div v-else-if="item.triggerpoint == 'Manage'" class="text-black">
                Manage
              </div>
            </template>
            <template v-slot:[`item.net_price`]="{ item }"
              >{{ getFormatCurrency(item.net_price, "0,0.00") }}
            </template>
            <template v-slot:[`item.supply_full`]="{ item }"
              >{{ item.supply_name.supply_name }}
              {{ item.supply_name.description }}</template
            >
            <template v-slot:[`item.count`]="{ item }">
              {{ item.row }}</template
            >
            <template
              v-slot:[`item.onhand_a`]="{ item }"
              style="text-align: right"
            >
              <small>
                Qty : {{ item.onhand_q }} <br />
                Value: {{ item.onhand_a }}
              </small>
            </template>

            <!-- <template
              v-slot:[`item.begining_a`]="{ item }"
              style="text-align: right"
            >
              <small>
                Qty: {{ item.begining_q }} <br />
                {{ item.begining_a }}
              </small>
            </template>
            <template
              v-slot:[`item.incoming_a`]="{ item }"
              style="text-align: right"
            >
              <small>
                Qty: {{ item.incoming_q }} <br />
                {{ item.incoming_a }}
              </small>
            </template>
            <template
              v-slot:[`item.total_a`]="{ item }"
              style="text-align: right"
            >
              <small>
                Qty : {{ item.total_q }} <br />
                {{ item.total_a }}
              </small>
            </template>
            <template
              v-slot:[`item.outgoing_a`]="{ item }"
              style="text-align: right"
            >
              <small>
                Qty: {{ item.outgoing_q }} <br />
                {{ item.outgoing_a }}
              </small>
            </template>
            <template
              v-slot:[`item.average_a`]="{ item }"
              style="text-align: right"
            >
              <small>
                Qty : {{ item.average_q }} <br />
                {{ item.average_a }}
              </small>
            </template>
            <template
              v-slot:[`item.variance_a`]="{ item }"
              style="text-align: right"
            >
              <small>
                Qty : {{ item.variance_q }} <br />
                {{ item.variance_a }}
              </small>
            </template>
            <template
              v-slot:[`item.ending_a`]="{ item }"
              style="text-align: right"
            >
              <small>
                Qty : {{ item.ending_q }} <br />
                {{ item.ending_a }}
              </small>
            </template>
            <template
              v-slot:[`item.consumption_a`]="{ item }"
              style="text-align: right"
            >
              <small>
                Qty : {{ item.consumption_q }} <br />
                {{ item.consumption_a }}
              </small>
            </template>
            <template
              v-slot:[`item.ideal_a`]="{ item }"
              style="text-align: right"
            >
              <small>
                Qty : {{ item.ideal_q }} <br />
                {{ item.ideal_a }}
              </small>
            </template> -->
            <template v-slot:[`item.id`]="{ item }">
              <v-tooltip bottom>
                <template #activator="data">
                  <v-btn
                    icon
                    color="red darken-2"
                    small
                    :x-small="$vuetify.breakpoint.smAndDown"
                    v-on="data.on"
                    @click="openViewDialog(item)"
                  >
                    <v-icon>mdi-eye</v-icon>
                  </v-btn>
                </template>
                <span>View</span>
              </v-tooltip>
            </template>
          </v-data-table>

          <!-- Paginate -->
          <div class="pbutton text-center pt-2">
            <v-pagination
              v-model="page"
              :total-visible="7"
              :length="table.last_page"
              color="red darken-2"
            ></v-pagination>
          </div>

          <v-dialog v-model="viewdialog" max-width="900px">
            <v-card id="dialog" class="bgcolor">
              <v-toolbar
                dense
                dark
                class="pl-xl-6 pl-lg-6 pl-md-6 pl-sm-5 pl-3 red darken-2"
              >
                Main Inventory
                <v-spacer></v-spacer>
                <v-icon
                  class="mr-xl-4 mr-lg-4 mr-md-4 mr-sm-3 mr-1"
                  text
                  @click="closeViewDialog"
                  >mdi-close
                </v-icon>
              </v-toolbar>

              <v-card flat tile max-height="500" style="overflow-y: auto">
                <v-card-text class="py-2">
                  <v-card-text>
                    <!-- Data -->
                    <v-row>
                      <v-col class="px-2">
                        Category: <strong>{{ currentdata.category }}</strong>
                        <br />
                        Supply Name:
                        <strong
                          >{{ currentdata.supply_name }}
                          {{ currentdata.description }}</strong
                        >
                        <br />
                        Unit: <strong>{{ currentdata.unit }}</strong> <br />
                        Net Price:
                        <strong>{{
                          getFormatCurrency(currentdata.net_price, "0,0.00")
                        }}</strong>
                        <br />
                      </v-col>
                    </v-row>
                    <v-row
                      class="border rounded"
                      :class="{
                        'text-caption': $vuetify.breakpoint.smAndDown,
                      }"
                    >
                      <v-col cols="12" xl="6" lg="6" md="6" sm="6">
                        <v-row>
                          <v-col
                            class="py-1 px-0"
                            cols="6"
                            xl="6"
                            lg="6"
                            md="6"
                            sm="6"
                          ></v-col>
                          <v-col
                            class="
                              py-1
                              px-0
                              text-uppercase
                              font-weight-bold
                              text-center
                            "
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          >
                            Qty
                          </v-col>
                          <v-col
                            class="
                              py-1
                              px-0
                              text-uppercase
                              font-weight-bold
                              text-center
                            "
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          >
                            Value
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col
                            class="py-1 px-2 text-uppercase font-weight-bold"
                            cols="6"
                            xl="6"
                            lg="6"
                            md="6"
                            sm="6"
                            >Beginning Inventory</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                            >{{ currentdata.begining_q }}</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          >
                            {{ currentdata.begining_a }}</v-col
                          >
                        </v-row>
                        <v-row>
                          <v-col
                            class="py-1 px-2 text-uppercase font-weight-bold"
                            cols="6"
                            xl="6"
                            lg="6"
                            md="6"
                            sm="6"
                            >Incoming Supplies</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                            >{{ currentdata.incoming_q }}</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          >
                            {{ currentdata.incoming_a }}
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col
                            class="py-1 px-2 text-uppercase font-weight-bold"
                            cols="6"
                            xl="6"
                            lg="6"
                            md="6"
                            sm="6"
                            >Total Stocks</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                            >{{ currentdata.total_q }}</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          >
                            {{ currentdata.total_a }}
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col
                            class="py-1 px-2 text-uppercase font-weight-bold"
                            cols="6"
                            xl="6"
                            lg="6"
                            md="6"
                            sm="6"
                            >Outgoing Supplies</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                            >{{ currentdata.outgoing_q }}</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          >
                            {{ currentdata.outgoing_a }}
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col
                            class="py-1 px-2 text-uppercase font-weight-bold"
                            cols="6"
                            xl="6"
                            lg="6"
                            md="6"
                            sm="6"
                            >Stocks On Hand</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                            >{{ currentdata.onhand_q }}</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          >
                            {{ currentdata.onhand_a }}
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col
                            class="py-1 px-2 text-uppercase font-weight-bold"
                            cols="6"
                            xl="6"
                            lg="6"
                            md="6"
                            sm="6"
                            >Average Daily Usage</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                            >{{ currentdata.average_q }}</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          >
                            {{ currentdata.average_a }}
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col
                            class="py-1 px-2 text-uppercase font-weight-bold"
                            cols="6"
                            xl="6"
                            lg="6"
                            md="6"
                            sm="6"
                            >Lead Time</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          ></v-col>
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          >
                            {{ currentdata.lead_time }}
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col
                            class="py-1 px-2 text-uppercase font-weight-bold"
                            cols="6"
                            xl="6"
                            lg="6"
                            md="6"
                            sm="6"
                            >Order Point</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          ></v-col>
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          >
                            {{ currentdata.orderpoint }}
                          </v-col>
                        </v-row>
                      </v-col>
                      <v-col cols="12" xl="6" lg="6" md="6" sm="6">
                        <v-row>
                          <v-col
                            class="py-1 hidden-sm-and-down"
                            xl="6"
                            lg="6"
                            md="6"
                          ></v-col>
                          <v-col
                            class="
                              py-1
                              px-0
                              text-uppercase
                              font-weight-bold
                              text-center
                              hidden-sm-and-down
                            "
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          >
                            Qty
                          </v-col>
                          <v-col
                            class="
                              py-1
                              px-0
                              text-uppercase
                              font-weight-bold
                              text-center
                              hidden-sm-and-down
                            "
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          >
                            Value
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col
                            class="py-1 px-2 text-uppercase font-weight-bold"
                            cols="6"
                            xl="6"
                            lg="6"
                            md="6"
                            sm="6"
                            >Minimum Order Qty</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          ></v-col>
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          >
                            {{ currentdata.minimum_order_quantity }}
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col
                            class="py-1 px-2 text-uppercase font-weight-bold"
                            cols="6"
                            xl="6"
                            lg="6"
                            md="6"
                            sm="6"
                            >Order Qty</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          ></v-col>
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          >
                            {{ currentdata.ordr }}
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col
                            class="py-1 px-2 text-uppercase font-weight-bold"
                            cols="6"
                            xl="6"
                            lg="6"
                            md="6"
                            sm="6"
                            >Order Frequency</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          ></v-col>
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          >
                            {{ currentdata.order_frequency }}
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col
                            class="py-1 px-2 text-uppercase font-weight-bold"
                            cols="6"
                            xl="6"
                            lg="6"
                            md="6"
                            sm="6"
                            >Trigger Point</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          ></v-col>
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          >
                            {{ currentdata.triggerpoint }}
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col
                            class="py-1 px-2 text-uppercase font-weight-bold"
                            cols="6"
                            xl="6"
                            lg="6"
                            md="6"
                            sm="6"
                            >Ending Inventory</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                            >{{ currentdata.ending_q }}</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          >
                            {{ currentdata.ending_a }}
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col
                            class="py-1 px-2 text-uppercase font-weight-bold"
                            cols="6"
                            xl="6"
                            lg="6"
                            md="6"
                            sm="6"
                            >Consumption</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                            >{{ currentdata.consumption_q }}</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          >
                            {{ currentdata.consumption_a }}
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col
                            class="py-1 px-2 text-uppercase font-weight-bold"
                            cols="6"
                            xl="6"
                            lg="6"
                            md="6"
                            sm="6"
                            >Ideal Inventory</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                            >{{ currentdata.ideal_q }}</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          >
                            {{ currentdata.ideal_a }}
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col
                            class="py-1 px-2 text-uppercase font-weight-bold"
                            cols="6"
                            xl="6"
                            lg="6"
                            md="6"
                            sm="6"
                            >Variance</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                            >{{ currentdata.variance_q }}</v-col
                          >
                          <v-col
                            class="py-1 px-2 text-right"
                            cols="3"
                            xl="3"
                            lg="3"
                            md="3"
                            sm="3"
                          >
                            {{ currentdata.variance_a }}
                          </v-col>
                        </v-row>
                      </v-col>
                    </v-row>
                  </v-card-text>
                </v-card-text>
              </v-card>

              <v-card-actions class="px-xl-9 px-lg-9 px-md-8 px-sm-6 px-6 py-4">
                <v-spacer></v-spacer>
                <v-btn
                  color="error"
                  style="text-transform: none"
                  :small="$vuetify.breakpoint.smAndDown"
                  depressed
                  dark
                  @click="closeViewDialog"
                >
                  Close
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-container>
      </v-container>
    </v-card>
  </div>
</template>

<style>
.pbutton .v-pagination button {
  background-color: #212121 !important;
  color: #ffffff !important;
}
.pbutton .v-pagination i.v-icon.v-icon {
  color: #ffffff !important;
}
.pbutton .v-pagination__navigation:disabled {
  background-color: #000000 !important;
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

<style scoped>
.v-menu__content.theme--light .v-list {
  background: #212121;
}
.theme--light.v-list-item:hover:before {
  opacity: 0.14;
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
    category: "",
    button: false,
    dialog: false,
    progressBar: false,
    table: [],
    suppcatlist: [],
    filterDialog: false,
    viewdialog: false,

    // Form Data
    form: {
      id: null,
      beginning_inv_qty: null,
      lead_time: null,
      min_order_qty: null,
      order_frequency: null,
      ending_inv_qty: null,
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
        value: "category",
        filterable: false,
        class: "black--text",
      },
      {
        text: "SUPPLY NAME",
        value: "supply_name",
        class: "black--text",
      },
      {
        text: "UNIT",
        value: "unit",
        filterable: false,
        class: "black--text",
      },
      {
        text: "NET PRICE",
        value: "net_price",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "STOCKS ON HAND",
        value: "onhand_a",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "TRIGGER POINT",
        value: "triggerpoint",
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

  // Onload
  created() {
    if (this.user.permissionslist.includes("Access Inventory")) {
      this.get();
      this.suppCat();
    } else {
      this.$router.push({ name: "invalid-page" }).catch((errr) => {});
    }
  },

  methods: {
    itemperpage() {
      this.page = 1;
      this.get();
    },

    getFormatCurrency(e, format) {
      const numbr = numeral(e);
      return numbr.format(format);
    },

    // View Branch Info
    openViewDialog(row) {
      this.currentdata = JSON.parse(JSON.stringify(row));
      this.form.id = row.id;
      this.viewdialog = true;
    },

    // Close View Dialog
    closeViewDialog() {
      this.viewdialog = false;
    },

    async get() {
      this.progressbar = true; // Show the progress bar
      // Get data from tables
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;
      await axios
        .get("/api/misupp/get", {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,
            search: this.search,
            category: this.category,
          },
        })
        .then((result) => {
          //if the value is true then get the data
          this.table = result.data;
          this.progressbar = false; // Hide the progress bar
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    async suppCat() {
      await axios.get("/api/misupp/suppCat").then((supp_cat) => {
        this.suppcatlist = supp_cat.data;
      });
    },

    // Editing/updating of row
    edit(row) {
      this.currentdata = JSON.parse(JSON.stringify(row));
      this.form.id = row.id;
      this.form.beginning_inv_qty = row.beginning_inv_qty;
      this.form.lead_time = row.lead_time;
      this.form.min_order_qty = row.min_order_qty;
      this.form.order_frequency = row.order_frequency;
      this.form.ending_inv_qty = row.ending_inv_qty;
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
