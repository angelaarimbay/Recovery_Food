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

    <v-snackbar
      :vertical="$vuetify.breakpoint.xsOnly"
      min-width="auto"
      v-model="snackbar2.active"
      timeout="10000"
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

    <v-form ref="mainForm" id="mainForm">
      <!-- Role Dialog Form  -->
      <v-dialog v-model="dialogRoles" max-width="450px">
        <v-toolbar
          dense
          dark
          class="pl-xl-6 pl-lg-6 pl-md-6 pl-sm-5 pl-3 red darken-2"
        >
          Add New Role
          <v-spacer></v-spacer>
          <v-tooltip bottom>
            <template #activator="data">
              <v-icon
                class="mr-xl-4 mr-lg-4 mr-md-4 mr-sm-3 mr-1"
                v-on="data.on"
                text
                @click="cancelRoles"
                >mdi-close
              </v-icon>
            </template>
            <span>Close</span>
          </v-tooltip>
        </v-toolbar>
        <v-card tile id="dialog" style="background-color: #f5f5f5">
          <v-card-text class="py-2">
            <br />
            <v-container class="pa-xl-3 pa-lg-3 pa-md-2 pa-sm-0 pa-0">
              <v-row>
                <v-col class="py-0" cols="12" xl="12" lg="12" sm="12" md="12">
                  <v-text-field v-model="role.id" class="d-none">
                  </v-text-field>
                  <v-text-field
                    :rules="formRules"
                    v-model="role.name"
                    outlined
                    clearable
                    dense
                    counter
                    @keydown="valueKeydown($event)"
                    maxlength="20"
                  >
                    <template slot="label">
                      <div style="font-size: 14px">Role Name *</div>
                    </template>
                  </v-text-field>
                </v-col>
                <v-col class="py-0" cols="12" xl="12" lg="12" sm="12" md="12">
                  <v-text-field
                    :rules="formRulesDesc"
                    v-model="role.description"
                    outlined
                    clearable
                    dense
                    counter
                    @keydown="valueKeydown($event)"
                    maxlength="25"
                  >
                    <template slot="label">
                      <div style="font-size: 14px">Role Description</div>
                    </template>
                  </v-text-field>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>

          <!-- Role Dialog Form Button  -->
          <v-card-actions class="px-xl-9 px-lg-9 px-md-8 px-sm-6 px-6 py-4">
            <v-spacer></v-spacer>
            <v-btn
              color="error"
              depressed
              dark
              @click="cancelRoles"
              style="text-transform: none"
              :small="$vuetify.breakpoint.smAndDown"
            >
              Cancel
            </v-btn>
            <v-btn
              color="primary"
              depressed
              dark
              @click="storeRoles"
              style="text-transform: none"
              :small="$vuetify.breakpoint.smAndDown"
            >
              Save
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- Permission Dialog Form -->
      <v-dialog v-model="dialogPermissions" max-width="450px">
        <v-toolbar
          dense
          dark
          class="pl-xl-6 pl-lg-6 pl-md-6 pl-sm-5 pl-3 red darken-2"
        >
          Add New Permission
          <v-spacer></v-spacer>
          <v-tooltip bottom>
            <template #activator="data">
              <v-icon
                class="mr-xl-4 mr-lg-4 mr-md-4 mr-sm-3 mr-1"
                v-on="data.on"
                text
                @click="dialogPermissions = false"
                >mdi-close
              </v-icon>
            </template>
            <span>Close</span>
          </v-tooltip>
        </v-toolbar>
        <v-card tile style="background-color: #f5f5f5">
          <v-card-text class="py-2">
            <br />
            <v-container class="pa-xl-3 pa-lg-3 pa-md-2 pa-sm-0 pa-0">
              <v-row>
                <v-col class="py-0" cols="12" xl="12" lg="12" sm="12" md="12">
                  <v-text-field v-model="permission.id" class="d-none">
                  </v-text-field>
                  <v-text-field
                    :rules="formRules"
                    v-model="permission.name"
                    outlined
                    clearable
                    dense
                  >
                    <template slot="label">
                      <div style="font-size: 14px">Permission Name *</div>
                    </template>
                  </v-text-field>
                </v-col>
                <v-col class="py-0" cols="12" xl="12" lg="12" sm="12" md="12">
                  <v-text-field
                    :rules="formRules"
                    v-model="permission.description"
                    outlined
                    clearable
                    dense
                  >
                    <template slot="label">
                      <div style="font-size: 14px">Permission Description</div>
                    </template>
                  </v-text-field>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>

          <!-- Permission Dialog Form Button -->
          <v-card-actions class="px-xl-9 px-lg-9 px-md-8 px-sm-6 px-6 py-4">
            <v-spacer></v-spacer>
            <v-btn
              color="primary"
              depressed
              dark
              @click="validate('permission')"
              style="text-transform: none"
              :small="$vuetify.breakpoint.smAndDown"
            >
              Save
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- Add Permission To Role Dialog -->
      <v-dialog v-model="dialogAddPermissions" max-width="900px">
        <v-card id="dialog" class="bgcolor">
          <v-toolbar
            dense
            dark
            class="pl-xl-6 pl-lg-6 pl-md-6 pl-sm-5 pl-3 red darken-2"
          >
            Add Role Permission(s)
            <v-spacer></v-spacer>
            <v-tooltip bottom>
              <template #activator="data">
                <v-icon
                  class="mr-xl-4 mr-lg-4 mr-md-4 mr-sm-3 mr-1"
                  v-on="data.on"
                  text
                  @click="dialogAddPermissions = false"
                  >mdi-close
                </v-icon>
              </template>
              <span>Close</span>
            </v-tooltip>
          </v-toolbar>

          <v-card tile>
            <v-card-text class="py-2">
              <br />
              <v-data-table
                class="px-4"
                v-model="selectedAddPermission"
                :items-per-page="5"
                dense
                :loading="progressBar"
                :headers="headersAddPermissions"
                :items="tablePermissions"
                show-select
              >
                <v-progress-linear
                  v-show="progressBar"
                  slot="progress"
                  color="red darken-2"
                  indeterminate
                ></v-progress-linear>
              </v-data-table>
            </v-card-text>

            <v-card-actions class="px-xl-9 px-lg-9 px-md-8 px-sm-6 px-6 py-4">
              <v-spacer></v-spacer>
              <v-btn
                color="primary"
                style="text-transform: none"
                depressed
                dark
                @click="validate('permission')"
              >
                Save
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-card>
      </v-dialog>

      <!-- Add User To Role Dialog -->
      <v-dialog v-model="dialogAddRoles" max-width="900px">
        <v-card id="dialog" class="bgcolor">
          <v-toolbar
            dense
            dark
            class="pl-xl-6 pl-lg-6 pl-md-6 pl-sm-5 pl-3 red darken-2"
          >
            Add User Role(s)
            <v-spacer></v-spacer>
            <v-tooltip bottom>
              <template #activator="data">
                <v-icon
                  class="mr-xl-4 mr-lg-4 mr-md-4 mr-sm-3 mr-1"
                  v-on="data.on"
                  text
                  @click="cancelUserRoles"
                  >mdi-close
                </v-icon>
              </template>
              <span>Close</span>
            </v-tooltip>
          </v-toolbar>

          <v-card tile>
            <v-card-text class="py-2">
              <v-card-text>
                Selected User : <strong>{{ username }}</strong></v-card-text
              >
              <v-data-table
                class="px-4"
                v-model="selectedAddRoles"
                :items-per-page="5"
                dense
                :loading="progressBar"
                :headers="headersAddRoles"
                :items="tableAddRoles.data"
                show-select
              >
                <v-progress-linear
                  v-show="progressBar"
                  slot="progress"
                  color="red darken-2"
                  indeterminate
                ></v-progress-linear>
              </v-data-table>
              <div class="text-center pt-2 d-none">
                <v-pagination
                  v-model="page3"
                  :total-visible="7"
                  :length="tableAddRoles.last_page"
                  color="red darken-2"
                ></v-pagination>
              </div>
            </v-card-text>

            <v-card-actions class="px-xl-9 px-lg-9 px-md-8 px-sm-6 px-6 py-4">
              <v-spacer></v-spacer>
              <v-btn
                color="primary"
                style="text-transform: none"
                depressed
                dark
                @click="validate('userrole')"
              >
                Save
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-card>
      </v-dialog>

      <v-container>
        <v-layout row wrap>
          <h4
            class="font-weight-bold heading my-auto"
            :class="{ h5: $vuetify.breakpoint.smAndDown }"
          >
            Roles/Permissions
          </h4>
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
              >Roles/Permissions</v-btn
            >
          </v-card-actions>
        </v-layout>
      </v-container>

      <!-- Main Card -->
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
            :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
            style="text-transform: none"
            @click="getRoles"
          >
            Roles List
          </v-tab>
          <v-tab
            class="
              text-body-2
              text-xl-subtitle-1
              text-lg-subtitle-1
              text-md-subtitle-2
              text-sm-body-1
              d-none
            "
            :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
            style="text-transform: none"
            @click="getPermissions"
          >
            Permissions List
          </v-tab>
          <v-tab
            class="
              text-body-2
              text-xl-subtitle-1
              text-lg-subtitle-1
              text-md-subtitle-2
              text-sm-body-1
            "
            :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
            style="text-transform: none"
            @click="getUserRoles"
          >
            User Roles
          </v-tab>
          <!-- <v-tab
            class="
              text-body-2
              text-xl-subtitle-1
              text-lg-subtitle-1
              text-md-subtitle-2
              text-sm-body-1 
            "
            :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
            style="text-transform: none"
          >
            Dev
          </v-tab> -->
        </v-tabs>

        <v-tabs-items v-model="tab">
          <v-tab-item>
            <!-- Roles List -->
            <v-container class="py-0">
              <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
                <v-card-actions class="px-0">
                  <!-- Buttons -->
                  <v-btn
                    color="primary"
                    style="text-transform: none"
                    depressed
                    dark
                    :small="$vuetify.breakpoint.smAndDown"
                    @click="openDialogRoles"
                  >
                    Add New
                  </v-btn>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="success"
                    style="text-transform: none"
                    depressed
                    :small="$vuetify.breakpoint.smAndDown"
                    dark
                    @click="getRoles"
                    >Refresh</v-btn
                  >
                </v-card-actions>

                <!-- Roles List Table -->
                <v-data-table
                  hide-default-footer
                  id="table"
                  :items-per-page="5"
                  :loading="progressBar"
                  :headers="headersRoles"
                  :items="tableRoles.data"
                >
                  <v-progress-linear
                    v-show="progressBar"
                    slot="progress"
                    color="red darken-2"
                    class="px-0 mx-0"
                    indeterminate
                    rounded
                  ></v-progress-linear>

                  <template v-slot:[`item.id`]="{ item }">
                    <v-tooltip bottom>
                      <template #activator="data">
                        <v-btn
                          icon
                          color="red darken-2"
                          @click="editItemRoles(item)"
                          v-on="data.on"
                          :x-small="$vuetify.breakpoint.smAndDown"
                        >
                          <v-icon> mdi-pencil </v-icon>
                        </v-btn>
                      </template>
                      <span>Edit Role</span>
                    </v-tooltip>

                    <v-tooltip bottom>
                      <template #activator="data">
                        <v-btn
                          icon
                          color="red darken-2"
                          @click="addPermission(item)"
                          v-on="data.on"
                          :x-small="$vuetify.breakpoint.smAndDown"
                        >
                          <v-icon> mdi-plus </v-icon>
                        </v-btn>
                      </template>
                      <span>Add Role(s)</span>
                    </v-tooltip>
                  </template>
                </v-data-table>
                <div class="text-center pt-2">
                  <v-pagination
                    v-model="page1"
                    :total-visible="7"
                    :length="tableRoles.last_page"
                    color="red darken-2"
                  ></v-pagination>
                </div>
              </v-container>
            </v-container>
          </v-tab-item>

          <v-tab-item class="d-none">
            <!-- Permissions List -->
            <v-container class="py-0">
              <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
                <v-card-actions class="px-0">
                  <v-btn
                    color="primary"
                    style="text-transform: none"
                    depressed
                    :small="$vuetify.breakpoint.smAndDown"
                    dark
                    @click="dialogPermissions = true"
                  >
                    Add New
                  </v-btn>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="success"
                    style="text-transform: none"
                    depressed
                    :small="$vuetify.breakpoint.smAndDown"
                    dark
                    @click="getPermissions"
                    >Refresh</v-btn
                  >
                </v-card-actions>

                <!-- Permissions List Table -->
                <v-data-table
                  id="table"
                  :items-per-page="5"
                  :loading="progressBar"
                  hide-default-footer
                  :headers="headersPermissions"
                  :items="tablePermissions.data"
                >
                  <v-progress-linear
                    v-show="progressBar"
                    slot="progress"
                    color="red darken-2"
                    class="px-0 mx-0"
                    indeterminate
                    rounded
                  ></v-progress-linear>

                  <template v-slot:[`item.id`]="{ item }">
                    <v-btn
                      icon
                      color="red darken-2"
                      @click="editItemPermissions(item)"
                      :x-small="$vuetify.breakpoint.smAndDown"
                    >
                      <v-icon> mdi-pencil </v-icon>
                    </v-btn>
                  </template>
                </v-data-table>

                <div class="text-center pt-2">
                  <v-pagination
                    v-model="page4"
                    :total-visible="7"
                    :length="tablePermissions.last_page"
                    color="red darken-2"
                  ></v-pagination>
                </div>
              </v-container>
            </v-container>
          </v-tab-item>

          <v-tab-item>
            <!-- User Roles -->
            <v-container class="py-0">
              <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
                <v-card-actions class="px-0">
                  <v-spacer></v-spacer>
                  <v-btn
                    color="success"
                    style="text-transform: none"
                    depressed
                    :small="$vuetify.breakpoint.smAndDown"
                    dark
                    @click="getUserRoles"
                    >Refresh</v-btn
                  >
                </v-card-actions>

                <!-- User Roles Table -->
                <v-data-table
                  id="table"
                  :items-per-page="5"
                  hide-default-footer
                  :loading="progressBar"
                  :headers="headersUserrole"
                  :items="tableUserrole.data"
                >
                  <v-progress-linear
                    v-show="progressBar"
                    slot="progress"
                    color="red darken-2"
                    class="px-0 mx-0"
                    indeterminate
                    rounded
                  ></v-progress-linear>

                  <template v-slot:[`item.roles.name`]="{ item }">
                    <v-chip
                      small
                      class="ma-2"
                      v-for="(val, key) in item.roles"
                      :key="key"
                    >
                      {{ val.name }}</v-chip
                    >
                  </template>

                  <template v-slot:[`item.id`]="{ item }">
                    <v-tooltip bottom>
                      <template #activator="data">
                        <v-btn
                          icon
                          color="red darken-2"
                          @click="addUserRole(item)"
                          v-on="data.on"
                          :x-small="$vuetify.breakpoint.smAndDown"
                        >
                          <v-icon> mdi-plus </v-icon>
                        </v-btn>
                      </template>
                      <span>Add User Role</span>
                    </v-tooltip>
                  </template>
                </v-data-table>
                <div class="text-center pt-2">
                  <v-pagination
                    v-model="page2"
                    :total-visible="7"
                    :length="tableUserrole.last_page"
                    color="red darken-2"
                  ></v-pagination>
                </div>
              </v-container>
            </v-container>
          </v-tab-item>

          <!-- Dev-->
          <v-tab-item class="d-none">
            <v-card-text>
              <v-text-field
                class=""
                v-model="seederTablename"
                label="Table name"
              ></v-text-field>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" small depressed dark @click="getSeeder">
                  Extract
                </v-btn>
              </v-card-actions>
              <v-textarea
                outlined
                v-model="seederColumns"
                label="OUTPUT"
                row="10"
              ></v-textarea>
            </v-card-text>
          </v-tab-item>
        </v-tabs-items>
      </v-card>
    </v-form>
  </div>
