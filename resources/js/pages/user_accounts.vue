<template>
  <div style="min-width: 280px">
    <v-container>
      <v-layout row wrap>
        <h5 class="heading my-auto">User Accounts</h5>
        <v-spacer></v-spacer>
        <v-breadcrumbs class="p-1" :items="items"></v-breadcrumbs>
      </v-layout>
    </v-container>

    <v-card elevation="6" class="mt-2" style="border-radius: 10px">
      <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
        <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
          <v-card-actions class="pl-0">
            <v-btn
              color="#00794b"
              style="text-transform: none"
              depressed
              dark
              class="mb-xl-2 mb-lg-2 mb-md-1 mb-sm-1 mb-1"
              small
              @click="openDialog"
            >
              Add User
            </v-btn>
          </v-card-actions>

          <v-row no-gutters>
            <v-col
              cols="12"
              xl="2"
              lg="2"
              md="3"
              sm="12"
              class="my-auto px-xl-2 px-lg-2 px-md-1 px-sm-1 px-1"
            >
              <v-text-field
                :value="itemsPerPage"
                label="Items per page"
                type="number"
                min="0"
                max="15"
                @input="itemsPerPage = parseInt($event, 10)"
              ></v-text-field>
            </v-col>
            <v-spacer></v-spacer>
            <v-col
              cols="12"
              xl="4"
              lg="4"
              md="5"
              sm="12"
              class="my-auto px-xl-2 px-lg-2 px-md-1 px-sm-1 px-1"
            >
              <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Name"
                single-line
                hide-details
                dense
                clearable
                class="my-0 mb-4 mb-xl-0 mb-lg-0 mb-md-0 mb-sm-2"
              ></v-text-field>
            </v-col>
          </v-row>
          <!--Table -->
          <v-data-table
            :headers="headers"
            :data="table"
            :page.sync="page"
            :items-per-page="itemsPerPage"
            hide-default-footer
            @page-count="pageCount = $event"
          >
          </v-data-table>
          <div class="text-center pt-2">
            <v-pagination v-model="page" :length="pageCount"></v-pagination>
          </div>
        </v-container>

        <!--Dialog Form-->
        <v-form ref="form">
          <v-dialog v-model="dialog" max-width="450px">
            <v-toolbar
              dense
              dark
              class="pl-xl-6 pl-lg-6 pl-md-6 pl-sm-5 pl-3 red darken-2"
            >
              Add User
            </v-toolbar>
            <v-card tile style="background-color: #f5f5f5">
              <v-card-text class="py-2">
                <br />
                <v-container class="pa-xl-3 pa-lg-3 pa-md-2 pa-sm-0 pa-0">
                  <v-row>
                    <v-col class="py-1" cols="12" xl="6" lg="6" sm="6" md="6">
                      <v-text-field
                        :rules="formRules"
                        v-model="form.firstName"
                        label=""
                        outlined
                        clearable
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">First Name *</div>
                        </template>
                      </v-text-field>
                    </v-col>

                    <v-col class="py-1" cols="12" xl="6" lg="6" sm="6" md="6">
                      <v-text-field
                        :rules="formRules"
                        v-model="form.lastName"
                        label=""
                        outlined
                        clearable
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Last Name *</div>
                        </template>
                      </v-text-field>
                    </v-col>

                    <v-col
                      class="py-1"
                      cols="12"
                      xl="12"
                      lg="12"
                      sm="12"
                      md="12"
                    >
                      <v-text-field
                        :rules="formRules"
                        v-model="form.email"
                        label=""
                        outlined
                        clearable
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Email *</div>
                        </template>
                      </v-text-field>
                    </v-col>

                    <v-col
                      class="py-1"
                      cols="12"
                      xl="12"
                      lg="12"
                      sm="12"
                      md="12"
                    >
                      <v-text-field
                        :rules="formRules"
                        v-model="form.phoneNumber"
                        label=""
                        outlined
                        clearable
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Phone Number *</div>
                        </template>
                      </v-text-field>
                    </v-col>

                    <v-col
                      class="py-1"
                      cols="12"
                      xl="12"
                      lg="12"
                      sm="12"
                      md="12"
                    >
                      <v-text-field
                        :rules="formRules"
                        v-model="form.userName"
                        label=""
                        outlined
                        clearable
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Username *</div>
                        </template>
                      </v-text-field>
                    </v-col>

                    <v-col class="py-1" cols="12" xl="6" lg="6" sm="6" md="6">
                      <v-text-field
                        :rules="formRules"
                        v-model="password"
                        :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                        :type="show1 ? 'text' : 'password'"
                        @click:append="show1 = !show1"
                        label=""
                        outlined
                        clearable
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Password *</div>
                        </template>
                      </v-text-field>
                    </v-col>

                    <v-col class="py-1" cols="12" xl="6" lg="6" sm="6" md="6">
                      <v-text-field
                        :rules="formRules"
                        v-model="confirmPass"
                        :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
                        :type="show2 ? 'text' : 'password'"
                        @click:append="show2 = !show2"
                        label=""
                        outlined
                        clearable
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Confirm Pass *</div>
                        </template>
                      </v-text-field>
                    </v-col>

                    <v-col
                      class="py-1"
                      cols="12"
                      xl="12"
                      lg="12"
                      sm="12"
                      md="12"
                    >
                      <v-select
                        :rules="formRules"
                        v-model="form.userType"
                        label=""
                        outlined
                        dense
                        clearable
                        :items="status"
                        item-text="name"
                        item-value="id"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">User Type *</div>
                        </template>
                      </v-select>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
              <!-- buttons -->
              <v-card-actions class="px-xl-9 px-lg-9 px-md-8 px-sm-7 px-6 py-4">
                <v-spacer></v-spacer>
                <v-btn
                  color="error"
                  depressed
                  :disabled="button"
                  dark
                  @click="cancel"
                  style="text-transform: none"
                  small
                >
                  Cancel
                </v-btn>
                <v-btn
                  color="primary"
                  depressed
                  :disabled="button"
                  dark
                  @click="test()"
                  style="text-transform: none"
                  small
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

<script>
export default {
  data: () => ({
    search: "",
    editedIndex: -1,
    button: false,
    dialog: false,
    status: ["Cashier", "Production Assistant", "Stockman", "Supervisor"],
    deleteid: "",
    progressBar: false,
    tempfile: "",
    table: [],
    formRules: [(v) => !!v || "This is required"],
    form: {
      firstName: null,
      lastName: null,
      email: null,
      phoneNumber: null,
      userName: null,
      password: null,
      confirmPass: null,
      userType: null,
    },
    show1: false,
    show2: false,
    headers: [
      { text: "#", value: "#", align: "start", filterable: false },
      { text: "Name", value: "name" },
      { text: "User Type", value: "user type", filterable: false },
      { text: "Actions", value: "actions", sortable: false, filterable: false },
    ],
    page: 1,
    pageCount: 0,
    itemsPerPage: 10,
    items: [
      {
        text: "Home",
        disabled: false,
        to: "/dashboard",
      },
      {
        text: "User Accounts",
        disabled: true,
      },
    ],
  }),
  methods: {
    test() {
      alert("Sample");
    },
    openDialog() {
      this.$refs.form.reset();
      this.dialog = true;
    },
    cancel() {
      this.$refs.form.reset();
      this.dialog = false;
    },
  },
  watch: {
    dialog(val) {
      //   alert("yes") // uncomment mo to then try mo press ung button,  ito ung nag tritriger pag ni open mo ung dialog
    },
    id: {
      handler: function (v) {},
    },
  },
};
</script>
