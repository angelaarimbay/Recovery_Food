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

    <!-- Role Dialog Form -->
    <v-form ref="mainForm" id="mainForm">
      <v-dialog
        v-model="dialogRoles"
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
              >Role</span
            >
            <v-spacer></v-spacer>
            <v-icon
              :small="$vuetify.breakpoint.xsOnly"
              text
              @click="cancelRoles"
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
                <!-- ID -->
                <v-text-field v-model="role.id" class="d-none"> </v-text-field>
                <!-- Role Name -->
                <v-text-field
                  :rules="formRules"
                  v-model="role.name"
                  clearable
                  dense
                  counter
                  @keydown="valueKeydown($event)"
                  maxlength="20"
                  background-color="white"
                  flat
                  solo
                  style="font-size: 12px"
                >
                  <template slot="label">
                    <div style="font-size: 12px">
                      Role Name <span style="color: red">*</span>
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
                <!-- Role Description -->
                <v-text-field
                  :rules="formRulesDesc"
                  v-model="role.description"
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
                    <div style="font-size: 12px">Role Description</div>
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
                    @click="cancelRoles"
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
                    @click="storeRoles"
                    :small="$vuetify.breakpoint.smAndDown"
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
                dark
                @click="cancelRoles"
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
                @click="storeRoles"
                :small="$vuetify.breakpoint.smAndDown"
              >
                Save
              </v-btn>
            </template>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-form>

    <v-form ref="mainForm1" id="mainForm1">
      <!-- Permission Dialog Form -->
      <v-dialog
        v-model="dialogPermissions"
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
              >Permission</span
            >
            <v-spacer></v-spacer>
            <v-icon
              :small="$vuetify.breakpoint.xsOnly"
              text
              @click="cancelPermissions"
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
                <!-- ID -->
                <v-text-field v-model="permission.id" class="d-none">
                </v-text-field>
                <!-- Permission Name -->
                <v-text-field
                  :rules="formRules"
                  v-model="permission.name"
                  clearable
                  background-color="white"
                  flat
                  solo
                  dense
                  style="font-size: 12px"
                >
                  <template slot="label">
                    <div style="font-size: 12px">
                      Permission Name <span style="color: red">*</span>
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
                <!-- Permission Description -->
                <v-text-field
                  :rules="formRules"
                  v-model="permission.description"
                  clearable
                  background-color="white"
                  flat
                  solo
                  dense
                  style="font-size: 12px"
                >
                  <template slot="label">
                    <div style="font-size: 12px">Permission Description</div>
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
                    @click="cancelPermissions"
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
                    @click="storePermissions"
                    :small="$vuetify.breakpoint.smAndDown"
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
                dark
                @click="cancelPermissions"
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
                @click="storePermissions"
                :small="$vuetify.breakpoint.smAndDown"
              >
                Save
              </v-btn>
            </template>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-form>

    <v-form ref="mainForm2" id="mainForm2">
      <!-- Add Permission To Role Dialog -->
      <v-dialog v-model="dialogAddPermissions" max-width="900px" scrollable>
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
              >Add Role Permission(s)</span
            >
            <v-spacer></v-spacer>
            <v-icon
              :small="$vuetify.breakpoint.xsOnly"
              text
              @click="dialogAddPermissions = false"
              >mdi-close
            </v-icon>
          </v-toolbar>
          <v-card-text style="height: auto" class="px-4">
            <v-data-table
              id="table1"
              class="tbl px-4 mt-6 table-striped border"
              v-model="selectedAddPermission"
              :items-per-page="10"
              dense
              :loading="progressBar"
              :headers="headersAddPermissions"
              :items="tablePermission"
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
          <v-divider class="my-0"></v-divider>
          <!-- Dialog Form Buttons -->
          <v-card-actions class="pa-3">
            <template v-if="$vuetify.breakpoint.xsOnly">
              <v-btn
                style="text-transform: none"
                color="primary"
                depressed
                dark
                @click="validate('permission')"
                :small="$vuetify.breakpoint.smAndDown"
                block
              >
                Save
              </v-btn>
            </template>
            <template v-else>
              <v-spacer></v-spacer>
              <v-btn
                style="text-transform: none"
                color="primary"
                depressed
                dark
                @click="validate('permission')"
                :small="$vuetify.breakpoint.smAndDown"
              >
                Save
              </v-btn>
            </template>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-form>

    <v-form ref="mainForm3" id="mainForm3">
      <!-- Add User Role Dialog -->
      <v-dialog v-model="dialogAddRoles" max-width="900px" scrollable>
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
              >Add User Role(s)</span
            >
            <v-spacer></v-spacer>
            <v-icon
              :small="$vuetify.breakpoint.xsOnly"
              text
              @click="cancelUserRoles"
              >mdi-close
            </v-icon>
          </v-toolbar>
          <v-card-text style="height: auto" class="px-4">
            <v-card-text>
              Selected User: <strong>{{ username }}</strong>
            </v-card-text>
            <v-data-table
              id="table1"
              class="tbl px-4 table-striped border"
              v-model="selectedAddRoles"
              :items-per-page="10"
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
          </v-card-text>
          <v-divider class="my-0"></v-divider>
          <!-- Dialog Form Buttons -->
          <v-card-actions class="pa-3">
            <template v-if="$vuetify.breakpoint.xsOnly">
              <v-btn
                style="text-transform: none"
                color="primary"
                depressed
                dark
                @click="validate('userrole')"
                :small="$vuetify.breakpoint.smAndDown"
                block
              >
                Save
              </v-btn>
            </template>
            <template v-else>
              <v-spacer></v-spacer>
              <v-btn
                style="text-transform: none"
                color="primary"
                depressed
                dark
                @click="validate('userrole')"
                :small="$vuetify.breakpoint.smAndDown"
              >
                Save
              </v-btn>
            </template>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-form>

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
      <v-card elevation="1" class="mt-2" style="border-radius: 10px">
        <v-tabs
          slider-size="4"
          color="red darken-2"
          :centered="$vuetify.breakpoint.xsOnly"
          :height="height"
          :class="{ 'pt-2': $vuetify.breakpoint.smAndUp }"
        >
          <v-tabs-slider
            style="border-radius: 20px 20px 0px 0px"
          ></v-tabs-slider>
          <v-tab
            class="
              text-caption
              text-xl-subtitle-1
              text-lg-subtitle-1
              text-md-subtitle-2
              text-sm-body-1
            "
            style="text-transform: none"
            @click="getRoles"
          >
            Roles List
          </v-tab>
          <v-tab
            class="
              text-caption
              text-xl-subtitle-1
              text-lg-subtitle-1
              text-md-subtitle-2
              text-sm-body-1
              d-none
            "
            style="text-transform: none"
            @click="getPermissions"
          >
            Permissions List
          </v-tab>
          <v-tab
            class="
              text-caption
              text-xl-subtitle-1
              text-lg-subtitle-1
              text-md-subtitle-2
              text-sm-body-1
            "
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
              d-none
            "
            :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
            style="text-transform: none"
          >
            Dev
          </v-tab> -->

          <!-- Roles List -->
          <v-tab-item>
            <v-divider class="my-0"></v-divider>
            <v-container class="py-2 px-3">
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
                  Add New Role
                </v-btn>
                <v-spacer></v-spacer>
                <v-card color="red darken-3" flat style="border-radius: 20px">
                  <v-tooltip bottom>
                    <template #activator="data">
                      <v-btn
                        class="mx-4"
                        color="white"
                        depressed
                        :small="$vuetify.breakpoint.smAndDown"
                        dark
                        @click="getRoles"
                        v-on="data.on"
                        icon
                        ><v-icon size="20">mdi-refresh</v-icon></v-btn
                      >
                    </template>
                    <span>Refresh</span>
                  </v-tooltip>
                </v-card>
              </v-card-actions>

              <!-- Roles List Table -->
              <v-data-table
                hide-default-footer
                id="table"
                :items-per-page="10"
                :loading="progressBar"
                :headers="headersRoles"
                :items="tableRoles.data"
                class="table-striped border mt-2"
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

              <!-- Paginate -->
              <div
                class="
                  tbl
                  pbutton
                  text-center
                  pt-7
                  pb-xl-3 pb-lg-3 pb-md-3 pb-sm-2 pb-2
                "
              >
                <v-pagination
                  v-model="page1"
                  :total-visible="7"
                  :length="tableRoles.last_page"
                  color="red darken-2"
                ></v-pagination>
              </div>
            </v-container>
          </v-tab-item>

          <!-- Permissions List -->
          <v-tab-item class="d-none">
            <v-divider class="my-0"></v-divider>
            <v-container class="py-2 px-3">
              <v-card-actions class="px-0">
                <!-- Buttons -->
                <v-btn
                  color="primary"
                  style="text-transform: none"
                  depressed
                  dark
                  :small="$vuetify.breakpoint.smAndDown"
                  @click="openDialogPermissions"
                >
                  Add New Permission
                </v-btn>
                <v-spacer></v-spacer>
                <v-card color="red darken-3" flat style="border-radius: 20px">
                  <v-tooltip bottom>
                    <template #activator="data">
                      <v-btn
                        class="mx-4"
                        color="white"
                        depressed
                        :small="$vuetify.breakpoint.smAndDown"
                        dark
                        @click="getPermissions"
                        v-on="data.on"
                        icon
                        ><v-icon size="20">mdi-refresh</v-icon></v-btn
                      >
                    </template>
                    <span>Refresh</span>
                  </v-tooltip>
                </v-card>
              </v-card-actions>

              <!-- Permissions List Table -->
              <v-data-table
                hide-default-footer
                id="table"
                :items-per-page="10"
                :loading="progressBar"
                :headers="headersPermissions"
                :items="tablePermissions.data"
                class="table-striped border mt-2"
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
                        @click="editItemPermissions(item)"
                        v-on="data.on"
                        :x-small="$vuetify.breakpoint.smAndDown"
                      >
                        <v-icon> mdi-pencil </v-icon>
                      </v-btn>
                    </template>
                    <span>Edit Permission</span>
                  </v-tooltip>
                </template>
              </v-data-table>

              <!-- Paginate -->
              <div
                class="
                  tbl
                  pbutton
                  text-center
                  pt-7
                  pb-xl-3 pb-lg-3 pb-md-3 pb-sm-2 pb-2
                "
              >
                <v-pagination
                  v-model="page2"
                  :total-visible="7"
                  :length="tablePermissions.last_page"
                  color="red darken-2"
                ></v-pagination>
              </div>
            </v-container>
          </v-tab-item>

          <!-- User Roles List -->
          <v-tab-item>
            <v-divider class="my-0"></v-divider>
            <v-container class="py-2 px-3">
              <v-card-actions class="px-0">
                <v-spacer></v-spacer>
                <v-card color="red darken-3" flat style="border-radius: 20px">
                  <v-tooltip bottom>
                    <template #activator="data">
                      <v-btn
                        class="mx-4"
                        color="white"
                        depressed
                        :small="$vuetify.breakpoint.smAndDown"
                        dark
                        @click="getUserRoles"
                        v-on="data.on"
                        icon
                        ><v-icon size="20">mdi-refresh</v-icon></v-btn
                      >
                    </template>
                    <span>Refresh</span>
                  </v-tooltip>
                </v-card>
              </v-card-actions>

              <!-- User Roles Table -->
              <v-data-table
                id="table"
                :items-per-page="10"
                hide-default-footer
                :loading="progressBar"
                :headers="headersUserrole"
                :items="tableUserrole.data"
                class="table-striped border mt-2"
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

              <!-- Paginate -->
              <div
                class="
                  tbl
                  pbutton
                  text-center
                  pt-7
                  pb-xl-3 pb-lg-3 pb-md-3 pb-sm-2 pb-2
                "
              >
                <v-pagination
                  v-model="page3"
                  :total-visible="7"
                  :length="tableUserrole.last_page"
                  color="red darken-2"
                ></v-pagination>
              </div>
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
        </v-tabs>
      </v-card>
  </div>
