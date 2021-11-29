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
          >
            Outgoing Supplies
          </v-btn>
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
              Add Outgoing Supply
            </v-btn>
            <v-spacer></v-spacer>
            <v-card color="red darken-3" flat style="border-radius: 20px">
              <!-- Request Button -->
              <v-tooltip bottom>
                <template #activator="data">
                  <v-btn
                    class="mr-2"
                    color="white"
                    depressed
                    :small="$vuetify.breakpoint.smAndDown"
                    dark
                    @click="openRequestDialog"
                    v-on="data.on"
                    icon
                  >
                    <v-icon size="20">mdi-clipboard-text</v-icon>
                  </v-btn>
                </template>
                <span>Request(s)</span>
              </v-tooltip>
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
                      v-model="branch"
                      :items="branchlist"
                      item-text="branch_name"
                      item-value="id"
                      clearable
                      dense
                      placeholder="Branch"
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
            </v-card>
          </v-dialog>
        </v-card-actions>

        <!-- Table -->
        <v-data-table
          id="table1"
          :headers="myheaders"
          :items="table.data"
          :loading="progressbar"
          :page.sync="page"
          ref="progress"
          :items-per-page="itemsPerPage"
          hide-default-footer
          @page-count="pageCount = $event"
          class="tbl table-striped border mt-2"
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
        >
          <v-card tile class="pa-3">
            <v-toolbar dark dense flat rounded class="red darken-3">
              Outgoing Supply
              <v-spacer></v-spacer>
              <v-icon text @click="cancel">mdi-close </v-icon>
            </v-toolbar>
            <v-container class="px-1">
              <v-row class="py-4">
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

                  <v-menu
                    v-model="date3"
                    :close-on-content-click="false"
                    :nudge-right="35"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <!-- Outgoing Date -->
                      <v-text-field
                        :prepend-inner-icon="
                          showIcon ? 'mdi-calendar-range' : ''
                        "
                        :rules="formRules"
                        v-model="form.outgoing_date"
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
                            Outgoing Date <span style="color: red">*</span>
                          </div>
                        </template>
                      </v-text-field>
                    </template>
                    <v-date-picker
                      v-model="form.outgoing_date"
                      @input="date3 = false"
                      scrollable
                      no-title
                      color="red darken-2"
                      dark
                    ></v-date-picker>
                  </v-menu>
                </v-col>

                <v-col
                  class="tfield py-0"
                  cols="12"
                  xl="12"
                  lg="12"
                  sm="12"
                  md="12"
                >
                  <!-- Requesting Branch -->
                  <v-select
                    :rules="formRulesNumberRange"
                    v-model="form.requesting_branch"
                    :items="branchlist"
                    dense
                    item-text="branch_name"
                    item-value="id"
                    background-color="white"
                    flat
                    solo
                    style="font-size: 12px"
                  >
                    <template slot="label">
                      <div style="font-size: 12px">
                        Requesting Branch <span style="color: red">*</span>
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
                  class="tfield py-0"
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
                    dense
                    item-text="supply_name"
                    return-object
                    @change="suppValidate"
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

                  <v-card flat class="px-4 pb-6" v-if="form.supply_name">
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
                      <tr>
                        <td class="text-left pr-2" style="width: 50%">
                          Available Quantity:
                        </td>
                        <th>{{ getQuantity }}</th>
                      </tr>
                    </table>
                  </v-card>
                </v-col>

                <v-col
                  class="tfield py-0"
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
                    clearable
                    dense
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
            </v-container>
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
                @click="save"
                :small="$vuetify.breakpoint.smAndDown"
              >
                Save
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-form>

      <!-- Branch Request List  -->
      <v-dialog
        v-model="dialog1"
        fullscreen
        transition="dialog-bottom-transition"
        persistent
        no-click-animation
      >
        <v-toolbar
          dense
          dark
          class="pl-xl-6 pl-lg-6 pl-md-6 pl-sm-5 pl-3 red darken-2"
        >
          Branch Request(s)
          <v-spacer></v-spacer>
          <v-icon
            class="mr-xl-4 mr-lg-4 mr-md-4 mr-sm-3 mr-1"
            text
            @click="dialog1 = false"
            >mdi-close
          </v-icon>
        </v-toolbar>

        <v-card tile height="auto" style="background-color: #f1ffff">
          <v-card-text class="py-2 px-3">
            <v-container class="pa-xl-3 pa-lg-3 pa-md-2 pa-sm-0 pa-0">
              <v-card elevation="1" class="mt-2" style="border-radius: 10px">
                <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-4">
                  <v-card-actions class="px-0">
                    <v-row align="center" no-gutters>
                      <v-spacer></v-spacer>
                      <v-card
                        color="red darken-3"
                        flat
                        style="border-radius: 20px"
                      >
                        <!--Refresh -->
                        <v-tooltip bottom>
                          <template #activator="data">
                            <v-btn
                              class="mx-4"
                              color="white"
                              depressed
                              :small="$vuetify.breakpoint.smAndDown"
                              dark
                              @click="requestList"
                              v-on="data.on"
                              icon
                              ><v-icon size="20">mdi-refresh</v-icon></v-btn
                            >
                          </template>
                          <span>Refresh</span>
                        </v-tooltip>
                      </v-card>
                    </v-row>
                  </v-card-actions>

                  <!-- Table -->
                  <v-data-table
                    dense
                    id="table1"
                    :headers="headers1"
                    :items="table1.data"
                    :loading="progressbar1"
                    :page.sync="page1"
                    ref="progress"
                    :items-per-page="itemsPerPage1"
                    hide-default-footer
                    @page-count="pageCount1 = $event"
                    class="mt-2 table-striped border"
                  >
                    <!-- Progress Bar -->
                    <v-progress-linear
                      color="red darken-2"
                      class="px-0 mx-0"
                      slot="progress"
                      indeterminate
                      rounded
                    ></v-progress-linear>
                    <template v-slot:[`item.request_date`]="{ item }">
                      {{
                        getFormatDate(item.request_date, "YYYY-MM-DD hh:mm A")
                      }}
                    </template>
                    <template v-slot:[`item.supply_name`]="{ item }">
                      {{ item.supply_name }}
                      {{ item.description }}</template
                    >

                    <template v-slot:[`item.status`]="{ item }">
                      <div v-if="item.status == 1" class="text-warning">
                        Pending
                      </div>
                      <div v-else-if="item.status == 2" class="text-info">
                        Confirmed / For Delivery
                      </div>
                      <div v-else-if="item.status == 3" class="text-success">
                        Completed
                      </div>
                    </template>

                    <template v-slot:[`item.id`]="{ item }">
                      <v-tooltip bottom>
                        <template #activator="data">
                          <v-btn
                            icon
                            color="red darken-2"
                            @click="viewRequestDialog(item)"
                            small
                            :x-small="$vuetify.breakpoint.smAndDown"
                            v-on="data.on"
                          >
                            <v-icon>mdi-eye</v-icon>
                          </v-btn>
                        </template>
                        <span>View</span>
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
                      v-model="page1"
                      :total-visible="7"
                      :length="table1.last_page"
                      color="red darken-2"
                    ></v-pagination>
                  </div>
                </v-container>
              </v-card>
            </v-container>
          </v-card-text>
        </v-card>
      </v-dialog>

      <!-- View Requested Supplies List Form -->
      <v-dialog v-model="dialog2" width="900px">
        <v-card tile class="pa-3">
          <v-toolbar dark dense flat rounded class="red darken-3">
            Requested Supplies List
            <v-spacer></v-spacer>
            <v-icon text @click="dialog2 = false">mdi-close </v-icon>
          </v-toolbar>
          <v-card-text class="px-0">
            <v-card-text>
              <div class="px-0" v-if="table2.length > 0">
                <v-row no-gutters>
                  <v-col cols="12" xl="6" lg="6" md="6" sm="6">
                    Requested By:<br /><strong
                      >{{ table2[0].branch }}
                      -
                      {{ table2[0].user }}</strong
                    >
                  </v-col>
                  <v-col
                    :class="{ 'text-right': $vuetify.breakpoint.smAndUp }"
                    cols="12"
                    xl="6"
                    lg="6"
                    md="6"
                    sm="6"
                  >
                    Date Requested:<br /><strong>{{
                      getFormatDate(
                        table2[0].request_date,
                        "YYYY-MM-DD hh:mm A"
                      )
                    }}</strong>
                  </v-col>
                </v-row>
              </div>
            </v-card-text>

            <v-data-table
              id="table1"
              :headers="headers2"
              show-select
              :items="table2"
              dense
              item-key="supply_id"
              :items-per-page="10"
              v-model="selected"
              class="table-striped border"
            >
              <template
                v-slot:[`item.data-table-select`]="{ item, isSelected, select }"
              >
                <v-simple-checkbox
                  :value="
                    item.status !== 3 &&
                    isSelected &&
                    item.status !== 2 &&
                    isSelected
                  "
                  :readonly="item.status == 3 || item.status == 2"
                  :disabled="item.status == 3 || item.status == 2"
                  @input="select($event)"
                ></v-simple-checkbox>
              </template>
              <template v-slot:[`item.supply_name`]="{ item }">
                {{ item.supply_name }} {{ item.description }}</template
              >

              <template v-slot:[`item.status`]="{ item }">
                <div v-if="item.status == 1" class="text-warning">Pending</div>
                <div v-else-if="item.status == 2" class="text-info">
                  Confirmed / For Delivery
                </div>
                <div v-else-if="item.status == 3" class="text-success">
                  Completed
                </div>
              </template>

              <template v-slot:[`item.supply_id`]="{ item }">
                <div v-if="item.status == 1">
                  <v-tooltip bottom>
                    <template #activator="data">
                      <v-btn
                        icon
                        color="red darken-2"
                        @click="editRequest(item)"
                        :x-small="$vuetify.breakpoint.smAndDown"
                        v-on="data.on"
                      >
                        <v-icon>mdi-pencil</v-icon>
                      </v-btn>
                    </template>
                    <span>Edit</span>
                  </v-tooltip>
                </div>
              </template>
            </v-data-table>
          </v-card-text>
          <v-divider class="my-0"></v-divider>
          <!-- Dialog Form Buttons -->
          <v-card-actions class="px-0 pb-0 pt-3">
            <v-spacer></v-spacer>
            <v-btn
              depressed
              :small="$vuetify.breakpoint.smAndDown"
              color="primary"
              @click="processRequest"
              :disabled="!disabled"
            >
              Approve Request
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- Quantity Dialog Form -->
      <v-dialog v-model="dialog3" max-width="450px">
        <v-card tile class="pa-3">
          <v-toolbar dark dense flat rounded class="red darken-3">
            Enter Quantity
            <v-spacer></v-spacer>
            <v-icon text @click="dialog3 = false">mdi-close </v-icon>
          </v-toolbar>
          <v-card-text class="px-0 py-0">
            <v-container class="px-2">
              <v-row>
                <v-col class="pt-3" cols="12" xl="12" lg="12" sm="12" md="12">
                  <span
                    >Item Selected:
                    <strong>{{ selectedItem.supply_name }}</strong></span
                  >
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
                  <v-card-actions class="px-0">
                    <!-- Quantity -->
                    <v-text-field
                      :rules="formRulesQuantity"
                      v-model="quantity"
                      dense
                      autocomplete="off"
                      @keydown="quantityKeydown($event)"
                      class="mr-2"
                      clearable
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
                    <v-btn
                      outlined
                      color="primary"
                      class="py-4 px-2 mb-6"
                      text
                      @click="allQuantity(selectedItem)"
                    >
                      MAX
                    </v-btn>
                  </v-card-actions>
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
              @click="dialog3 = false"
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
              :small="$vuetify.breakpoint.smAndDown"
              @click="updateQuantity(selectedItem)"
            >
              OK
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-card>
  </div>