</template>

<style>
.v-data-table__checkbox,
.v-input--selection-controls__input .mdi-checkbox-marked,
.v-input--selection-controls__input .mdi-minus-box {
  color: #d32f2f !important;
}
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
import axios from "axios";
export default {
  middleware: "auth",
  metaInfo() {
    return { title: "Settings" };
  },
  // declarations
  data: () => ({
    snackbar: {
      active: false,
      message: "",
    },
    snackbar2: {
      active: false,
      message: "",
    },
    seederColumns: "",
    seederTablename: "",
    currentdataRoles: {},
    tab: null,

    // Form Rules
    formRules: [
      (v) => (!!v && v.length >= 3) || "This is required",
      (v) =>
        /^(?:([A-Za-z])(?!\1{2})|([0-9])(?!\2{7})|([\s,'-_/])(?!\3{1}))+$/i.test(
          v
        ) || "This field must have a valid value",
    ],
    formRulesDesc: [
      (v) =>
        /^$|^(?:([A-Za-z])(?!\1{2})|([0-9])(?!\2{7})|([\s,'-_/.()])(?!\3{1}))+$/i.test(
          v
        ) || "This field must have a valid value",
    ],

    progressBar: false,
    editedIndex: -1,
    // --------------------------------------------------role
    dialogRoles: false,
    tableRoles: [],
    page1: 1,
    headersRoles: [
      {
        text: "ROLE NAME",
        align: "start",
        value: "name",
        class: "black--text",
      },
      { text: "ROLE DESCRIPTION", value: "description", class: "black--text" },
      {
        text: "ACTION(S)",
        value: "id",
        align: "center",
        sortable: false,
        class: "black--text",
      },
    ],
    role: { name: "", id: "" },

    // --------------------------------------------------permission
    dialogPermissions: false,
    searchPermissions: "",
    tablePermissions: [],
    page4: 1,
    headersPermissions: [
      {
        text: "PERMISSION NAME",
        align: "start",
        value: "name",
        class: "black--text",
      },
      { text: "DESCRIPTION", value: "description", class: "black--text" },
      { text: "ACTION(S)", value: "id", class: "black--text" },
    ],
    permission: { name: "", description: "", id: "" },
    // --------------------------------------------------user role
    searchUserrole: "",
    tableUserrole: [],
    page2: 1,
    headersUserrole: [
      {
        text: "USER",
        align: "start",
        value: "name",
        class: "black--text",
      },
      { text: "CURRENT ROLE(S)", value: "roles.name", class: "black--text" },
      {
        text: "ACTION(S)",
        value: "id",
        align: "center",
        sortable: false,
        class: "black--text",
      },
    ],

    // --------------------------------------------------set role permission
    dialogAddPermissions: false,
    selectedAddPermission: [],
    selectedAddPermission_cloned: [],
    headersAddPermissions: [
      {
        text: "PERMISSION",
        align: "start",
        value: "name",
        class: "black--text",
      },
      { text: "DESCRIPTION", value: "description", class: "black--text" },
    ],
    rolename: "",

    // --------------------------------------------------set user role
    dialogAddRoles: false,
    tableAddRoles: [],
    page3: 1,
    selectedAddRoles: [],
    selectedAddRoles_cloned: [],
    username: "",
    userid: "",
    headersAddRoles: [
      { text: "ROLE", align: "start", value: "name", class: "black--text" },
      { text: "DESCRIPTION", value: "description", class: "black--text" },
    ],
  }),

  // load
  created() {
    if (this.user.permissionslist.includes("Access Settings")) {
      this.getRoles();
      this.getPermissions();
      this.getRolePermissions();
    } else {
      this.$router.push({ name: "invalid-page" }).catch((errr) => {});
    }
  },

  // functions
  methods: {
    valueKeydown(e) {
      if (/[~`!@#$%^&()_={}[\]\\"*|:;.<>+\?]/.test(e.key)) {
        e.preventDefault();
      }
    },

    // Compare Roles
    compareRoles() {
      if (!this.currentdataRoles) {
        return true;
      }

      var found = 0;
      for (var key in this.role) {
        if (this.currentdataRoles[key] != this.role[key]) {
          found += 1;
        }
      }

      if (found > 0) {
        return true;
      } else {
        this.snackbar = {
          active: true,
          iconText: "alert-box",
          iconColor: "warning",
          message: "No changes has been made.",
        };
        this.close();
      }
    },

    async getSeeder() {
      const { data } = await axios.get("/api/seeder", {
        params: { id: this.seederTablename },
      });
      this.seederColumns = data;
    },

    validate(type) {
      switch (type) {
        case "roles":
          this.snackbar2 = {
            active: true,
            iconText: "comment-question-outline",
            iconColor: "warning",
            message: "Do you wish to continue?",
            type: "roles",
          };
          break;
        case "permission":
          this.snackbar2 = {
            active: true,
            iconText: "comment-question-outline",
            iconColor: "warning",
            message: "Do you want to add selected permission(s)?",
            type: "permission",
          };
          break;
        case "userrole":
          this.snackbar2 = {
            active: true,
            iconText: "comment-question-outline",
            iconColor: "warning",
            message: "Do you want to add selected user role(s)?",
            type: "userrole",
          };
          break;
        default:
          break;
      }
    },

    action(type) {
      switch (type) {
        case "roles":
          this.storeRoles();
          break;
        case "permission":
          this.storeAddPermissions();
          break;
        case "userrole":
          this.storeUserRole();
          break;
        default:
          break;
      }
      this.snackbar2.active = false;
    },

    // Get Roles
    async getRoles() {
      let self = this;
      self.progressBar = true;
      self.tableRoles = [];
      await axios
        .get("/api/useracc/getRoles", { params: { page: this.page1 } })
        .then((result) => {
          self.tableRoles = result.data.data;
          self.tableUserrole = result.data.data;
          self.progressBar = false;
        })
        .catch((result) => {});
    },

    // Save Roles
    async storeRoles() {
      if (this.$refs.mainForm.validate()) {
        if (this.compareRoles()) {
          await axios
            .post("/api/useracc/storeRole", this.role)
            .then((result) => {
              switch (result.data.type) {
                case 0:
                  if (this.editedIndex > -1) {
                    Object.assign(
                      this.tableRoles.data[this.editedIndex],
                      result.data.data
                    );
                  } else {
                    this.tableRoles.data.push(result.data.data);
                  }
                  this.snackbar = {
                    active: true,
                    iconText: "check",
                    iconColor: "success",
                    message: "Successfully saved.",
                  };
                  this.close();
                  break;
                case 1:
                  this.snackbar = {
                    active: true,
                    iconText: "alert",
                    iconColor: "error",
                    message: "The role name already exists.",
                  };
                default:
                  break;
              }
            })
            .catch((result) => {});
        }
      }
    },

    // Edit Roles
    editItemRoles(item) {
      this.currentdataRoles = JSON.parse(JSON.stringify(item));
      this.editedIndex = this.tableRoles.data.indexOf(item);
      this.role.name = item.name;
      this.role.description = item.description;
      this.role.id = item.id;
      this.dialogRoles = true;
    },

    // Open Dialog Form Roles
    openDialogRoles() {
      this.$refs.mainForm.resetValidation();
      this.dialogRoles = true;
    },

    // Reset Form Roles
    cancelRoles() {
      this.$refs.mainForm.resetValidation();
      this.dialogRoles = false;
    },

    // Permission
    async getPermissions() {
      let self = this;
      self.progressBar = true;
      self.tablePermissions = [];
      await axios
        .get("/api/useracc/getPermission")
        .then((result) => {
          self.tablePermissions = result.data.data;
          self.progressBar = false;
        })
        .catch((result) => {
          this.snackbar = {
            active: true,
            iconText: "alert",
            iconColor: "warning",
            message: "Error!",
          };
        });
    },

    // Save Roles
    async storePermissions() {
      await axios
        .post("/api/useracc/storePermission", this.permission)
        .then((result) => {
          if (this.editedIndex > -1) {
            Object.assign(
              this.tablePermissions.data[this.editedIndex],
              result.data
            );
          } else {
            this.tablePermissions.data.push(result.data);
          }
          this.snackbar = {
            active: true,
            iconText: "check",
            iconColor: "success",
            message: "Successfully saved.",
          };
        })
        .catch((result) => {});
      this.close();
    },

    // Edit
    editItemPermissions(item) {
      this.editedIndex = this.tablePermissions.data.indexOf(item);
      this.permission.name = item.name;
      this.permission.description = item.description;
      this.permission.id = item.id;
      this.dialogPermissions = true;
    },

    // User Role
    async getUserRoles() {
      let self = this;
      self.progressBar = true;
      self.tableUserrole = [];
      await axios
        .get("/api/useracc/getUserRole", { params: { page: this.page2 } })
        .then((result) => {
          self.tableUserrole = result.data;
          self.progressBar = false;
        })
        .catch((result) => {});
    },

    // Add Role Permission
    async getRolePermissions(item) {
      let self = this;
      self.progressBar = true;
      self.tablePermissions = [];
      await axios
        .get("/api/useracc/getPermission", {
          params: { role: item, page: this.page4 },
        })
        .then((result) => {
          self.tablePermissions = result.data.all;
          self.selectedAddPermission = result.data.selected;
          self.selectedAddPermission_cloned = result.data.selected;

          self.progressBar = false;
        })
        .catch((result) => {});
    },

    addPermission(item) {
      this.dialogAddPermissions = true;
      this.rolename = item.name;
      this.getRolePermissions(item.name);
    },

    checkRolesIsValid() {
      // if mag add ng restriction bukod dito,
      // console this.selectedAddPermission tignan and index then get name, then gawa ka if else mo ung message
      // lagyan mo ng return sa loob. basta mag greater than one ndi yan prproceed.
      if (
        this.selectedAddPermission[0].name == "Access POS" &&
        this.selectedAddPermission[1].name == "Access Dashboard"
      ) {
        this.snackbar = {
          active: true,
          iconText: "error",
          iconColor: "danger",
          message:
            "If Access POS is checked, you must Disabled all other permissions.",
        };
        return 1;
      }
    },

    comparePermission() {
      // Check if not existed
      // Check each value if the same or not
      var found = 0;
      if (
        this.selectedAddPermission_cloned.length ===
        this.selectedAddPermission.length
      ) {
        for (var key in this.selectedAddPermission_cloned.length >
        this.selectedAddPermission.length
          ? this.selectedAddPermission_cloned.length
          : this.selectedAddRoles.length) {
          try {
            if (
              this.selectedAddPermission[key].id !=
              this.selectedAddPermission_cloned[key].id
            ) {
              found += 1;
            }
          } catch (error) {
            found += 1;
          }
        }
      } else {
        found += 1;
      }

      //if has changes
      if (found > 0) {
        return true;
      } else {
        this.snackbar = {
          active: true,
          iconText: "alert-box",
          iconColor: "warning",
          message: "No changes has been made.",
        };
        return false;
      }
    },

    // Save Role Permission
    async storeAddPermissions() {
      if (this.checkRolesIsValid() > 0) {
        return;
      }

      if (this.comparePermission()) {
        await axios
          .post("/api/useracc/storeRolePermission", {
            selected: this.selectedAddPermission,
            role: this.rolename,
          })
          .then((result) => {
            this.snackbar = {
              active: true,
              iconText: "check",
              iconColor: "success",
              message: "Successfully saved.",
            };
            this.getUserRoles();
          })
          .catch((result) => {});
        this.close();
      }
    },

    compareUserRoles() {
      var found = 0;
      if (
        this.selectedAddRoles_cloned.length === this.selectedAddRoles.length
      ) {
        for (var key in this.selectedAddRoles_cloned.length >
        this.selectedAddRoles.length
          ? this.selectedAddRoles_cloned.length
          : this.selectedAddRoles.length) {
          try {
            if (
              this.selectedAddRoles[key].id !=
              this.selectedAddRoles_cloned[key].id
            ) {
              found += 1;
            }
          } catch (error) {
            found += 1;
          }
        }
      } else {
        found += 1;
      }

      //if has changes
      if (found > 0) {
        return true;
      } else {
        this.snackbar = {
          active: true,
          iconText: "alert-box",
          iconColor: "warning",
          message: "No changes has been made.",
        };
        return false;
      }
    },
    // Set User Role
    // Get Roles
    async getAddUserRoles(item) {
      let self = this;
      self.progressBar = true;
      self.tableAddRoles = [];
      await axios
        .get("/api/useracc/getRoles", { params: { user: item } })
        .then((result) => {
          self.tableAddRoles = result.data.data;
          self.selectedAddRoles = result.data.selected;
          self.selectedAddRoles_cloned = result.data.selected;
          self.progressBar = false;
        })
        .catch((result) => {});
    },

    // Edit User Roles
    addUserRole(item) {
      this.dialogAddRoles = true;
      this.userid = item.id;
      this.username = item.name;
      this.getAddUserRoles(item.id);
    },

    // Save User Roles
    async storeUserRole() {
      if (this.compareUserRoles()) {
        await axios
          .post("/api/useracc/storeUserRole", {
            selected: this.selectedAddRoles,
            user: this.userid,
          })
          .then((result) => {
            this.getUserRoles();
            this.snackbar = {
              active: true,
              iconText: "check",
              iconColor: "success",
              message: "Successfully saved.",
            };
          })
          .catch((result) => {});

        this.close();
      }
    },

    // Reset Form User Roles
    cancelUserRoles() {
      this.$refs.mainForm.resetValidation();
      this.dialogAddRoles = false;
    },

    // close
    close() {
      this.dialogRoles = false;
      this.dialogPermissions = false;
      this.dialogAddPermissions = false;
      this.dialogAddRoles = false;
      (this.editedIndex = -1),
        this.$nextTick(() => {
          this.role = { name: "", id: "" };
          this.permission = { name: "", id: "" };
        });
    },

    async remove() {
      await axios.post("/api/useracc/removeUserRole").then((result) => {
        this.snackbar = {
          active: true,
          iconText: "check",
          iconColor: "success",
          message: "Successfully saved.",
        };
      });
    },
  },

  // New Update Title
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
    formTitle() {
      return this.editedIndex === -1 ? "ADD NEW " : "UPDATE ";
    },

    height() {
      switch (this.$vuetify.breakpoint.name) {
        case "xs":
          return 35;
        default:
          return 42;
      }
    },
  },

  // On Changes
  watch: {
    dialogRoles(val) {
      val || this.close();
    },
    page1(val) {
      this.page1 = val;
      this.getRoles();
    },
    page4(val) {
      this.page4 = val;
      this.getRolePermissions();
    },
    page3(val) {
      this.page3 = val;
      this.getRoles();
    },
    page2(val) {
      this.page2 = val;
      this.getUserRoles();
    },
    dialogPermissions(val) {
      val || this.close();
    },
    dialogAddRoles(val) {
      val || this.close();
    },
  },
};
</script>
