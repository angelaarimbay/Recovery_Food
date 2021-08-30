<template>
  <div style="min-width: 280px">
    <v-container>
      <v-layout row wrap>
        <h5 class="heading my-auto">Inventory</h5>
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
              Add Incoming Supply
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
              md="6"
              sm="12"
              class="my-auto px-xl-2 px-lg-2 px-md-1 px-sm-1 px-1"
            >
              <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Invoice No/Supply"
                single-line
                hide-details
                dense
                clearable
                class="my-0 mb-4 mb-xl-0 mb-lg-0 mb-md-0 mb-sm-2"
              ></v-text-field>
            </v-col>
          </v-row>

          <v-row no-gutters>
            <v-col
              cols="12"
              xl="2"
              lg="2"
              md="3"
              sm="12"
              class="my-auto py-1 px-xl-2 px-lg-2 px-md-1 px-sm-1 px-1"
            >
              <v-combobox clearable dense label="Category"> </v-combobox>
            </v-col>

            <v-spacer></v-spacer>

            <v-col
              cols="6"
              xl="2"
              lg="2"
              md="3"
              sm="6"
              class="my-auto py-2 px-xl-2 px-lg-2 px-md-1 px-sm-1 px-1"
            >
              <v-menu
                v-model="date1"
                :close-on-content-click="false"
                :nudge-right="35"
                lazy
                transition="scale-transition"
                offset-y
                full-width
                min-width="290px"
              >
                <template v-slot:activator="{ on }">
                  <v-text-field
                    v-model="dateFrom"
                    label="Date From"
                    prepend-icon="mdi-calendar-range"
                    readonly
                    v-on="on"
                    class="py-0"
                    dense
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="dateFrom"
                  @input="date1 = false"
                  scrollable
                ></v-date-picker>
              </v-menu>
            </v-col>

            <v-col
              cols="6"
              xl="2"
              lg="2"
              md="3"
              sm="6"
              class="my-auto py-2 px-xl-2 px-lg-2 px-md-1 px-sm-1 px-1"
            >
              <v-menu
                v-model="date2"
                :close-on-content-click="false"
                :nudge-right="35"
                lazy
                transition="scale-transition"
                offset-y
                full-width
                min-width="290px"
              >
                <template v-slot:activator="{ on }">
                  <v-text-field
                    v-model="dateUntil"
                    label="Date Until"
                    prepend-icon="mdi-calendar-range"
                    readonly
                    v-on="on"
                    class="py-0"
                    dense
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="dateUntil"
                  @input="date2 = false"
                  scrollable
                ></v-date-picker>
              </v-menu>
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
              Add Incoming Supply
            </v-toolbar>
            <v-card tile style="background-color: #f5f5f5">
              <v-card-text class="py-2">
                <br />
                <v-container class="pa-xl-3 pa-lg-3 pa-md-2 pa-sm-0 pa-0">
                  <v-row>
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
                        v-model="form.invNumber"
                        label=""
                        outlined
                        clearable
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Invoice Number *</div>
                        </template>
                      </v-text-field>
                    </v-col>

                    <v-col class="py-1" cols="12" xl="6" lg="6" sm="6" md="6">
                      <v-select
                        :rules="formRules"
                        v-model="form.supplierName"
                        label=""
                        outlined
                        dense
                        clearable
                        item-text="name"
                        item-value="id"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Supplier Name *</div>
                        </template>
                      </v-select>
                    </v-col>

                    <v-col class="py-1" cols="12" xl="6" lg="6" sm="6" md="6">
                      <v-text-field
                        v-model="form.supplierDesc"
                        label=""
                        outlined
                        clearable
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">
                            Supplier Description
                          </div>
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
                        v-model="form.supplyCat"
                        label=""
                        outlined
                        dense
                        clearable
                        item-text="name"
                        item-value="id"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Supply Category *</div>
                        </template>
                      </v-select>
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
                        v-model="form.supplyName"
                        label=""
                        outlined
                        dense
                        clearable
                        item-text="name"
                        item-value="id"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Supply Name *</div>
                        </template>
                      </v-select>
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
                        v-model="form.supplyDesc"
                        label=""
                        outlined
                        clearable
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Supply Description</div>
                        </template>
                      </v-text-field>
                    </v-col>

                    <v-col class="py-1" cols="12" xl="6" lg="6" sm="6" md="6">
                      <v-select
                        :rules="formRules"
                        v-model="form.supplyUnit"
                        label=""
                        outlined
                        dense
                        clearable
                        item-text="name"
                        item-value="id"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Supply Unit *</div>
                        </template>
                      </v-select>
                    </v-col>

                    <v-col class="py-1" cols="12" xl="6" lg="6" sm="6" md="6">
                      <v-text-field
                        :rules="formRules"
                        v-model="form.invNumber"
                        label=""
                        outlined
                        clearable
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Supply Quantity *</div>
                        </template>
                      </v-text-field>
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
    status: ["Active", "Inactive"],
    deleteid: "",
    progressBar: false,
    tempfile: "",
    table: [],
    formRules: [(v) => !!v || "This is required"],
    form: {
      invNumber: null,
      supplierName: null,
      supplierDesc: null,
      supplyCat: null,
      supplyName: null,
      supplyDesc: null,
      supplyUnit: null,
      supplyQty: null,
    },
    headers: [
      { text: "#", value: "#", align: "start", filterable: false },
      { text: "Invoice Number", value: "invoice number" },
      { text: "Supply Name", value: "supply name" },
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
        text: "Incoming Supplies",
        disabled: true,
      },
    ],
    dateFrom: new Date().toISOString().substr(0, 10),
    dateUntil: new Date().toISOString().substr(0, 10),
    date1: false,
    date2: false,
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
