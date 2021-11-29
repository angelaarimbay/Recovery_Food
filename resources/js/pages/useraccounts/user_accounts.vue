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
          User Accounts
          <!-- {{ json_encode($auth_user)  }} -->
          <!-- <div  v-if="$can('Access Inventory')">yes</div> -->
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
            >User Accounts</v-btn
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
              @click="addnew"
            >
              Add User
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
                      placeholder="Name"
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
              </v-row>
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
          <template v-slot:[`item.roles`]="{ item }">
            <span v-for="(val, key) in item.roles" :key="key">
              <v-chip :small="$vuetify.breakpoint.smAndDown">
                {{ val.name }}
              </v-chip>
            </span>
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

        <!-- Dialog Form -->
        <v-form ref="form">
          <v-dialog
            v-model="dialog"
            max-width="450px"
            persistent
            no-click-animation
          >
            <v-card tile class="pa-3">
              <v-toolbar dark dense flat rounded class="red darken-3">
                User
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
                  </v-col>

                  <v-col
                    class="tfield py-0"
                    cols="12"
                    xl="6"
                    lg="6"
                    sm="6"
                    md="6"
                  >
                    <!-- First Name -->
                    <v-text-field
                      :rules="formRules"
                      v-model="form.first_name"
                      clearable
                      dense
                      counter
                      @keydown="valueKeydown($event)"
                      maxlength="25"
                      background-color="white"
                      flat
                      solo
                      style="font-size: 12px"
                    >
                      <template slot="label">
                        <div style="font-size: 12px">
                          First Name <span style="color: red">*</span>
                        </div>
                      </template>
                    </v-text-field>
                  </v-col>

                  <v-col
                    class="tfield py-0"
                    cols="12"
                    xl="6"
                    lg="6"
                    sm="6"
                    md="6"
                  >
                    <!-- Last Name -->
                    <v-text-field
                      :rules="formRules"
                      v-model="form.last_name"
                      clearable
                      dense
                      counter
                      @keydown="valueKeydown($event)"
                      maxlength="25"
                      background-color="white"
                      flat
                      solo
                      style="font-size: 12px"
                    >
                      <template slot="label">
                        <div style="font-size: 12px">
                          Last Name <span style="color: red">*</span>
                        </div>
                      </template>
                    </v-text-field>
                  </v-col>

                  <v-col
                    class="tfield py-0"
                    cols="12"
                    xl="12"
                    lg="12"
                    sm="12"
                    md="12"
                  >
                    <!-- Email -->
                    <v-text-field
                      :rules="formRulesEmail"
                      v-model="form.email"
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
                    class="tfield py-0"
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
                      @keydown="contactKeydown($event)"
                      maxlength="15"
                      counter
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
                    class="tfield py-0"
                    cols="12"
                    xl="12"
                    lg="12"
                    sm="12"
                    md="12"
                    v-if="passwords"
                  >
                    <!-- Password -->
                    <v-text-field
                      :rules="formRules"
                      v-model="form.password"
                      :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                      :type="show1 ? 'text' : 'password'"
                      @click:append="show1 = !show1"
                      @input="inputPass"
                      clearable
                      dense
                      counter
                      maxlength="20"
                      background-color="white"
                      flat
                      solo
                      style="font-size: 12px"
                    >
                      <template slot="label">
                        <div style="font-size: 12px">
                          Password <span style="color: red">*</span>
                        </div>
                      </template>
                    </v-text-field>
                  </v-col>

                  <v-col
                    class="tfield py-0"
                    cols="12"
                    xl="12"
                    lg="12"
                    sm="12"
                    md="12"
                    v-if="
                      passwords &&
                      this.form.password !== null &&
                      this.form.password.length !== 0
                    "
                  >
                    <!-- Confirm Password -->
                    <v-text-field
                      :rules="[
                        form.password === form.confirmPass ||
                          'Password must match',
                      ]"
                      v-model="form.confirmPass"
                      :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
                      :type="show2 ? 'text' : 'password'"
                      @click:append="show2 = !show2"
                      clearable
                      dense
                      counter
                      maxlength="20"
                      background-color="white"
                      flat
                      solo
                      style="font-size: 12px"
                    >
                      <template slot="label">
                        <div style="font-size: 12px">
                          Confirm Pass <span style="color: red">*</span>
                        </div>
                      </template>
                    </v-text-field>
                  </v-col>

                  <v-col
                    class="tfield py-0"
                    cols="12"
                    xl="12"
                    lg="12"
                    sm="12"
                    md="12"
                  >
                    <!-- User Role -->
                    <v-combobox
                      class="d-none"
                      :rules="formRulesNumber"
                      :items="userrolelist"
                      dense
                      small-chips
                      multiple
                      item-text="name"
                      background-color="white"
                      flat
                      solo
                      style="font-size: 12px"
                    >
                      <template slot="label">
                        <div style="font-size: 12px">
                          User Role <span style="color: red">*</span>
                        </div>
                      </template>
                    </v-combobox>
                  </v-col>

                  <v-col
                    class="tfield py-0"
                    cols="12"
                    xl="12"
                    lg="12"
                    sm="12"
                    md="12"
                  >
                    <!-- Branch -->
                    <v-select
                      :rules="formRulesNumberRange"
                      v-model="form.branch"
                      :items="branchlist"
                      item-text="branch_name"
                      item-value="id"
                      dense
                      background-color="white"
                      flat
                      solo
                      style="font-size: 12px"
                    >
                      <template slot="label">
                        <div style="font-size: 12px">
                          Branch <span style="color: red">*</span>
                        </div>
                      </template>
                    </v-select>
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
      </v-container>
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
    return { title: "User Accounts" };
  },
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
    inputPass() {
      if (this.form.password == null || this.form.password.length == 0) {
        this.form.confirmPass = null;
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
    userrolelist: [],
    search: "",
    button: false,
    dialog: false,
    sheet: false,
    show1: false,
    show2: false,
    filterDialog: false,
    password: "",
    confirmPass: "",
    table: [],
    branchlist: [],

    //Form rules
    formRules: [
      (v) => (!!v && v.length >= 3) || "This is required",
      (v) =>
        /^(?:([A-Za-z])(?!\1{2})|([0-9])(?!\2{7})|([\s,'-_/])(?!\3{1}))+$/i.test(
          v
        ) || "This field must have a valid value",
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
    formRulesNumberRange: [
      (v) => {
        if (!isNaN(parseFloat(v)) && v >= 0 && v <= 9999999) return true;
        return "This is required";
      },
    ],
    formRulesNumber: [
      (v) => Number.isInteger(Number(v)) || "The value must be an integer",
    ],

    //Form Data
    form: {
      id: null,
      first_name: null,
      last_name: null,
      email: null,
      phone_number: null,
      password: null,
      confirmPass: null,
      branch: [],
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
        text: "NAME",
        value: "name",
        class: "black--text",
      },
      {
        text: "EMAIL",
        value: "email",
        filterable: false,
        class: "black--text",
      },
      {
        text: "BRANCH",
        value: "branch.branch_name",
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
    passwords: true,
  }),

  //Onload
  created() {
    if (this.user.permissionslist.includes("Access User Accounts")) {
      this.get();
      // this.getUserRoles();
      this.branchName();
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

    addnew() {
      this.passwords = true;
      this.dialog = true;
    },

    itemperpage() {
      this.page = 1;
      this.get();
    },

    //For retrieving user roles
    async getUserRoles() {
      await axios.get("/api/useracc/getRoles").then((result) => {
        this.userrolelist = result.data.data;
      });
    },

    //For retrieving branch names
    async branchName() {
      await axios.get("api/useracc/branchName").then((bran_name) => {
        this.branchlist = bran_name.data;
      });
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
          if (key == "branch") {
            if (this.currentdata.branch) {
              if (this.currentdata.branch.id != this.form.branch) {
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
            .post("api/useracc/save", this.form)
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
                    message: "The email already exists.",
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

    //For retrieving user accounts
    async get() {
      this.progressbar = true; //Show the progress bar
      //Get data from tables
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;
      await axios
        .get("api/useracc/get", {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,
            search: this.search,
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

    //Editing/updating of row
    edit(row) {
      this.passwords = false;
      this.currentdata = JSON.parse(JSON.stringify(row));
      this.form.id = row.id;
      this.form.first_name = row.first_name;
      this.form.last_name = row.last_name;
      this.form.email = row.email;
      this.form.phone_number = row.phone_number;
      this.form.branch = row.branch.id;

      this.dialog = true;
    },

    //Reset Forms
    cancel() {
      this.$refs.form.reset();
      this.dialog = false;
    },

    //For refresh
    refresh() {
      this.get();
      // this.getUserRoles();
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
    id: {
      handler: function (v) {},
    },
  },
};
</script>