</template>

<!-- Style -->
<style>
.container {
  max-width: 1500px !important;
}

.tbl.v-data-table__checkbox,
.v-input--selection-controls__input .mdi-checkbox-marked,
.v-input--selection-controls__input .mdi-minus-box {
  color: #d32f2f !important;
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
    disabled() {
      if (this.selected.length == 0) {
        return false;
      } else {
        return true;
      }
    },
    myheaders() {
      return this.headers.filter((s) => this.headers.includes(s));
    },
  },

  //Data
  data: () => ({
    progressbar: false,
    progressbar1: false,
    snackbar: {
      active: false,
      message: "",
    },
    search: "",
    button: false,
    dialog: false,
    category: "",
    branch: "",
    table: [],
    suppcatlist: [],
    suppnamelist: [],
    branchlist: [],
    filterDialog: false,
    quantity: 0,

    //Form Rules
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
      quantity: null,
      requesting_branch: null,
      outgoing_date: null,
    },

    //For comparing data
    currentdata: {},

    //Table Headers
    headers: [
      {
        text: "#",
        value: "count",
        align: "right",
        filterable: false,
        class: "black--text",
        sortable: false,
      },
      {
        text: "CATEGORY",
        value: "category.supply_cat_name",
        filterable: false,
        class: "black--text",
      },
      {
        text: "SUPPLY NAME",
        value: "supply_name.supply_name",
        class: "black--text",
      },
      {
        text: "UNIT",
        value: "supply_name.unit",
        filterable: false,
        class: "black--text",
      },
      {
        text: "NET PRICE",
        value: "supply_name.net_price",
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
      {
        text: "BRANCH",
        value: "requesting_branch.branch_name",
        filterable: false,
        class: "black--text",
      },
      {
        text: "OUTGOING DATE",
        value: "outgoing_date",
        filterable: false,
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
    itemsPerPage: 10,
    dateFrom: null,
    dateUntil: null,
    date1: false,
    date2: false,
    date3: false,
    getQuantity: 0,

    //Header1 request list
    headers1: [
      {
        text: "REQUEST DATE",
        value: "request_date",
        class: "black--text",
      },
      {
        text: "REFERENCE NO.",
        align: "right",
        value: "ref",
        filterable: false,
        class: "black--text",
      },
      {
        text: "BRANCH",
        value: "branch",
        filterable: false,
        class: "black--text",
      },
      {
        text: "STATUS",
        value: "status",
        filterable: false,
        class: "black--text",
      },
      {
        text: "ACTION",
        value: "id",
        align: "center",
        filterable: false,
        sortable: false,
        class: "black--text",
      },
    ],
    progressbar1: false,
    table1: [],
    dialog1: false,
    page1: 1,
    pageCount1: 0,
    itemsPerPage1: 5,

    //Header2 request list items
    headers2: [
      {
        text: "SUPPLY NAME",
        value: "supply_name",
        class: "black--text",
      },
      {
        text: "REQUESTED QTY",
        value: "quantity_requested",
        filterable: false,
        align: "right",
        class: "black--text",
      },
      {
        text: "AVAILABLE QTY",
        value: "quantity_available",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "STATUS",
        value: "status",
        filterable: false,
        class: "black--text",
      },
      {
        text: "ACTION",
        value: "supply_id",
        align: "center",
        filterable: false,
        sortable: false,
        class: "black--text",
      },
    ],
    table2: [],
    dialog2: false,
    selected: [],

    dialog3: false,
    selectedItem: [],
  }),

  //Onload
  created() {
    if (this.user.permissionslist.includes("Access Inventory")) {
      for (var key in this.user.permissionslist) {
        if (this.user.permissionslist[key] == "Access Branch Inventory") {
          this.headers.splice(this.headers.indexOf(this.headers[8]), 1);
          this.headers.splice(this.headers.indexOf(this.headers[9]), 1);
          this.headers.splice(this.headers.indexOf(this.headers[8]), 1);
        }
      }
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
      this.branchName();
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
          } else if (key == "supply_name") {
            if (this.currentdata.supply_name) {
              if (this.currentdata.supply_name.id != this.form.supply_name.id) {
                found += 1;
              }
            }
          } else if (key == "requesting_branch") {
            if (this.currentdata.requesting_branch) {
              if (
                this.currentdata.requesting_branch.id !=
                this.form.requesting_branch
              ) {
                found += 1;
              }
            }
          } else if (key == "outgoing_date") {
            if (
              this.getFormatDate(
                this.currentdata.outgoing_date,
                "YYYY-MM-DD"
              ) != this.getFormatDate(this.form.outgoing_date, "YYYY-MM-DD")
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
        if (this.getQuantity < this.form.quantity) {
          this.snackbar = {
            active: true,
            iconText: "alert-circle",
            iconColor: "error",
            message: "Insufficient stocks.",
          };
          return;
        }

        if (this.compare()) {
          //Save or update data in the table
          await axios
            .post("/api/osupp/save", this.form)
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

    //For retrieving outgoing supplies
    async get() {
      this.progressbar = true; //Show the progress bar
      //Get data from tables
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;

      if (this.user.permissionslist.includes("Access Branch Inventory")) {
        this.branch = this.user.branch;
      }

      await axios
        .get("/api/osupp/get", {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,
            search: this.search,
            branch: this.branch,
            category: this.category,
            dateFrom: this.dateFrom,
            dateUntil: this.dateUntil,
          },
        })
        .then((result) => {
          //If the value is true then get the data
          this.table = result.data;
          this.progressbar = false; //Hide the progress bar
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

    //For validating supply quantity
    async suppValidate(id = "", edit = "") {
      await axios
        .get("/api/osupp/suppValidate", { params: { id: id.id } })
        .then((result) => {
          this.getQuantity = result.data;
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

    //For retrieving branch names
    async branchName() {
      await axios.get("/api/osupp/branchName").then((bran_name) => {
        this.branchlist = bran_name.data;
      });
    },

    //Editing/updating of row
    edit(row) {
      this.currentdata = JSON.parse(JSON.stringify(row));
      this.form.id = row.id;
      this.form.category = row.category.id;
      this.suppName();
      this.form.supply_name = row.supply_name;
      this.form.quantity = row.quantity;
      this.form.requesting_branch = row.requesting_branch.id;
      this.form.outgoing_date = this.getFormatDate(
        row.outgoing_date,
        "YYYY-MM-DD"
      );
      this.suppValidate(row.supply_name, "yes");
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

    //For retrieving request list
    async requestList() {
      this.progressbar1 = true;
      await axios
        .get("/api/osupp/request/list", {
          params: {
            page: this.page1,
            itemsPerPage: this.itemsPerPage1,
          },
        })
        .then((result) => {
          this.table1 = result.data;
          this.progressbar1 = false;
        });
    },

    openRequestDialog() {
      this.dialog1 = true;
      this.requestList();
    },

    //For viewing request
    async viewRequestDialog(ref) {
      await axios
        .get("/api/osupp/request/items/list", {
          params: {
            ref: ref.id,
          },
        })
        .then((result) => {
          this.table2 = result.data;
        });
      this.selected = [];
      this.dialog2 = true;
    },

    editRequest(row) {
      this.selectedItem = row;
      this.quantity = row.quantity_requested;
      this.dialog3 = true;
    },

    updateQuantity() {
      if (
        this.quantity <=
        this.table2[this.table2.indexOf(this.selectedItem)].quantity_requested
      ) {
        this.table2[this.table2.indexOf(this.selectedItem)].quantity_requested =
          this.quantity;
        this.dialog3 = false;
      } else {
        this.snackbar = {
          active: true,
          iconText: "alert-circle",
          iconColor: "error",
          message: "Insufficient stocks.",
        };
      }
    },

    allQuantity() {
      this.quantity = this.selectedItem.quantity_available;
    },

    //For processing request
    async processRequest() {
      var found = 0;
      for (var key in this.selected) {
        if (
          this.selected[key].quantity_available <
          this.selected[key].quantity_requested
        ) {
          found += 1;
        }
      }

      if (found > 0) {
        this.snackbar = {
          active: true,
          iconText: "alert-circle",
          iconColor: "error",
          message: "Insufficient stocks.",
        };
        return;
      }

      await axios
        .post("/api/osupp/request/process", {
          checked: this.selected,
          actual: this.table2,
        })
        .then((result) => {
          //if the value is true then save to database
          this.snackbar = {
            active: true,
            iconText: "check",
            iconColor: "success",
            message: "Request has been successfully proccessed.",
          };
          this.requestList();
          this.dialog2 = false;
        });
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
      this.branchName();
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
    page1(val) {
      this.page1 = val;
      this.requestList();
    },
    id: {
      handler: function (v) {},
    },
  },
};
</script>