</template>

<!-- Style -->
<style>
.v-input__control .v-icon.notranslate.v-icon--link.mdi.mdi-close {
  font-size: 16px;
}

@media (min-width: 1200px) {
  .container {
    max-width: 1500px !important;
  }
}

.tbl.v-data-table__checkbox,
.v-input--selection-controls__input .mdi-checkbox-marked,
.v-input--selection-controls__input .mdi-minus-box {
  color: #d32f2f !important;
}

#table1 .v-data-table-header th,
#table .v-data-table-header th {
  white-space: nowrap;
}
#table1 .v-data-table-header th,
#table .v-data-table-header th {
  font-size: 12px !important;
}
#table1 td,
#table td {
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
import axios from "axios";
export default {
  middleware: "auth",
  metaInfo() {
    return { title: "Settings" };
  },

  //Data
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
    currentdataPerms: {},

    //Form rules
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

    //For roles
    dialogRoles: false,
    tableRoles: [],
    page1: 1,
    headersRoles: [
      {
        text: "ROLE NAME",
        align: "start",
        value: "name",
        class: "black--text",
        width: "40%",
      },
      {
        text: "ROLE DESCRIPTION",
        value: "description",
        class: "black--text",
        width: "40%",
      },
      {
        text: "ACTION",
        value: "id",
        align: "center",
        sortable: false,
        class: "black--text",
        width: "20%",
      },
    ],
    role: { name: "", id: "" },

    //For permissions
    dialogPermissions: false,
    searchPermissions: "",
    tablePermissions: [],
    page2: 1,
    headersPermissions: [
      {
        text: "PERMISSION NAME",
        align: "start",
        value: "name",
        class: "black--text",
        width: "40%",
      },
      {
        text: "DESCRIPTION",
        value: "description",
        class: "black--text",
        width: "40%",
      },
      { text: "ACTION", value: "id", class: "black--text", width: "20%" },
    ],
    permission: { name: "", description: "", id: "" },

    //For user roles
    searchUserrole: "",
    tableUserrole: [],
    page3: 1,
    headersUserrole: [
      {
        text: "USER",
        align: "start",
        value: "name",
        class: "black--text",
        width: "40%",
      },
      {
        text: "CURRENT ROLE(S)",
        value: "roles.name",
        class: "black--text",
        width: "40%",
      },
      {
        text: "ACTION",
        value: "id",
        align: "center",
        sortable: false,
        class: "black--text",
        width: "20%",
      },
    ],

    //For setting role permissions
    dialogAddPermissions: false,
    selectedAddPermission: [],
    selectedAddPermission_cloned: [],
    headersAddPermissions: [
      {
        text: "PERMISSION",
        align: "start",
        value: "name",
        class: "black--text",
        width: "50%",
      },
      {
        text: "DESCRIPTION",
        value: "description",
        class: "black--text",
        width: "50%",
      },
    ],
    rolename: "",

    //For setting user roles
    dialogAddRoles: false,
    tableAddRoles: [],
    selectedAddRoles: [],
    selectedAddRoles_cloned: [],
    username: "",
    userid: "",
    headersAddRoles: [
      {
        text: "ROLE",
        align: "start",
        value: "name",
        class: "black--text",
        width: "50%",
      },
      {
        text: "DESCRIPTION",
        value: "description",
        class: "black--text",
        width: "50%",
      },
    ],
  }),

  //Onload
  created() {
    if (this.user.permissionslist.includes("Access Settings")) {
      this.getRoles();
      this.getPermissions();
      this.getRolePermissions();
    } else {
      this.$router.push({ name: "invalid-page" }).catch((errr) => {});
    }
  },

  //Methods
  methods: {
    valueKeydown(e) {
      if (/[~`!@#$%^&()_={}[\]\\"*|:;.<>+\?]/.test(e.key)) {
        e.preventDefault();
      }
    },

    //Compare Roles
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

    //Compare Permissions
    comparePerms() {
      if (!this.currentdataPerms) {
        return true;
      }

      var found = 0;
      for (var key in this.permission) {
        if (this.currentdataPerms[key] != this.permission[key]) {
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

    //For retrieving seeder
    async getSeeder() {
      const { data } = await axios.get("/api/seeder", {
        params: { id: this.seederTablename },
      });
      this.seederColumns = data;
    },

    //For validation
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

    //For action
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

    //Get Roles List
    async getRoles() {
      this.progressBar = true;
      await axios
        .get("/api/useracc/getRoles", { params: { page: this.page1 } })
        .then((result) => {
          this.tableRoles = result.data.data;
          this.tableUserrole = result.data.data;
          this.progressBar = false;
        })
        .catch((result) => {});
    },

    //Save Roles In List
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
                  this.getRoles();
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

    //Edit Roles
    editItemRoles(item) {
      this.currentdataRoles = JSON.parse(JSON.stringify(item));
      this.editedIndex = this.tableRoles.data.indexOf(item);
      this.role.name = item.name;
      this.role.description = item.description;
      this.role.id = item.id;
      this.dialogRoles = true;
    },

    //Open Dialog Form Roles
    openDialogRoles() {
      this.$refs.mainForm.resetValidation();
      this.dialogRoles = true;
    },

    //Reset Form Roles
    cancelRoles() {
      this.$refs.mainForm.resetValidation();
      this.dialogRoles = false;
    },

    //Get Permissions List
    async getPermissions() {
      this.progressBar = true;
      await axios
        .get("/api/useracc/getPermission", { params: { page: this.page2 } })
        .then((result) => {
          this.tablePermissions = result.data.data;
          this.progressBar = false;
        })
        .catch((result) => {});
    },

    //Save Permissions In List
    async storePermissions() {
      if (this.$refs.mainForm1.validate()) {
        if (this.comparePerms()) {
          await axios
            .post("/api/useracc/storePermission", this.permission)
            .then((result) => {
              switch (result.data.type) {
                case 0:
                  if (this.editedIndex > -1) {
                    Object.assign(
                      this.tablePermissions.data[this.editedIndex],
                      result.data.data
                    );
                  } else {
                    this.tablePermissions.data.push(result.data.data);
                  }
                  this.snackbar = {
                    active: true,
                    iconText: "check",
                    iconColor: "success",
                    message: "Successfully saved.",
                  };
                  this.getPermissions();
                  this.close();
                  break;
                case 1:
                  this.snackbar = {
                    active: true,
                    iconText: "alert",
                    iconColor: "error",
                    message: "The permission name already exists.",
                  };
                  break;
                default:
                  break;
              }
            })
            .catch((result) => {});
        }
      }
    },

    //Edit Permissions
    editItemPermissions(item) {
      this.currentdataPerms = JSON.parse(JSON.stringify(item));
      this.editedIndex = this.tablePermissions.data.indexOf(item);
      this.permission.name = item.name;
      this.permission.description = item.description;
      this.permission.id = item.id;
      this.dialogPermissions = true;
    },

    //Open Dialog Form Permissions
    openDialogPermissions() {
      this.$refs.mainForm1.resetValidation();
      this.dialogPermissions = true;
    },

    //Reset Form Permissions
    cancelPermissions() {
      this.$refs.mainForm1.resetValidation();
      this.dialogPermissions = false;
    },

    //User Role
    async getUserRoles() {
      this.progressBar = true;
      await axios
        .get("/api/useracc/getUserRole", { params: { page: this.page3 } })
        .then((result) => {
          this.tableUserrole = result.data;
          this.progressBar = false;
        })
        .catch((result) => {});
    },

    //Add Role Permission
    async getRolePermissions(item) {
      let self = this;
      self.tablePermission = [];
      await axios
        .get("/api/useracc/getPermission", {
          params: { role: item },
        })
        .then((result) => {
          self.tablePermission = result.data.all;
          self.selectedAddPermission = result.data.selected;
          self.selectedAddPermission_cloned = result.data.selected;
        })
        .catch((result) => {});
    },

    addPermission(item) {
      this.dialogAddPermissions = true;
      this.rolename = item.name;
      this.getRolePermissions(item.name);
    },

    // checkRolesIsValid() {
    //   // if mag add ng restriction bukod dito,
    //   // console this.selectedAddPermission tignan and index then get name, then gawa ka if else mo ung message
    //   // lagyan mo ng return sa loob. basta mag greater than one ndi yan prproceed.
    //   if (
    //     this.selectedAddPermission[0].name == "Access POS" &&
    //     this.selectedAddPermission[1].name == "Access Dashboard"
    //   ) {
    //     this.snackbar = {
    //       active: true,
    //       iconText: "close",
    //       iconColor: "danger",
    //       message: "Disable all other permissions first.",
    //     };
    //     return 1;
    //   }
    // },

    comparePermission() {
      //Check if not existed
      //Check each value if the same or not
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
        this.close();
      }
    },

    //Save Role Permission
    async storeAddPermissions() {
      // if (this.checkRolesIsValid() > 0) {
      //   return;
      // }
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
            this.close();
          })
          .catch((result) => {});
      }
    },

    //Compare User Roles
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
        this.close();
      }
    },

    //Set User Role
    //Get Roles
    async getAddUserRoles(item) {
      let self = this;
      self.tableAddRoles = [];
      await axios
        .get("/api/useracc/getRoles", { params: { user: item } })
        .then((result) => {
          self.tableAddRoles = result.data.data;
          self.selectedAddRoles = result.data.selected;
          self.selectedAddRoles_cloned = result.data.selected;
        })
        .catch((result) => {});
    },

    //Edit User Roles
    addUserRole(item) {
      this.dialogAddRoles = true;
      this.userid = item.id;
      this.username = item.name;
      this.getAddUserRoles(item.id);
    },

    //Save User Roles
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

    //Reset Form User Roles
    cancelUserRoles() {
      this.$refs.mainForm.resetValidation();
      this.dialogAddRoles = false;
    },

    //Close
    close() {
      this.dialogRoles = false;
      this.dialogPermissions = false;
      this.dialogAddPermissions = false;
      this.dialogAddRoles = false;
      (this.editedIndex = -1),
        this.$nextTick(() => {
          this.role = { name: "", id: "" };
          this.permission = { name: "", description: "", id: "" };
        });
    },

    //For deleting user role
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

  //New Update Title
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
    formTitle() {
      return this.editedIndex === -1 ? "ADD NEW " : "UPDATE ";
    },
    height() {
      if (this.$vuetify.breakpoint.smAndDown) {
        return 35;
      }
    },
  },

  //Watch
  watch: {
    dialogRoles(val) {
      val || this.close();
    },
    dialogPermissions(val) {
      val || this.close();
    },
    dialogAddRoles(val) {
      val || this.close();
    },
    page1(val) {
      this.page1 = val;
      this.getRoles();
    },
    page2(val) {
      this.page2 = val;
      this.getPermissions();
    },
    page3(val) {
      this.page2 = val;
      this.getUserRoles();
    },
  },
};
</script>
