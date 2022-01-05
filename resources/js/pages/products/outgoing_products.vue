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
            >Outgoing Products</v-btn
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
              Add Outgoing Product
            </v-btn>
            <v-spacer></v-spacer>
            <v-card color="red darken-3" flat style="border-radius: 20px">
              <!-- Requests -->
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
          <v-dialog v-model="filterDialog" max-width="400px" scrollable>
            <v-card dark tile>
              <v-toolbar :dense="$vuetify.breakpoint.xsOnly" flat class="transparent px-1">
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
          scrollable
        >
          <v-card>
            <v-toolbar dark :dense="$vuetify.breakpoint.xsOnly" flat class="red darken-3 px-1">
              <span
                class="
                  text-xl-subtitle-1
                  text-lg-subtitle-1
                  text-md-subtitle-1
                  text-sm-subtitle-1
                  text-subtitle-2
                "
                >Outgoing Product</span
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
                  class="tfield py-0 px-1"
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
                    @change="prodName"
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
                    @change="prodName"
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
                  <v-autocomplete
                    :rules="formRules"
                    v-model="form.product_name"
                    :items="prodnamelist"
                    dense
                    item-text="product_name"
                    return-object
                    @change="prodValidate"
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
                  </v-autocomplete>

                  <v-card
                    color="#f1f3f4"
                    flat
                    class="px-4 mb-6"
                    v-if="form.product_name"
                  >
                    <table style="width: 100%; font-size: 11px">
                      <tr>
                        <td
                          class="text-left pr-2"
                          style="width: 50%"
                          v-if="form.product_name.description"
                        >
                          Description:
                        </td>
                        <th>{{ form.product_name.description }}</th>
                      </tr>
                      <tr>
                        <td class="text-left pr-2" style="width: 50%">
                          Net Price:
                        </td>
                        <th>
                          {{
                            getFormatCurrency(form.product_name.price, "0,0.00")
                          }}
                        </th>
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
                    clearable
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

      <!-- Branch Request List -->
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
                        <!-- Refresh -->
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
                    <template v-slot:[`item.product_name`]="{ item }">
                      {{ item.product_name }}
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

      <!-- View Requested Products List Form -->
      <v-dialog v-model="dialog2" width="900px" scrollable>
        <v-card>
          <v-toolbar dark :dense="$vuetify.breakpoint.xsOnly" flat class="red darken-3 px-1">
            <span
              class="
                text-xl-subtitle-1
                text-lg-subtitle-1
                text-md-subtitle-1
                text-sm-subtitle-1
                text-subtitle-2
              "
              >Requested Products List</span
            >
            <v-spacer></v-spacer>
            <v-icon
              :small="$vuetify.breakpoint.xsOnly"
              text
              @click="dialog2 = false"
              >mdi-close
            </v-icon>
          </v-toolbar>
          <v-card-text style="height: auto" class="px-4">
            <div class="px-0" v-if="table2.length > 0">
              <v-card color="#f1f3f4" flat class="px-4 my-6">
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
              </v-card>
            </div>

            <!-- Table -->
            <v-data-table
              id="table1"
              :headers="headers2"
              show-select
              :items="table2"
              dense
              item-key="product_id"
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
              <template v-slot:[`item.product_name`]="{ item }">
                {{ item.product_name }} {{ item.description }}</template
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

              <template v-slot:[`item.product_id`]="{ item }">
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
          <v-card-actions class="pa-3">
            <template v-if="$vuetify.breakpoint.xsOnly">
              <v-btn
                style="text-transform: none"
                depressed
                :small="$vuetify.breakpoint.smAndDown"
                color="primary"
                @click="processRequest"
                :disabled="!disabled"
                block
              >
                Approve Request
              </v-btn>
            </template>
            <template v-else>
              <v-spacer></v-spacer>
              <v-btn
                style="text-transform: none"
                depressed
                :small="$vuetify.breakpoint.smAndDown"
                color="primary"
                @click="processRequest"
                :disabled="!disabled"
              >
                Approve Request
              </v-btn>
            </template>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- Quantity Dialog Form -->
      <v-form ref="qtyForm">
        <v-dialog v-model="dialog3" max-width="450px" scrollable>
          <v-card>
            <v-toolbar dark :dense="$vuetify.breakpoint.xsOnly" flat class="red darken-3 px-1">
              <span
                class="
                  text-xl-subtitle-1
                  text-lg-subtitle-1
                  text-md-subtitle-1
                  text-sm-subtitle-1
                  text-subtitle-2
                "
                >Enter Quantity</span
              >
              <v-spacer></v-spacer>
              <v-icon
                :small="$vuetify.breakpoint.xsOnly"
                text
                @click="dialog3 = false"
                >mdi-close
              </v-icon>
            </v-toolbar>
            <v-card-text style="height: auto">
              <v-row class="mt-1">
                <v-col class="pt-3" cols="12" xl="12" lg="12" sm="12" md="12">
                  <span
                    >Item Selected:
                    <strong>{{ selectedItem.product_name }}</strong></span
                  >
                </v-col>
              </v-row>
              <v-row class="mt-0">
                <v-col
                  class="tfield py-0 px-1"
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
                      style="text-transform: none"
                      outlined
                      color="primary"
                      class="py-4 px-2 mb-6"
                      text
                      @click="allQuantity(selectedItem)"
                    >
                      Max
                    </v-btn>
                  </v-card-actions>
                </v-col>
              </v-row>
            </v-card-text>
            <v-divider class="my-0"></v-divider>
            <!-- Dialog Form Buttons -->
            <v-card-actions class="pa-3">
              <template v-if="$vuetify.breakpoint.xsOnly">
                <v-row no-gutters>
                  <v-col cols="6" class="px-1">
                    <v-btn
                      style="text-transform: none"
                      color="grey"
                      depressed
                      :disabled="button"
                      dark
                      @click="dialog3 = false"
                      :small="$vuetify.breakpoint.smAndDown"
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
                      :small="$vuetify.breakpoint.smAndDown"
                      @click="updateQuantity(selectedItem)"
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
                  @click="dialog3 = false"
                  :small="$vuetify.breakpoint.smAndDown"
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
                  :small="$vuetify.breakpoint.smAndDown"
                  @click="updateQuantity(selectedItem)"
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
    return { title: "Products" };
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
  },

  //Data
  data: () => ({
    progressbar: false,
    snackbar: {
      active: false,
      message: "",
    },
    search: "",
    branch: "",
    category: "",
    subcategory: "",
    button: false,
    dialog: false,
    table: [],
    prodcatlist: [],
    prodsubcatlist: [],
    prodnamelist: [],
    branchlist: [],
    filterDialog: false,
    quantity: 0,

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
      sub_category: null,
      product_name: null,
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
        width: "10%",
      },
      {
        text: "SUBCATEGORY",
        value: "sub_category.prod_sub_cat_name",
        class: "black--text",
        width: "10%",
      },
      {
        text: "PRODUCT NAME",
        value: "product_name.product_name",
        filterable: false,
        class: "black--text",
        width: "20%",
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
        value: "outgoing_amount",
        align: "right",
        filterable: false,
        class: "black--text",
        width: "10%",
      },
      {
        text: "BRANCH",
        value: "requesting_branch.branch_name",
        filterable: false,
        class: "black--text",
        width: "15%",
      },
      {
        text: "OUTGOING DATE",
        value: "outgoing_date",
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
        align: "center",
      },
      {
        text: "REFERENCE NO.",
        align: "center",
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
        align: "center",
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

    //Header2 requestlist items
    headers2: [
      {
        text: "PRODUCT NAME",
        value: "product_name",
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
        align: "center",
        filterable: false,
        class: "black--text",
      },
      {
        text: "ACTION",
        value: "product_id",
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
    if (this.user.permissionslist.includes("Access Products")) {
      this.dateFrom = this.getFormatDate(
        new Date(new Date().getFullYear(), new Date().getMonth(), 1),
        "YYYY-MM-DD"
      );
      this.dateUntil = this.getFormatDate(
        new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0),
        "YYYY-MM-DD"
      );
      this.get();
      this.prodCat();
      this.prodSubCat();
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
          } else if (key == "sub_category") {
            if (this.currentdata.sub_category) {
              if (this.currentdata.sub_category.id != this.form.sub_category) {
                found += 1;
              }
            }
          } else if (key == "product_name") {
            if (this.currentdata.product_name) {
              if (
                this.currentdata.product_name.id != this.form.product_name.id
              ) {
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
        if (this.getQuantity < this.form.quantity) {
          this.snackbar = {
            active: true,
            iconText: "alert-circle",
            iconColor: "error",
            message: "Insufficient stocks.",
          };
          return;
        }

        //Validate first before compare
        if (this.compare()) {
          //Save or update data in the table
          await axios
            .post("/api/outprod/save", this.form)
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

    //For retrieving outgoing products
    async get() {
      this.progressbar = true; //Show the progress bar
      //Get data from tables
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;
      await axios
        .get("/api/outprod/get", {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,
            search: this.search,
            branch: this.branch,
            category: this.category,
            subcategory: this.subcategory,
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
          //If false or error when saving
        });
    },

    //For quantity validation
    async prodValidate(id = "", edit = "") {
      await axios
        .get("/api/outprod/prodValidate", { params: { id: id.id } })
        .then((result) => {
          this.getQuantity = result.data;
        });
    },

    //For retrieving product categories
    async prodCat() {
      await axios.get("/api/outprod/prodCat").then((prod_cat) => {
        this.prodcatlist = prod_cat.data;
      });
    },

    //For retrieving product subcategories
    async prodSubCat() {
      await axios.get("/api/outprod/prodSubCat").then((supp_name) => {
        this.prodsubcatlist = supp_name.data;
      });
    },

    //For retrieving product names
    async prodName() {
      this.form.product_name = null;
      await axios
        .get("/api/outprod/prodName", {
          params: {
            category: this.form.category,
            sub_category: this.form.sub_category,
          },
        })
        .then((prod_name) => {
          this.prodnamelist = prod_name.data;
        });
    },

    //For retrieving branch names
    async branchName() {
      await axios.get("/api/outprod/branchName").then((bran_name) => {
        this.branchlist = bran_name.data;
      });
    },

    //Editing/updating of row
    edit(row) {
      this.currentdata = JSON.parse(JSON.stringify(row));
      this.form.id = row.id;
      this.form.category = row.category.id;
      this.form.sub_category = row.sub_category.id;
      this.prodName();
      this.form.product_name = row.product_name;
      this.form.quantity = row.quantity;
      this.form.requesting_branch = row.requesting_branch.id;
      this.form.outgoing_date = this.getFormatDate(
        row.outgoing_date,
        "YYYY-MM-DD"
      );
      this.prodValidate(row.product_name, "yes");
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
        .get("/api/outprod/request/list", {
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

    //For viewing requests
    async viewRequestDialog(ref) {
      await axios
        .get("/api/outprod/request/items/list", {
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
      if (this.$refs.qtyForm.validate()) {
        if (
          this.quantity <=
          this.table2[this.table2.indexOf(this.selectedItem)].quantity_requested
        ) {
          this.table2[
            this.table2.indexOf(this.selectedItem)
          ].quantity_requested = this.quantity;
          this.dialog3 = false;
        } else {
          this.snackbar = {
            active: true,
            iconText: "alert-circle",
            iconColor: "error",
            message: "Insufficient stocks.",
          };
        }
      }
    },

    allQuantity() {
      this.quantity = this.selectedItem.quantity_available;
    },

    //For processing requests
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
        .post("/api/outprod/request/process", {
          checked: this.selected,
          actual: this.table2,
        })
        .then((result) => {
          //If the value is true then save to database
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
      this.prodCat();
      this.prodSubCat();
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