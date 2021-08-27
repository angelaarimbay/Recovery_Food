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
              Add Supply
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
                label="Supply Name"
                single-line
                hide-details
                dense
                clearable
                class="my-0 mb-4 mb-xl-0 mb-lg-0 mb-md-0 mb-sm-0"
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
              Add Supply
            </v-toolbar>
            <v-card tile style="background-color: #f5f5f5">
              <v-card-text class="py-2">
                <br />
                <v-container class="pa-xl-3 pa-lg-3 pa-md-2 pa-sm-0 pa-0">
                  <v-row>
                    <v-col class="py-1" cols="12" xl="5" lg="5" sm="5" md="5">
                      <v-select
                        :rules="formRules"
                        v-model="form.status"
                        label=""
                        outlined
                        dense
                        clearable
                        :items="status"
                        item-text="name"
                        item-value="id"
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Status *</div>
                        </template>
                      </v-select>
                    </v-col>

                    <v-col class="py-1" cols="12" xl="7" lg="7" sm="7" md="7">
                      <v-select
                        :rules="formRules"
                        v-model="form.suppCategory"
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
                      <v-text-field
                        :rules="formRules"
                        v-model="form.suppName"
                        label=""
                        outlined
                        clearable
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Supply Name *</div>
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
                        v-model="form.suppDescription"
                        label=""
                        outlined
                        clearable
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Description</div>
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
                        v-model="form.suppUnit"
                        label=""
                        outlined
                        clearable
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Unit *</div>
                        </template>
                      </v-text-field>
                    </v-col>

                    <v-col class="py-1" cols="12" xl="6" lg="6" sm="6" md="6">
                      <v-text-field
                        :rules="formRules"
                        v-model="form.suppNetPrice"
                        label=""
                        outlined
                        clearable
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Net Price *</div>
                        </template>
                      </v-text-field>
                    </v-col>

                    <v-col class="py-1" cols="12" xl="6" lg="6" sm="6" md="6">
                      <v-layout align-center>
                        <v-text-field
                          v-model="form.suppVAT"
                          label=""
                          outlined
                          clearable
                          dense
                        >
                          <template slot="label">
                            <div style="font-size: 14px">VAT</div>
                          </template>
                        </v-text-field>

                        <v-checkbox
                          v-model="enabled"
                          hide-details
                          class="shrink pt-0 mt-0 mb-7 ml-3"
                        ></v-checkbox>
                      </v-layout>
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
                        disabled
                        v-model="form.suppWOVAT"
                        label=""
                        outlined
                        clearable
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Price w/o VAT</div>
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
                  color="#FF5252"
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
                  color="#00794b"
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
      status: null,
      suppCategory: null,
      suppName: null,
      suppDescription: null,
      suppUnit: null,
      suppVAT: null,
      suppWOVAT: null,
    },
    enabled: false,
    headers: [
      { text: "#", value: "#", align: "start", filterable: false },
      { text: "Supply Name", value: "name" },
      { text: "Status", value: "status", filterable: false },
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
        text: "Masterlist Supplies",
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
