<template>
  <div>
    <v-form ref="mainForm" id="mainForm">
      <!---------------------------------------------------------------------- dialog ng role  -->
      <v-dialog v-model="dialogRoles" max-width="500px">
        <v-card id="dialog" class="bgcolor">
          <v-card-text class="p-2">
            <v-card-actions>
              <h4 class="text-danger">Add New Role</h4>
              <v-spacer></v-spacer>
              <v-icon
                class="float-right border bg-danger text-white"
                text
                @click="dialogRoles = false"
                >mdi-close
              </v-icon>
            </v-card-actions>
          </v-card-text>
          <v-card-text class="bgcolor">
            <v-card>
              <v-container style="background-color: #f2f3f0">
                <v-row>
                  <v-col class="py-1" cols="12" xl="12" lg="12" sm="12" md="4">
                    <v-text-field v-model="role.id" label="" class="d-none">
                    </v-text-field>
                    <v-text-field v-model="role.name" label="">
                      <template slot="label">
                        <div style="font-size: 14px; color: red">
                          Role Name *
                        </div>
                      </template>
                    </v-text-field>
                    <v-text-field v-model="role.description" label="">
                      <template slot="label">
                        <div style="font-size: 14px">Role Description</div>
                      </template>
                    </v-text-field>
                  </v-col>
                </v-row>
                <v-divider class="m-0" />
              </v-container>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="#00794b"
                  style="text-transform: none"
                  depressed
                  dark
                  @click="storeRolesConfirmation"
                >
                  Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-card-text>
        </v-card>
      </v-dialog>
      <!---------------------------------------------------------------------- dialog ng permission  -->
      <v-dialog v-model="dialogPermissions" max-width="500px">
        <v-card id="dialog" class="bgcolor">
          <v-card-text class="p-2">
            <v-card-actions>
              <h4 class="text-danger">Add New Permission</h4>
              <v-spacer></v-spacer>
              <v-icon
                class="float-right border bg-danger text-white"
                text
                @click="dialogPermissions = false"
                >mdi-close
              </v-icon>
            </v-card-actions>
          </v-card-text>
          <v-card-text class="bgcolor">
            <v-card>
              <v-container style="background-color: #f2f3f0">
                <v-row>
                  <v-col class="py-1" cols="12" xl="12" lg="12" sm="12" md="4">
                    <v-text-field
                      v-model="permission.id"
                      label=""
                      class="d-none"
                    >
                    </v-text-field>
                    <v-text-field v-model="permission.name" label="">
                      <template slot="label">
                        <div style="font-size: 14px; color: red">
                          Permission Name *
                        </div>
                      </template>
                    </v-text-field>
                    <v-text-field v-model="permission.description" label="">
                      <template slot="label">
                        <div style="font-size: 14px">
                          Permission Description
                        </div>
                      </template>
                    </v-text-field>
                  </v-col>
                </v-row>
                <v-divider class="m-0" />
              </v-container>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="#00794b"
                  style="text-transform: none"
                  depressed
                  dark
                  @click="storePermissionsConfirmation"
                >
                  Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-card-text>
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
                  color="green"
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
                  color="green"
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

      <!---------------------------------------------------------------------- tables tig isa.
      pinag hiwalay ko pati dialog para hindi kayo malito.  -->

      <div class="py-4">
        <v-expansion-panels popout>
          <!-------------------------------role -->
          <v-expansion-panel>
            <v-expansion-panel-header
              class="border-bottom text-success"
              @click="getRoles"
              >Roles list</v-expansion-panel-header
            >
            <v-expansion-panel-content>
              <v-card-actions class="bgcolor">
                <v-spacer></v-spacer>
                <v-btn
                  color="#00794b"
                  depressed
                  style="text-transform: none"
                  dark
                  small
                  @click="dialogRoles = true"
                >
                  Add New
                </v-btn>
                <v-btn
                  color="#00794b"
                  style="text-transform: none"
                  depressed
                  small
                  dark
                  @click="getRoles"
                  >Refresh</v-btn
                >
              </v-card-actions>

              <v-data-table
                id="table"
                dense
                class="px-4"
                :items-per-page="5"
                :loading="progressBar"
                :headers="headersRoles"
                :items="tableRoles"
              >
                <v-progress-linear
                  v-show="progressBar"
                  slot="progress"
                  color="green"
                  indeterminate
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
            </v-expansion-panel-content>
          </v-expansion-panel>
          <!-------------------------------permission -->
          <v-expansion-panel  >
            <v-expansion-panel-header
              class="border-bottom text-success"
              @click="getPermissions"
              >Permission list</v-expansion-panel-header
            >
            <v-expansion-panel-content>
              <v-card-actions class="bgcolor">
                <v-spacer></v-spacer>
                <v-btn
                  color="#00794b"
                  depressed
                  style="text-transform: none"
                  dark
                  small
                  @click="dialogPermissions = true"
                >
                  Add New
                </v-btn>
                <v-btn
                  color="#00794b"
                  style="text-transform: none"
                  depressed
                  small
                  dark
                  @click="getPermissions"
                  >Refresh</v-btn
                >
              </v-card-actions>

              <v-data-table
                id="table"
                dense
                class="px-4"
                :items-per-page="5"
                :loading="progressBar"
                :headers="headersPermissions"
                :items="tablePermissions"
              >
                <v-progress-linear
                  v-show="progressBar"
                  slot="progress"
                  color="green"
                  indeterminate
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
            </v-expansion-panel-content>
          </v-expansion-panel>
          <!-------------------------------set user role -->
          <v-expansion-panel>
            <v-expansion-panel-header
              class="border-bottom text-success"
              @click="getUserRoles"
              >User role
            </v-expansion-panel-header>
            <v-expansion-panel-content>
              <v-card-actions class="bgcolor">
                <v-spacer></v-spacer>
                <v-btn
                  color="#00794b"
                  style="text-transform: none"
                  depressed
                  small
                  dark
                  @click="getUserRoles"
                  >Refresh</v-btn
                >
              </v-card-actions>

              <v-data-table
                id="table"
                dense
                class="px-4"
                :items-per-page="5"
                :loading="progressBar"
                :headers="headersUserrole"
                :items="tableUserrole"
              >
                <v-progress-linear
                  v-show="progressBar"
                  slot="progress"
                  color="green"
                  indeterminate
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
            </v-expansion-panel-content>
          </v-expansion-panel>
        </v-expansion-panels>
      </div>
    </v-form>
  </div>
