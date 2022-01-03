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
            >Manage Branches</v-btn
          >
        </v-card-actions>
      </v-layout>
    </v-container>

    <!-- Main Card -->
    <v-card elevation="1" class="mt-2" style="border-radius: 10px">
      <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
        <v-card-actions class="px-0">
          <v-row align="center" no-gutters>
            <!-- Add Branch Button -->
            <v-btn
              color="primary"
              style="text-transform: none"
              depressed
              dark
              :small="$vuetify.breakpoint.smAndDown"
              @click="openDialog"
            >
              Add Branch
            </v-btn>
            <v-spacer></v-spacer>
            <v-card color="red darken-3" flat style="border-radius: 20px">
              <!-- Refresh Button -->
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
              <!-- Filter Button -->
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
                        placeholder="Branch Name"
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

          <template v-slot:[`item.count`]="{ item }"> {{ item.row }}</template>

          <template v-slot:[`item.type`]="{ item }">
            <div v-if="item.type == 0">Branch</div>
            <div v-else>Warehouse</div>
          </template>
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
            <!-- Actions Button -->
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

      <!-- View Dialog Form -->
      <v-form ref="form">
        <v-dialog v-model="viewdialog" max-width="500px" scrollable>
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
                >View Branch</span
              >
              <v-spacer></v-spacer>
              <v-icon
                :small="$vuetify.breakpoint.xsOnly"
                text
                @click="closeViewDialog"
                >mdi-close
              </v-icon>
            </v-toolbar>
            <v-card-text style="max-height: auto">
              <v-card-title
                class="
                  text-subtitle-1 text-xl-h5 text-lg-h5 text-md-h6 text-sm-h6
                  font-weight-bold
                  justify-center
                  py-xl-3 py-lg-3 py-md-2 py-sm-2 py-1
                  my-0
                "
                style="color: #827717"
              >
                {{ form.branch_name }}
              </v-card-title>
              <v-img
                :src="form.branch_image"
                class="mx-auto mb-4"
                contain
                max-width="480px"
                max-height="300px"
              ></v-img>
              <v-divider class="my-0"></v-divider>
              <v-card-text
                class="
                  text-body-2
                  text-xl-subtitle-1
                  text-lg-subtitle-1
                  text-md-subtitle-1
                  text-sm-subtitle-1
                  px-1
                  py-1
                  my-xl-3 my-lg-3 my-md-2 my-sm-1 my-1
                "
              >
                <v-row no-gutters>
                  <v-col cols="1">
                    <v-icon
                      color="red darken-2"
                      :small="$vuetify.breakpoint.xsOnly"
                      >mdi-map-marker</v-icon
                    ></v-col
                  ><v-col cols="11" class="my-auto">{{
                    form.location
                  }}</v-col></v-row
                >
              </v-card-text>
              <v-card-text
                class="
                  text-body-2
                  text-xl-subtitle-1
                  text-lg-subtitle-1
                  text-md-subtitle-1
                  text-sm-subtitle-1
                  px-1
                  py-1
                  my-xl-3 my-lg-3 my-md-2 my-sm-1 my-1
                "
              >
                <v-row no-gutters>
                  <v-col cols="1">
                    <v-icon
                      color="red darken-2"
                      :small="$vuetify.breakpoint.xsOnly"
                      >mdi-email</v-icon
                    ></v-col
                  ><v-col cols="11" class="my-auto">{{
                    form.email_add
                  }}</v-col></v-row
                >
              </v-card-text>
              <v-card-text
                class="
                  text-body-2
                  text-xl-subtitle-1
                  text-lg-subtitle-1
                  text-md-subtitle-1
                  text-sm-subtitle-1
                  px-1
                  py-1
                  my-xl-3 my-lg-3 my-md-2 my-sm-1 my-1
                "
              >
                <v-row no-gutters>
                  <v-col cols="1">
                    <v-icon
                      color="red darken-2"
                      :small="$vuetify.breakpoint.xsOnly"
                      >mdi-phone</v-icon
                    ></v-col
                  ><v-col cols="11" class="my-auto">{{
                    form.phone_number
                  }}</v-col></v-row
                >
              </v-card-text>
            </v-card-text>
          </v-card>
        </v-dialog>
      </v-form>

      <!-- Dialog Form-->
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
                >Branch</span
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
                  xl="6"
                  lg="6"
                  sm="6"
                  md="6"
                >
                  <!-- Type -->
                  <v-select
                    :rules="formRulesBasic"
                    v-model="form.type"
                    dense
                    :items="[
                      { name: 'Branch', id: '0' },
                      { name: 'Warehouse', id: '1' },
                    ]"
                    item-text="name"
                    item-value="id"
                    background-color="white"
                    flat
                    solo
                    style="font-size: 12px"
                  >
                    <template slot="label">
                      <div style="font-size: 12px">
                        Type <span style="color: red">*</span>
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
                  xl="12"
                  lg="12"
                  sm="12"
                  md="12"
                >
                  <!-- Branch Name -->
                  <v-text-field
                    :rules="formRules"
                    v-model="form.branch_name"
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
                        Branch Name <span style="color: red">*</span>
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
                  <!-- Location -->
                  <v-text-field
                    :rules="formRules"
                    v-model="form.location"
                    clearable
                    dense
                    counter
                    @keydown="valueKeydown($event)"
                    maxlength="60"
                    background-color="white"
                    flat
                    solo
                    style="font-size: 12px"
                  >
                    <template slot="label">
                      <div style="font-size: 12px">
                        Location <span style="color: red">*</span>
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
                  <!-- Contact Number -->
                  <v-text-field
                    :rules="formRulesNumberOnly"
                    v-model="form.phone_number"
                    clearable
                    dense
                    counter
                    @keydown="contactKeydown($event)"
                    maxlength="15"
                    background-color="white"
                    flat
                    solo
                    style="font-size: 12px"
                    v-mask="mask"
                  >
                    <template slot="label">
                      <div style="font-size: 12px">
                        Contact Number <span style="color: red">*</span>
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
                  <!-- Email Address -->
                  <v-text-field
                    :rules="formRulesEmail"
                    v-model="form.email_add"
                    clearable
                    dense
                    counter
                    maxlength="64"
                    background-color="white"
                    flat
                    solo
                    style="font-size: 12px"
                  >
                    <template slot="label">
                      <div style="font-size: 12px">
                        Email Address <span style="color: red">*</span>
                      </div>
                    </template>
                  </v-text-field>
                </v-col>

                <v-col
                  class="py-0 px-1"
                  cols="12"
                  xl="12"
                  lg="12"
                  sm="12"
                  md="12"
                >
                  <span style="font-size: 12px">Image Attachment:</span>
                  <!-- <v-img width="200" :src="'/storage/branches/'+form.branch_image"></v-img> -->
                  <!-- Check if has image, then display the image -->
                  <div style="font-size: 12px" v-if="form.branch_image">
                    <v-row no-gutters>
                      <!-- Upload -->
                      <v-col cols="11">
                        <a
                          :href="'/storage/branches/' + form.branch_image"
                          style="text-decoration: none"
                          download
                        >
                          {{ tempfile }}
                        </a>
                      </v-col>
                      <!-- Delete Button -->
                      <v-col cols="1" class="text-center">
                        <v-tooltip bottom>
                          <template #activator="data">
                            <v-icon
                              v-on="data.on"
                              color="red darken-2"
                              v-if="form.branch_image"
                              @click="deletefile"
                              >mdi-delete</v-icon
                            >
                          </template>
                          <span>Remove Image</span>
                        </v-tooltip>
                      </v-col>
                    </v-row>
                  </div>

                  <!-- Progressbar For Uploading -->
                  <v-progress-linear
                    v-show="loading"
                    slot="progress"
                    color="red darken-2"
                    indeterminate
                  ></v-progress-linear>

                  <!-- Upload Button -->
                  <v-btn
                    outlined
                    color="grey darken-1"
                    class="btn-block"
                    style="text-transform: none; font-size: 12px"
                    @click="clickupload"
                    ><v-icon>mdi-upload</v-icon> Upload Image
                  </v-btn>

                  <!-- For Uploading  -->
                  <input
                    id="upload"
                    ref="uploader"
                    clearable
                    accept="image/png, image/jpeg"
                    class="d-none"
                    type="file"
                    @change="attachment"
                  />
                </v-col>
                <v-col class="py-1" cols="12" xl="12" lg="12" sm="12" md="4">
                  <v-text-field
                    style="display: none"
                    v-model="form.branch_image"
                    label="Document"
                  ></v-text-field>
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
const PHONE_NUMBER = "(####) ###-####";
const TELEPHONE_NUMBER = "(###) ###-####";
import { mapGetters } from "vuex";
import axios from "axios"; // Library for sending api request
export default {
  middleware: "auth",
  metaInfo() {
    return { title: "Branches" };
  },
  //Data
  data: () => ({
    value: "",
    progressbar: false,
    loading: false,
    snackbar: {
      active: false,
      message: "",
    },
    search: "",
    button: false,
    dialog: false,
    viewdialog: false,
    filterDialog: false,
    status: [
      { name: "Available", id: 1 },
      { name: "Unavailable", id: 0 },
    ],
    tempfile: "", //For uploading
    table: [],

    //Form Rules
    formRulesBasic: [(v) => !!v || "This is required"],
    formRules: [
      (v) => (!!v && v.length >= 3) || "This is required",
      (v) =>
        /^(?:([A-Za-z])(?!\1{2})|([0-9])(?!\2{7})|([\s,'-_/])(?!\3{1}))+$/i.test(
          v
        ) || "This field must have a valid value",
    ],
    formRulesNumberRange: [
      (v) => {
        if (!isNaN(parseFloat(v)) && v >= 0 && v <= 1) return true;
        return "This is required";
      },
    ],
    formRulesEmail: [
      (v) => !!v || "This is required",
      (v) =>
        /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
        "E-mail must be valid",
    ],
    formRulesNumberOnly: [
      (v) => !!v || "This field is required",
      (v) => (!!v && v.length >= 7) || "Contact number must be valid",
    ],

    //Form Data
    form: {
      id: null,
      status: null,
      branch_name: null,
      location: null,
      phone_number: null,
      email_add: null,
      branch_image: null,
      type: 0,
    },

    //For comparing data
    currentdata: {
      id: null,
      status: null,
      branch_name: null,
      location: null,
      phone_number: null,
      email_add: null,
      branch_image: null,
      type: null,
    },

    //Table Headers
    headers: [
      {
        text: "#",
        value: "count",
        align: "center",
        filterable: false,
        class: "black--text",
        sortable: false,
        width: "10%",
      },
      {
        text: "BRANCH NAME",
        value: "branch_name",
        class: "black--text",
        width: "30%",
      },
      {
        text: "TYPE",
        value: "type",
        filterable: false,
        class: "black--text",
        width: "20%",
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
        sortable: false,
        filterable: false,
        class: "black--text",
        width: "20%",
      },
    ],
    page: 1,
    pageCount: 0,
    itemsPerPage: 10,
  }),

  //Computed
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
    mask() {
      return this.isNumber ? PHONE_NUMBER : TELEPHONE_NUMBER;
    },
    isNumber() {
      if (this.form.phone_number !== null) {
        return this.form.phone_number
          ? this.form.phone_number.substr(1, 2) === "09"
          : this.form.phone_number === null;
      }
    },
  },

  //Onload
  created() {
    if (this.user.permissionslist.includes("Access Branches")) {
      this.get();
    } else {
      this.$router.push({ name: "invalid-page" }).catch((errr) => {});
    }
  },

  //Methods
  methods: {
    //Keydown
    valueKeydown(e) {
      if (/[~`!@#$%^&()_={}[\]\\"*|:;.<>+\?]/.test(e.key)) {
        e.preventDefault();
      }
    },
    contactKeydown(e) {
      if (/[\s~`!@#$%^&()_={}[\]\\"*|:;,.<>+'\/?-]/.test(e.key)) {
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
          if (key == "branch_image") {
            if (
              this.currentdata.branch_image == "/img/Logo.jpg" &&
              !this.form[key]
            ) {
            } else {
              if (this.currentdata.branch_image != !this.form[key]) {
                found += 1;
              }
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
        if (this.compare()) {
          //Save or update data in the table
          await axios
            .post("/api/branches/save", this.form)
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
                    message: "The branch name already exists.",
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
    },

    async get() {
      this.progressbar = true; //Show the progress bar
      //Get data from tables
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;
      await axios
        .get("/api/branches/get", {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,
            search: this.search,
          },
        })
        .then((result) => {
          //If the value is true then get the data
          this.table = result.data;
          this.progressbar = false; // Hide the progress bar
        })
        .catch((result) => {
          //If false or error when saving
        });
    },

    //For uploading
    clickupload() {
      this.isSelecting = true;
      window.addEventListener(
        "focus",
        () => {
          this.isSelecting = false;
        },
        { once: true }
      );
      this.$refs.uploader.click();
    },

    //For deleting
    deletefile() {
      this.$refs.uploader.value = null;
      this.tempfile = null;
      this.form.branch_image = null;
    },

    //For attachment
    async attachment(e) {
      if (e.target.files[0].size > 10485760) {
        this.snackbar = {
          active: true,
          iconText: "alert-box",
          iconColor: "error",
          message: "The image size should be less than or equal to 10 MB.",
        };
      } else {
        var file = document.querySelector("#upload");
        if (/\.(jpe?g|png)$/i.test(file.files[0].name) === false) {
          this.snackbar = {
            active: true,
            iconText: "alert-box",
            iconColor: "error",
            message: "Please select JPEG or PNG only.",
          };
        } else {
          this.loading = true;
          var dataform = new FormData(); //Can use typical jquery form data
          dataform.append("file", e.target.files[0]);
          await axios
            .post("/api/branches/attachment", dataform, {
              headers: { "Content-Type": "multipart/form-data" },
            })
            .then((result) => {
              this.tempfile = result.data.fakename;
              this.form.branch_image = result.data.filename;
              this.loading = false;
            });
        }
      }
    },

    //Editing/updating of row
    edit(row) {
      this.currentdata = JSON.parse(JSON.stringify(row));
      this.form.id = row.id;
      this.form.status = row.status;
      this.form.branch_name = row.branch_name;
      this.form.location = row.location;
      this.form.phone_number = row.phone_number;
      this.form.email_add = row.email_add;
      this.form.type = row.type.toString();
      this.form.branch_image =
        row.branch_image == "/img/Logo.jpg" ? null : row.branch_image;
      this.tempfile = row.branch_image
        ? row.branch_image == "/img/Logo.jpg"
          ? null
          : row.branch_image.split("-")[0]
        : null;
      this.dialog = true;
    },

    //Open Dialog Form
    openDialog() {
      this.$refs.form.resetValidation();
      for (var key in this.form) {
        this.form[key] = "";
      }
      this.dialog = true;
    },

    //View Branch Info
    openViewDialog(row) {
      this.currentdata = JSON.parse(JSON.stringify(row));
      this.form.id = row.id;
      this.form.status = row.status;
      this.form.branch_name = row.branch_name;
      this.form.location = row.location;
      this.form.phone_number = row.phone_number;
      this.form.type = row.type.toString();
      this.form.email_add = row.email_add;
      this.form.branch_image =
        row.branch_image == "/img/Logo.jpg"
          ? "/img/Logo.jpg"
          : "/storage/branches/" + row.branch_image;
      this.viewdialog = true;
    },

    //Reset Forms
    cancel() {
      for (var key in this.form) {
        this.form[key] = "";
      }
      this.dialog = false;
    },

    //Close View Dialog
    closeViewDialog() {
      this.viewdialog = false;
    },

    //For refresh
    refresh() {
      this.get();
    },
  },

  //Watch
  watch: {
    dialog(val) {
      val || this.cancel();
    },
    viewdialog(val) {
      val || this.closeViewDialog();
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
