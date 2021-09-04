<template>
  <div style="min-width: 280px">
    <v-container>
      <v-layout row wrap>
        <h5 class="heading my-auto">Categories</h5>
        <v-spacer></v-spacer>
        <v-card-actions class="px-0">
          <v-btn
            plain
            small
            v-ripple="false"
            to="/dashboard"
            class="px-0"
            style="text-decoration: none; text-transform: none; font-size: 11px"
            >Home</v-btn
          >
          /
          <v-btn
            small
            text
            disabled
            class="px-0"
            style="text-transform: none; font-size: 11px"
            >Supplies Category</v-btn
          >
        </v-card-actions>
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
              Add Supply Category
            </v-btn>
          </v-card-actions>

          <v-list dense nav class="px-0 py-1">
            <v-list-group no-action color="#757575">
              <template v-slot:activator>
                <v-list-item-icon class="mx-0">
                  <v-icon size="20">mdi-filter</v-icon>
                </v-list-item-icon>
                <v-list-item-title
                  style="color: #757575; font-weight: bold"
                  class="px-3"
                  >Search Filter</v-list-item-title
                >
              </template>

              <v-list class="p-0">
                <v-row no-gutters>
                  <v-col
                    cols="12"
                    xl="2"
                    lg="2"
                    md="3"
                    sm="12"
                    class="my-auto px-xl-2 px-lg-2 px-md-1 px-sm-1 px-1"
                  >
                    <v-select
                      v-model="itemsPerPage"
                      label="Items per page"
                      class="pb-xl-0 pb-lg-0 pb-md-0 pb-sm-2 pb-0"
                      @change="get"
                      :items="[
                        1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15,
                      ]"
                    >
                    </v-select>
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
                      label="Supply Category"
                      single-line
                      hide-details
                      dense
                      clearable
                      class="my-0 mb-4 mb-xl-0 mb-lg-0 mb-md-0 mb-sm-2"
                    ></v-text-field>
                  </v-col>
                </v-row>
              </v-list>
            </v-list-group>
          </v-list>
          <!--Table -->

          <v-data-table
            :headers="headers"
            :items="table.data"
            :page.sync="page"
            :items-per-page="itemsPerPage"
            hide-default-footer
            @page-count="pageCount = $event"
          >
            <template v-slot:[`item.count`]="{ item }"> {{ item.id }}</template>
            <template v-slot:[`item.id`]="{ item }">
              <v-btn x-small color="info" text @click="edit(item)">
                edit ?</v-btn
              >
            </template>
          </v-data-table>

          <div class="text-center pt-2">
            <v-pagination
              v-model="page"
              :total-visible="5"
              :length="table.last_page"
            ></v-pagination>
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
              Add Supply Category
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
                      <v-text-field v-model="form.id" class="d-none" dense>
                        <template slot="label">
                          <div style="font-size: 14px">ID</div>
                        </template>
                      </v-text-field>

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
                        v-model="form.supply_cat_name"
                        label=""
                        outlined
                        clearable
                        dense
                        hide-details
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Supply Category *</div>
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
                  @click="save"
                  style="text-transform: none"
                  small
                >
                  Save
                </v-btn>
                <v-btn
                  color="primary"
                  depressed
                  :disabled="button"
                  dark
                  @click="get"
                  style="text-transform: none"
                  small
                >
                  get sample
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
import axios from "axios"; //library to for sendting request ng api
import template from "./template.vue";
import Swal from "sweetalert2";
export default {
  components: { template },
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
      id: null,
      status: null,
      supply_cat_name: null,
    },
    currentdata: {},
    headers: [
      { text: "#", value: "count", align: "start" },
      { text: "Supply Category", value: "supply_cat_name" },
      { text: "Status", value: "status", filterable: false },
      { text: "Actions", value: "id", sortable: false },
    ],
    page: 1,
    pageCount: 0,
    itemsPerPage: 5,
  }),

  created() {
    //onload
    this.get();
  },

  methods: {
    //everytime na mag call ka sa database ganto lang lagi format
    //dont forget add async and await
    compare() {
      //compare exsiting data vs edited data, if nothing change then no request
      if (!this.currentdata) {
        return true;
      } //check if not existed
      //check each value if the same or not
      var found = 0;
      for (var key in this.form) {
        if (this.currentdata[key] != this.form[key]) {
          found += 1;
        }
      }
      //if have changes
      if (found > 0) {
        return true;
      } else {
        Swal.fire({
          type: "info",
          title: "No changes found.",
        });
      }
    },
    async save() {
      if (this.compare()) {
        //save/update data in the table
        await axios
          .post("api/supplies/save", this.form)
          .then((result) => {
            //pag true daw ung value

            switch (result.data) {
              case 0:
                Swal.fire({
                  type: "success",
                  title: "The supplies group name has been saved.",
                  html: "test lang",
                });
                this.get();
                this.cancel();
                break;
              case 1:
                Swal.fire({
                  type: "info",
                  title: "The name already exsisted.",
                  html: "araling mo tong sweetalert2 google mo lang",
                });
                break;

              default:
                break;
            }
          })
          .catch((result) => {
            //pag false or error ung pag save mo
          });
      }
    },
    async get() {
      //get data from tables
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;
      await axios
        .get("api/supplies/get", {
          params: { page: this.page, itemsPerPage: this.itemsPerPage },
        })
        .then((result) => {
          //pag true daw ung value
          this.table = result.data;
        })
        .catch((result) => {
          //pag false or error ung pag save mo
        });
    },
    edit(row) {
      this.currentdata = JSON.parse(JSON.stringify(row));
      this.form.id = row.id;
      this.form.status = row.status;
      this.form.supply_cat_name = row.supply_cat_name;
      this.dialog = true;
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
