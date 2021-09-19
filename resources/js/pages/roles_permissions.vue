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
                @click="dialogRoles = false"
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
                  >
                    <template slot="label">
                      <div style="font-size: 14px">Role Name *</div>
                    </template>
                  </v-text-field>
                </v-col>
                <v-col class="py-0" cols="12" xl="12" lg="12" sm="12" md="12">
                  <v-text-field
                    v-model="role.description"
                    outlined
                    clearable
                    dense
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
              color="primary"
              depressed
              dark
              @click="storeRolesConfirmation"
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
              @click="storePermissionsConfirmation"
              style="text-transform: none"
              :small="$vuetify.breakpoint.smAndDown"
            >
              Save
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!---------------------------------------------------------------------- add permission to role -->
      <v-dialog v-model="dialogAddPermissions" max-width="900px">
        <v-card id="dialog" class="bgcolor">
          <v-card-text class="p-2">
            <v-card-actions>
              <h4 class="text-danger">Add Role Permission/s</h4>
              <v-spacer></v-spacer>
              <v-icon
                class="float-right border bg-danger text-white"
                text
                @click="dialogAddPermissions = false"
                >mdi-close
              </v-icon>
            </v-card-actions>
          </v-card-text>
          <v-card-text class="bgcolor">
            <v-card>
              <v-data-table
                dense
                class="px-4"
                v-model="selectedAddPermission"
                :items-per-page="5"
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

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="#00794b"
                  style="text-transform: none"
                  depressed
                  dark
                  @click="storeAddPermissionsConfirmation"
                >
                  Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-card-text>
        </v-card>
      </v-dialog>

      <!---------------------------------------------------------------------- add user to role -->
      <v-dialog v-model="dialogAddRoles" max-width="900px">
        <v-card id="dialog" class="bgcolor">
          <v-card-text class="p-2">
            <v-card-actions>
              <h4 class="text-danger">Add user roles</h4>
              <v-spacer></v-spacer>
              <v-icon
                class="float-right border bg-danger text-white"
                text
                @click="dialogAddRoles = false"
                >mdi-close
              </v-icon>
            </v-card-actions>
          </v-card-text>
          <v-card-text class="bgcolor">
            <v-card>
              <v-card-text>
                <strong class="text-danger">
                  Selected employee : {{ username }}</strong
                ></v-card-text
              >
              <v-data-table
                dense
                class="px-4"
                v-model="selectedAddRoles"
                :items-per-page="5"
                :loading="progressBar"
                :headers="headersAddRoles"
                :items="tableAddRoles"
                show-select
              >
                <v-progress-linear
                  v-show="progressBar"
                  slot="progress"
                  color="red darken-2"
                  indeterminate
                ></v-progress-linear>
              </v-data-table>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="#00794b"
                  style="text-transform: none"
                  depressed
                  dark
                  @click="storeUserRoleConfirmation"
                >
                  Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-card-text>
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
          <v-tabs-slider style="border-radius: 5px 5px 0 0"></v-tabs-slider>
          <v-tab
            :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
            style="text-transform: none"
            @click="getRoles"
          >
            Roles List
          </v-tab>
          <v-tab
            :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
            style="text-transform: none"
            @click="getPermissions"
          >
            Permissions List
          </v-tab>
          <v-tab
            :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
            style="text-transform: none"
            @click="getUserRoles"
          >
            User Roles
          </v-tab>
        </v-tabs>

        <v-tabs-items v-model="tab">
          <v-tab-item>
            <!-- Roles List -->
            <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
              <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
                <v-card-actions class="px-0">
                  <!-- Buttons -->
                  <v-btn
                    color="primary"
                    style="text-transform: none"
                    depressed
                    dark
                    :small="$vuetify.breakpoint.smAndDown"
                    @click="dialogRoles = true"
                  >
                    Add New
                  </v-btn>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="primary"
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
                  id="table"
                  :items-per-page="5"
                  :loading="progressBar"
                  :headers="headersRoles"
                  :items="tableRoles"
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
                    <v-hover v-slot="{ hover }">
                      <v-btn
                        class="px-1"
                        :class="
                          hover
                            ? 'btn btn-primary text-white'
                            : 'btn btn-link text-primary'
                        "
                        text
                        small
                        @click="editItemRoles(item)"
                      >
                        <v-icon> mdi-pencil </v-icon>
                        <small> - Edit </small>
                      </v-btn>
                    </v-hover>

                    <v-hover v-slot="{ hover }">
                      <v-btn
                        class="px-1"
                        :class="
                          hover
                            ? 'btn btn-info text-white'
                            : 'btn btn-link text-info'
                        "
                        text
                        small
                        @click="addPermission(item)"
                      >
                        <v-icon> mdi-plus </v-icon>
                        <small> - add / edit Permission </small>
                      </v-btn>
                    </v-hover>
                  </template>
                </v-data-table>
              </v-container>
            </v-container>
          </v-tab-item>

          <v-tab-item>
            <!-- Permissions List -->
            <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
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
                    color="primary"
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
                  :headers="headersPermissions"
                  :items="tablePermissions"
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
                    <v-hover v-slot="{ hover }">
                      <v-btn
                        class="px-1"
                        :class="
                          hover
                            ? 'btn btn-primary text-white'
                            : 'btn btn-link text-primary'
                        "
                        text
                        small
                        @click="editItemPermissions(item)"
                      >
                        <v-icon> mdi-pencil </v-icon>
                        <small> - Edit </small>
                      </v-btn>
                    </v-hover>
                  </template>
                </v-data-table>
              </v-container>
            </v-container>
          </v-tab-item>

          <v-tab-item>
            <!-- User Roles -->
            <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
              <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
                <v-card-actions class="px-0">
                  <v-spacer></v-spacer>
                  <v-btn
                    color="primary"
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
                  :loading="progressBar"
                  :headers="headersUserrole"
                  :items="tableUserrole"
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
                    <v-hover v-slot="{ hover }">
                      <v-btn
                        class="px-1"
                        :class="
                          hover
                            ? 'btn btn-info text-white'
                            : 'btn btn-link text-info'
                        "
                        text
                        small
                        @click="addUserRole(item)"
                      >
                        <v-icon> mdi-plus </v-icon>
                        <small> - Add role </small>
                      </v-btn>
                    </v-hover>
                  </template>
                </v-data-table>
              </v-container>
            </v-container>
          </v-tab-item>
        </v-tabs-items>
      </v-card>
    </v-form>
  </div>
