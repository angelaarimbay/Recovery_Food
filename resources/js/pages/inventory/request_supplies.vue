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
          >No</v-btn
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
          Supplies Request
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
            >Supplies Request</v-btn
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
              @click="addRequest"
              >Add New Request</v-btn
            >
            <v-spacer></v-spacer>
            <v-card color="red darken-3" flat style="border-radius: 20px">
              <!-- Refresh -->
              <v-tooltip bottom>
                <template #activator="data">
                  <v-btn
                    class="mx-4"
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
            </v-card>
          </v-row>
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

          <template v-slot:[`item.request_date`]="{ item }">
            {{ getFormatDate(item.request_date, "YYYY-MM-DD hh:mm A") }}
          </template>

          <template v-slot:[`item.status`]="{ item }">
            <div v-if="item.status == 1" class="text-warning">Pending</div>
            <div v-else-if="item.status == 2" class="text-info">
              Confirmed / For Delivery
            </div>
            <div v-else-if="item.status == 3" class="text-success">
              Completed
            </div>
          </template>

          <template v-slot:[`item.id`]="{ item }">
            <div v-if="item.status == 2">
              <v-tooltip bottom>
                <template #activator="data">
                  <v-btn
                    icon
                    color="success darken-2"
                    @click="completeRequest(item)"
                    small
                    :x-small="$vuetify.breakpoint.smAndDown"
                    v-on="data.on"
                  >
                    <v-icon>mdi-check</v-icon>
                  </v-btn>
                </template>
                <span>Complete</span>
              </v-tooltip>
            </div>
            <div v-else-if="item.status == 1">
              <v-tooltip bottom>
                <template #activator="data">
                  <v-btn
                    icon
                    color="red darken-2"
                    @click="viewRequest(item)"
                    small
                    :x-small="$vuetify.breakpoint.smAndDown"
                    v-on="data.on"
                  >
                    <v-icon>mdi-pencil</v-icon>
                  </v-btn>
                </template>
                <span>Edit</span>
              </v-tooltip>
              <v-tooltip bottom>
                <template #activator="data">
                  <v-btn
                    icon
                    color="red darken-2"
                    @click="validate('cancelreq', item)"
                    small
                    :x-small="$vuetify.breakpoint.smAndDown"
                    v-on="data.on"
                  >
                    <v-icon>mdi-cancel</v-icon>
                  </v-btn>
                </template>
                <span>Cancel</span>
              </v-tooltip>
            </div>
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
    </v-card>

    <!-- Dialog -->
    <v-dialog
      v-model="dialog_list"
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
        Request
        <v-spacer></v-spacer>
        <v-icon
          class="mr-xl-4 mr-lg-4 mr-md-4 mr-sm-3 mr-1"
          text
          @click="closeRequest"
          >mdi-close</v-icon
        >
      </v-toolbar>

      <v-card tile height="auto" style="background-color: #f1ffff">
        <v-card-text class="py-2 px-2">
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
                    class="
                      text-subtitle-2
                      text-xl-h6
                      text-lg-h6
                      text-md-subtitle-1
                      text-sm-subtitle-1
                      mb-0 mb-0
                    "
                    >Supplies List</span
                  >
                </v-card>

                <v-row no-gutters style="height: 60px" align="center">
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
                          @click="getList"
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
                                  @click="getList"
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
                              @change="getList"
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
                  dense
                  id="table1"
                  :loading="progressbar1"
                  :headers="headers1"
                  :items="table1"
                  ref="progress"
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

                  <template v-slot:[`item.supply_name`]="{ item }">
                    {{ item.supply_name }} {{ item.description }}</template
                  >

                  <template v-slot:[`item.id`]="{ item }">
                    <v-tooltip bottom>
                      <template #activator="data">
                        <v-btn
                          icon
                          color="red darken-2"
                          @click="validateAdd(item, 'Add')"
                          small
                          :x-small="$vuetify.breakpoint.smAndDown"
                          v-on="data.on"
                        >
                          <v-icon>mdi-arrow-right-bold</v-icon>
                        </v-btn>
                      </template>
                      <span>Add to Request</span>
                    </v-tooltip>
                  </template>
                </v-data-table>
              </v-card>
            </v-col>

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
                    class="
                      text-subtitle-2
                      text-xl-h6
                      text-lg-h6
                      text-md-subtitle-1
                      text-sm-subtitle-1
                      mb-0 mb-0
                    "
                    >Request List</span
                  >
                </v-card>

                <v-row no-gutters style="height: 60px" align="center">
                  <v-col
                    cols="12"
                    xl="12"
                    lg="12"
                    md="12"
                    sm="12"
                    class="my-0 my-xl-1 my-lg-1 my-md-1 my-sm-0 pa-2"
                  >
                    <v-card-actions class="py-0 px-0">
                      <v-col class="px-0" cols="4" xl="4" lg="4" md="4" sm="4">
                        <div>
                          <span style="color: #616161"
                            >No. of Items:
                            <strong>{{ table2.length }}</strong></span
                          >
                        </div>
                      </v-col>
                      <v-spacer></v-spacer>
                      <v-col
                        class="text-right px-0"
                        cols="8"
                        xl="8"
                        lg="8"
                        md="8"
                        sm="8"
                      >
                        <div v-if="ref">
                          <span style="color: #616161"
                            >Reference No: <strong>{{ ref }}</strong></span
                          >
                        </div>
                      </v-col>
                    </v-card-actions>
                  </v-col>
                </v-row>

                <!-- Table -->
                <v-data-table
                  height="230"
                  dense
                  id="table1"
                  :headers="headers2"
                  :items="table2"
                  :items-per-page="table2.length"
                  hide-default-footer
                  ref="progress"
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

                  <template v-slot:[`item.supply_name`]="{ item }">
                    {{ item.supply_name }} {{ item.description }}</template
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
                          @click="validateAdd(item, 'Update')"
                          small
                          :x-small="$vuetify.breakpoint.smAndDown"
                          v-on="data.on"
                        >
                          <v-icon>mdi-pencil</v-icon>
                        </v-btn>
                      </template>
                      <span>Edit</span>
                    </v-tooltip>
                    <v-tooltip bottom>
                      <template #activator="data">
                        <v-btn
                          icon
                          color="red darken-2"
                          @click="validateAdd(item, 'Delete')"
                          small
                          :x-small="$vuetify.breakpoint.smAndDown"
                          v-on="data.on"
                        >
                          <v-icon>mdi-delete</v-icon>
                        </v-btn>
                      </template>
                      <span>Delete</span>
                    </v-tooltip>
                  </template>
                </v-data-table>
                <v-card-actions class="pa-0 mt-4">
                  <v-spacer></v-spacer>
                  <!-- Buttons -->
                  <v-btn
                    color="error"
                    style="text-transform: none; color: white"
                    :small="$vuetify.breakpoint.smAndDown"
                    class="mb-xl-2 mb-lg-2 mb-md-1 mb-sm-1 mb-1"
                    @click="validate('cancel')"
                    :disabled="disabled"
                    :hidden="isHidden"
                    >Cancel</v-btn
                  >
                  <v-btn
                    color="primary"
                    style="text-transform: none"
                    :small="$vuetify.breakpoint.smAndDown"
                    class="mb-xl-2 mb-lg-2 mb-md-1 mb-sm-1 mb-1"
                    @click="validate('send')"
                    :disabled="disabled || checkLength"
                  >
                    Send Request</v-btn
                  >
                </v-card-actions>
              </v-card>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- Quantity Dialog Form -->
    <v-form ref="form" lazy-validation>
      <v-dialog v-model="dialog" max-width="450px" scrollable>
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
              >Enter Quantity</span
            >
            <v-spacer></v-spacer>
            <v-icon :small="$vuetify.breakpoint.xsOnly" text @click="cancel"
              >mdi-close
            </v-icon>
          </v-toolbar>
          <v-card-text style="height: auto">
            <v-row class="mt-1">
              <v-col class="pt-3" cols="12" xl="12" lg="12" sm="12" md="12">
                <span
                  >Item Selected:
                  <strong
                    >{{ selected.supply_name }}
                    {{ selected.description }}</strong
                  >
                </span>
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
                <!-- Quantity -->
                <v-text-field
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
                  <v-btn
                    style="text-transform: none"
                    color="grey"
                    depressed
                    dark
                    @click="cancel"
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
                    dark
                    :small="$vuetify.breakpoint.smAndDown"
                    @click="commitAdd(selected)"
                    block
                  >
                    {{ type }}
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
                dark
                @click="cancel"
                :small="$vuetify.breakpoint.smAndDown"
                outlined
              >
                <span style="color: #1976d2">Cancel</span>
              </v-btn>
              <v-btn
                style="text-transform: none"
                color="primary"
                depressed
                dark
                :small="$vuetify.breakpoint.smAndDown"
                @click="commitAdd(selected)"
              >
                {{ type }}
              </v-btn>
            </template>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-form>
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
import axios from "axios"; // Library for sending api request
export default {
  middleware: "auth",
  //Computed
  computed: {
    checkLength() {
      if (this.table2.length > 0) {
        this.disabled = false;
      } else {
        this.disabled = true;
      }
    },
  },

  //Data
  data: () => ({
    headers: [
      {
        text: "REQUEST DATE",
        value: "request_date",
        align: "center",
        class: "black--text",
        width: "20%",
      },
      {
        text: "REFERENCE NO.",
        value: "ref",
        filterable: false,
        align: "center",
        class: "black--text",
        width: "20%",
      },
      {
        text: "REQUESTED BY",
        value: "user",
        filterable: false,
        class: "black--text",
        width: "25%",
      },
      {
        text: "STATUS",
        value: "status",
        align: "center",
        filterable: false,
        class: "black--text",
        width: "20%",
      },
      {
        text: "ACTION",
        value: "id",
        align: "center",
        filterable: false,
        sortable: false,
        class: "black--text",
        width: "15%",
      },
    ],

    //Header1
    headers1: [
      {
        text: "CATEGORY",
        value: "category.supply_cat_name",
        class: "black--text",
        filterable: false,
        width: "30%",
      },
      {
        text: "SUPPLY NAME",
        value: "supply_name",
        class: "black--text",
        width: "30%",
      },
      {
        text: "UNIT",
        value: "unit",
        filterable: false,
        class: "black--text",
        width: "25%",
      },
      {
        text: "ACTION",
        value: "id",
        align: "center",
        filterable: false,
        sortable: false,
        class: "black--text",
        width: "15%",
      },
    ],

    //Header2
    headers2: [
      {
        text: "SUPPLY NAME",
        value: "supply_name",
        class: "black--text",
        width: "25%",
      },
      {
        text: "UNIT",
        value: "unit",
        filterable: false,
        class: "black--text",
        width: "20%",
      },
      {
        text: "QTY",
        value: "quantity",
        filterable: false,
        align: "right",
        class: "black--text",
        width: "20%",
      },
      {
        text: "STATUS",
        value: "status",
        filterable: false,
        class: "black--text",
        width: "20%",
      },
      {
        text: "ACTION",
        value: "id",
        align: "center",
        filterable: false,
        sortable: false,
        class: "black--text",
        width: "15%",
      },
    ],

    //Form rules
    formRulesQuantity: [
      (v) => !!v || "This is required",
      (v) => /^[1-9][0-9]*$/.test(v) || "Quantity must be valid",
    ],

    form: {
      quantity: 1,
    },

    disabled: true,
    temp_data: [],
    progressbar: false,
    progressbar1: false,
    snackbar: {
      active: false,
      message: "",
    },
    snackbar2: {
      active: false,
      message: "",
    },
    isHidden: false,
    table: [],
    table1: [],
    table2: [],
    quantity: 1,
    dialog: false,
    dialog_list: false,
    selected: [],
    ref: "",
    type: "",
    page: 1,
    pageCount: 0,
    itemsPerPage: 10,
    search: "",
    cancel_select: [],
    filterDialog: false,
    suppcatlist: [],
    category: "",
  }),

  //Onload
  created() {
    this.get();
    this.suppCat();
  },

  //Watch
  watch: {
    page(val) {
      this.page = val;
      this.get();
    },
  },

  //Methods
  methods: {
    //Keydown
    quantityKeydown(e) {
      if (/[\s~`!@#$%^&()_={}[\]\\"*|:;,.<>+'\/?-]/.test(e.key)) {
        e.preventDefault();
      }
    },

    //Clear value of quantity text-field
    clearQ() {
      if (this.quantity == 1) {
        this.quantity = null;
      }
    },

    //Reset value of quantity text-field
    resetQ() {
      if (this.quantity == null) {
        this.quantity = 1;
      }
    },

    //For validation
    validate(type, data = "") {
      switch (type) {
        case "cancel":
          this.snackbar2 = {
            active: true,
            iconText: "comment-question-outline",
            iconColor: "warning",
            message: "Do you wish to cancel?",
            type: "cancel",
          };
          break;
        case "send":
          this.snackbar2 = {
            active: true,
            iconText: "comment-question-outline",
            iconColor: "warning",
            message: "Do you wish to send this request?",
            type: "send",
          };
          break;
        case "cancelreq":
          this.cancel_select = data;
          this.snackbar2 = {
            active: true,
            iconText: "comment-question-outline",
            iconColor: "warning",
            message: "Do you want to cancel?",
            type: "cancelreq",
          };
          break;
        default:
          break;
      }
    },

    //For action
    action(type) {
      switch (type) {
        case "cancel":
          this.clearRequest1();
          break;
        case "send":
          this.storeRequest();
          break;
        case "cancelreq":
          this.cancelRequest();

          break;
        default:
          break;
      }
      this.snackbar2.active = false;
    },

    //For retrieving supplies list
    async getList() {
      this.progressbar1 = true;
      await axios
        .get("/api/requestsupp/supplies/list", {
          params: { search: this.search, category: this.category },
        })
        .then((result) => {
          this.table1 = result.data;
          this.progressbar1 = false;
        });
    },

    //For retrieving supplies request list
    async get() {
      this.progressbar = true;
      await axios
        .get("/api/requestsupp/get", {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,
          },
        })
        .then((result) => {
          this.table = result.data;
          this.progressbar = false;
        });
    },

    //For retrieving supply categories
    async suppCat() {
      await axios.get("/api/msupp/suppCat").then((supp_cat) => {
        this.suppcatlist = supp_cat.data;
      });
    },

    //For validation
    validateAdd(row, type) {
      this.selected = row;
      this.type = type;
      this.openDialog();
    },

    //For identifying buttons
    commitAdd(row) {
      if (this.$refs.form.validate()) {
        if (this.type == "Update") {
          this.Edit(row);
        } else if (this.type == "Delete") {
          this.Delete(row);
        } else {
          var check_existing = -1;
          //table
          for (var i in this.table2) {
            if (row.id == this.table2[i].id) {
              check_existing = this.table2.indexOf(this.table2[i]);
            }
          }

          if (check_existing > -1) {
            this.table2[check_existing].quantity =
              parseInt(this.table2[check_existing].quantity) +
              parseInt(this.quantity);
          } else {
            this.table2.push({
              id: row.id,
              supply_name:
                row.supply_name +
                " " +
                (row.description != null ? row.description : ""),
              unit: row.unit,
              quantity: this.quantity,
              ref: "",
              status: 0,
            });
            this.snackbar = {
              active: true,
              iconText: "check",
              iconColor: "success",
              message: "Successfully added.",
            };
          }
          this.disabled = false;
        }
        this.dialog = false;
      }
    },

    //For deleting
    Delete(row) {
      this.table2[this.table2.indexOf(row)].quantity =
        this.table2[this.table2.indexOf(row)].quantity - this.quantity;
      if (this.table2[this.table2.indexOf(row)].quantity <= 0) {
        this.table2.splice(this.table2.indexOf(row), 1);
      }
      this.snackbar = {
        active: true,
        iconText: "check",
        iconColor: "success",
        message: "Successfully removed.",
      };
      this.disabled = false;
    },

    //For editing
    Edit(row) {
      this.table2[this.table2.indexOf(row)].quantity = this.quantity;
      for (var key in this.temp_data) {
        for (var key1 in this.temp_data[key]) {
          if (
            this.temp_data[key][key1] != this.table2[key][key1] ||
            this.temp_data.length != this.table2.length
          ) {
            return (this.disabled = false);
          }
        }
        this.disabled = true;
      }
    },

    //For saving requests
    async storeRequest() {
      //This is used for update request
      if (this.ref) {
        for (var key in this.table2) {
          this.table2[key].ref = this.ref;
        }
      }

      //Save
      await axios
        .post("/api/requestsupp/supplies/save", this.table2)
        .then((result) => {
          //If the value is true then save to database
          this.snackbar = {
            active: true,
            iconText: "check",
            iconColor: "success",
            message: "Request has been successfully sent.",
          };
          this.disabled = true;
          this.clearRequest();
          this.get();
        });
    },

    //For adding requests
    addRequest() {
      if (this.headers2.length == 5) {
        this.headers2.splice(this.headers2.indexOf(this.headers2[3]), 1);
      }
      this.disabled = true;
      this.dialog_list = true;
      this.getList();
    },

    //For viewing requests
    async viewRequest(ref) {
      (this.headers2 = [
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
          text: "QTY",
          value: "quantity",
          filterable: false,
          align: "right",
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
      ]),
        (this.isHidden = true);

      //For retrieving supply request list
      this.getList();
      await axios
        .get("/api/requestsupp/request/list", { params: { ref: ref.ref } })
        .then((result) => {
          this.temp_data = JSON.parse(JSON.stringify(result.data));
          this.table2 = result.data;
          this.dialog_list = true;
          this.ref = ref.ref;
        });
    },

    //For closing requests
    closeRequest() {
      this.dialog_list = false;
      this.disabled = true;
      this.clearRequest();
    },

    //For clearing requests
    clearRequest() {
      this.table2 = [];
      this.ref = "";
    },

    //For clearing requests1
    clearRequest1() {
      this.table2 = [];
      this.disabled = true;
      this.ref = "";
      this.snackbar = {
        active: true,
        iconText: "check",
        iconColor: "success",
        message: "Successfully cancelled.",
      };
    },

    getFormatDate(e, format) {
      const date = moment(e);
      return date.format(format);
    },

    //For cancelling requests
    async cancelRequest() {
      await axios
        .post("/api/requestsupp/request/cancel", this.cancel_select)
        .then((result) => {
          //If the value is true then save to database
          this.snackbar = {
            active: true,
            iconText: "check",
            iconColor: "success",
            message: "Request has been successfully cancelled.",
          };
          this.get();
        });
    },

    //For completing requests
    async completeRequest(ref) {
      await axios
        .post("/api/requestsupp/request/complete", ref)
        .then((result) => {
          //If the value is true then save to database
          this.snackbar = {
            active: true,
            iconText: "check",
            iconColor: "success",
            message: "Request has been successfully completed.",
          };
          this.get();
        });
    },

    openDialog() {
      this.quantity = 1;
      this.dialog = true;
    },

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
};
</script>