</template>

<style scoped>
.bgcolor {
  background-color: #dadcdc;
}
#mainForm .v-expansion-panel-header {
  min-height: 38px !important;
  height: 5px;
}
#mainForm .v-text-field__details {
  display: none;
}

#mainForm .v-expansion-panel--active > .v-expansion-panel-header {
  min-height: 64px !important;
  height: 5px;
}
@media only screen and (max-width: 600px) {
  #mainForm .v-expansion-panels--popout,
  .v-form {
    padding: 0px !important;
  }
}
@media only screen and (max-width: 800px) {
}
</style> 
  
<script> 
import axios from "axios";  
export default {
  // declarations
  data: () => ({
    formRules: [(v) => !!v || "This is required"],
    progressBar: true,
    editedIndex: -1,
    // --------------------------------------------------role
    dialogRoles: false,
    tableRoles: [],
    headersRoles: [
      { class: "border", text: "Role name", align: "start", value: "name" },
      { class: "border", text: "Role description", value: "description" },
      { class: "border", text: "Action", value: "id" },
    ],
    role: { name: "", id: "" },

    // --------------------------------------------------permission
    dialogPermissions: false,
    searchPermissions: "",
    tablePermissions: [],
    headersPermissions: [
      {
        class: "border",
        text: "Permission name",
        align: "start",
        value: "name",
      },
      { class: "border", text: "Description", value: "description" },
      { class: "border", text: "Action", value: "id" },
    ],
    permission: { name: "", description: "", id: "" },
    // --------------------------------------------------user role
    searchUserrole: "",
    tableUserrole: [],
    headersUserrole: [
      {
        class: "border",
        text: "Employee",
        align: "start",
        value: "employee.fullname",
      },
      { class: "border", text: "Current Role/s", value: "roles.name" },
      { class: "border", text: "Action", value: "id" },
    ],

    // --------------------------------------------------set role permission
    dialogAddPermissions: false,
    selectedAddPermission: [],
    headersAddPermissions: [
      { class: "border", text: "Permission", align: "start", value: "name" },
      { class: "border", text: "Description", value: "description" },
    ],
    rolename: "",

    // --------------------------------------------------set user role
    dialogAddRoles: false,
    tableAddRoles: [],
    selectedAddRoles: [],
    username: "",
    userid: "",
    headersAddRoles: [
      { class: "border", text: "Role", align: "start", value: "name" },
      { class: "border", text: "Description", value: "description" },
    ],
  }),

  // load
  created() {},

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
          Swal.fire({
            type: "warning",
            title: "Error handle,Please contact Digitech in this issue!",
            html: "Error Code: GRL-0",
          });
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
          Swal.fire({
            type: "success",
            title: "Successfully Saved!",
            html: "",
          });
        })
        .catch((result) => {
          Swal.fire({
            type: "warning",
            title: "Error handle,Please contact Digitech in this issue!",
            html: "Error Code: GRL-1",
          });
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
          Swal.fire({
            type: "warning",
            title: "Error handle,Please contact Digitech in this issue!",
            html: "Error Code: GRL-3",
          });
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
          Swal.fire({
            type: "success",
            title: "Successfully Saved!",
            html: "",
          });
        })
        .catch((result) => {
          Swal.fire({
            type: "warning",
            title: "Error handle,Please contact Digitech in this issue!",
            html: "Error Code: GRL-4",
          });
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
          Swal.fire({
            type: "warning",
            title: "Error handle,Please contact Digitech in this issue!",
            html: "Error Code: GRL-0",
          });
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
          Swal.fire({
            type: "warning",
            title: "Error handle,Please contact Digitech in this issue!",
            html: "Error Code: GRL-3",
          });
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
          console.log(result.data);
          Swal.fire({
            type: "success",
            title: "Successfully!",
            html: "",
          });
          this.getRoles();
        })
        .catch((result) => {
          Swal.fire({
            type: "warning",
            title: "Error handle,Please contact Digitech in this issue!",
            html: "Error Code: GRL-4",
          });
        });
      this.close();
    },

    // set user role
    // get roles
    async getAddUserRoles(item) {
      console.log(item)
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
          Swal.fire({
            type: "warning",
            title: "Error handle,Please contact Digitech in this issue!",
            html: "Error Code: GRL-3-1",
          });
        });
    },
    addUserRole(item) {
      console.log(item)
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
          Swal.fire({
            type: "success",
            title: "Successfully Saved!",
            html: "",
          });
          this.getRoles();
        })
        .catch((result) => {
          Swal.fire({
            type: "warning",
            title: "Error handle,Please contact Digitech in this issue!",
            html: "Error Code: GRL-4",
          });
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
        Swal.fire({
          type: "success",
          title: " Successfully Removed!",
          html: "",
        });
      });
    },
  },
  //new of update title
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "ADD NEW " : "UPDATE ";
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