</template>
  
<script>
import axios from "axios";
export default {
  middleware: 'auth', 
  // declarations
  data: () => ({
    snackbar: {
      active: false,
      message: "",
    },
    tab: null,
    formRules: [(v) => !!v || "This is required"],
    progressBar: true,
    editedIndex: -1,
    // --------------------------------------------------role
    dialogRoles: false,
    tableRoles: [],
    headersRoles: [
      { text: "Role name", align: "start", value: "name" },
      { text: "Role description", value: "description" },
      { text: "Action", value: "id", sortable: false },
    ],
    role: { name: "", id: "" },

    // --------------------------------------------------permission
    dialogPermissions: false,
    searchPermissions: "",
    tablePermissions: [],
    headersPermissions: [
      {
        text: "Permission name",
        align: "start",
        value: "name",
      },
      { text: "Description", value: "description" },
      { text: "Action", value: "id" },
    ],
    permission: { name: "", description: "", id: "" },
    // --------------------------------------------------user role
    searchUserrole: "",
    tableUserrole: [],
    headersUserrole: [
      {
        text: "Employee",
        align: "start",
        value: "employee.fullname",
      },
      { text: "Current Role/s", value: "roles.name" },
      { text: "Action", value: "id" },
    ],

    // --------------------------------------------------set role permission
    dialogAddPermissions: false,
    selectedAddPermission: [],
    headersAddPermissions: [
      { text: "Permission", align: "start", value: "name" },
      { text: "Description", value: "description" },
    ],
    rolename: "",

    // --------------------------------------------------set user role
    dialogAddRoles: false,
    tableAddRoles: [],
    selectedAddRoles: [],
    username: "",
    userid: "",
    headersAddRoles: [
      { text: "Role", align: "start", value: "name" },
      { text: "Description", value: "description" },
    ],
  }),

  // load
  created() {
    this.getRoles();
    this.getPermissions();
    this.getUserRoles();
  },

  // functions
  methods: {
    // role
    // get roles
    async getRoles() {
      let self = this;
      self.progressBar = true;
      self.tableRoles = [];
      await axios
        .get("/api/settings/roles/list")
        .then((result) => {
          self.tableRoles = result.data.data;
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
    // store validation
    storeRolesConfirmation() {
      Swal.fire({
        title: "Are you want to save this changes?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#00794b",
        cancelButtonColor: "#CC0022",
        confirmButtonText: "Confirm",
      }).then((result) => {
        if (result.value) {
          this.storeRoles();
        }
      });
    },
    // save roles
    async storeRoles() {
      await axios
        .post("/api/settings/roles/store", this.role)
        .then((result) => {
          if (this.editedIndex > -1) {
            Object.assign(this.tableRoles[this.editedIndex], result.data);
          } else {
            this.tableRoles.push(result.data);
          }
          this.snackbar = {
            active: true,
            iconText: "check",
            iconColor: "success",
            message: "Successfully saved.",
          };
        })
        .catch((result) => {
          this.snackbar = {
            active: true,
            iconText: "alert",
            iconColor: "warning",
            message: "Error!",
          };
        });
      this.close();
    },
    // edit
    editItemRoles(item) {
      this.editedIndex = this.tableRoles.indexOf(item);
      this.role.name = item.name;
      this.role.description = item.description;
      this.role.id = item.id;
      this.dialogRoles = true;
    },

    // permission
    async getPermissions() {
      let self = this;
      self.progressBar = true;
      self.tablePermissions = [];
      await axios
        .get("/api/settings/permissions/list")
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
    // store validation
    storePermissionsConfirmation() {
      Swal.fire({
        title: "Are you want to save this changes?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#00794b",
        cancelButtonColor: "#CC0022",
        confirmButtonText: "Confirm",
      }).then((result) => {
        if (result.value) {
          this.storePermissions();
        }
      });
    },
    // save roles
    async storePermissions() {
      await axios
        .post("/api/settings/permissions/store", this.permission)
        .then((result) => {
          if (this.editedIndex > -1) {
            Object.assign(this.tablePermissions[this.editedIndex], result.data);
          } else {
            this.tablePermissions.push(result.data);
          }
          this.snackbar = {
            active: true,
            iconText: "check",
            iconColor: "success",
            message: "Successfully saved.",
          };
        })
        .catch((result) => {
          this.snackbar = {
            active: true,
            iconText: "alert",
            iconColor: "warning",
            message: "Error!",
          };
        });
      this.close();
    },
    // edit
    editItemPermissions(item) {
      this.editedIndex = this.tablePermissions.indexOf(item);
      this.permission.name = item.name;
      this.permission.description = item.description;
      this.permission.id = item.id;
      this.dialogPermissions = true;
    },
    // user role
    async getUserRoles() {
      let self = this;
      self.progressBar = true;
      self.tableUserrole = [];
      await axios
        .get("/api/settings/user/role/list")
        .then((result) => {
          self.tableUserrole = result.data;
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

    // add role permission
    async getRolePermissions(item) {
      let self = this;
      self.progressBar = true;
      self.tablePermissions = [];
      await axios
        .get("/api/settings/permissions/list", { params: { role: item } })
        .then((result) => {
          console.log(result.data);
          self.tablePermissions = result.data.data;
          self.selectedAddPermission = result.data.selected;
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
    addPermission(item) {
      this.dialogAddPermissions = true;
      this.rolename = item.name;
      this.getRolePermissions(item.name);
    },
    // store validation
    storeAddPermissionsConfirmation() {
      Swal.fire({
        title: "Add all selected permission?",
        html: "This permission/s will apply to all users with the same roles, Permission/s will apply after refreshing the page.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#00794b",
        cancelButtonColor: "#CC0022",
        confirmButtonText: "Confirm",
      }).then((result) => {
        if (result.value) {
          this.storeAddPermissions();
        }
      });
    },
    // save role permission
    async storeAddPermissions() {
      await axios
        .post("/api/settings/role/permission/store", {
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
          this.getRoles();
        })
        .catch((result) => {
          this.snackbar = {
            active: true,
            iconText: "alert",
            iconColor: "warning",
            message: "Error!",
          };
        });
      this.close();
    },

    // set user role
    // get roles
    async getAddUserRoles(item) {
      console.log(item);
      let self = this;
      self.progressBar = true;
      self.tableAddRoles = [];
      await axios
        .get("/api/settings/roles/list", { params: { user: item } })
        .then((result) => {
          console.log(result.data);
          self.tableAddRoles = result.data.data;
          self.selectedAddRoles = result.data.selected;
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
    addUserRole(item) {
      console.log(item);
      this.dialogAddRoles = true;
      this.userid = item.employee.id;
      this.username = item.employee.fullname;
      this.getAddUserRoles(item.employee.id);
    },
    // store validation
    storeUserRoleConfirmation() {
      Swal.fire({
        title: "Add all selected permission?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#00794b",
        cancelButtonColor: "#CC0022",
        confirmButtonText: "Confirm",
      }).then((result) => {
        if (result.value) {
          this.storeUserRole();
        }
      });
    },
    // save user roles
    async storeUserRole() {
      await axios
        .post("/api/settings/user/role/store", {
          selected: this.selectedAddRoles,
          user: this.userid,
        })
        .then((result) => {
          console.log(result.data);
          this.snackbar = {
            active: true,
            iconText: "check",
            iconColor: "success",
            message: "Successfully saved.",
          };
          this.getRoles();
        })
        .catch((result) => {
          this.snackbar = {
            active: true,
            iconText: "alert",
            iconColor: "warning",
            message: "Error!",
          };
        });
      this.close();
    },
    // close
    close() {
      this.dialogRoles = false;
      this.dialogPermissions = false;
      (this.editedIndex = -1),
        this.$nextTick(() => {
          this.role = { name: "", id: "" };
          this.permission = { name: "", id: "" };
        });
    },

    async remove() {
      await axios.post("/api/settings/roles/remove").then((result) => {
        console.log(result.data);
        this.snackbar = {
          active: true,
          iconText: "check",
          iconColor: "success",
          message: "Successfully saved.",
        };
      });
    },
  },
  //new of update title
  computed: {
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
  // on changes
  watch: {
    dialogRoles(val) {
      val || this.close();
    },
    dialogPermissions(val) {
      val || this.close();
    },
  },
};
</script>
