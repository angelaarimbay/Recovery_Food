<template>
  <div style="min-width: 280px">
    <v-container>
      <v-layout row wrap>
        <h5 class="heading my-auto">Branches</h5>
        <v-spacer></v-spacer>
        <v-breadcrumbs class="p-1" :items="items"></v-breadcrumbs>
      </v-layout>
    </v-container>

    <v-card class="mt-2" style="border-radius: 10px">
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
              Add Branch
            </v-btn>
          </v-card-actions>

          <v-row no-gutters>
            <v-col cols="12" xl="2" lg="2" md="3" sm="12" class="mt-1">
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
            <v-col cols="12" xl="4" lg="4" md="5" sm="12" class="my-auto">
              <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Store Name"
                single-line
                hide-details
                dense
                clearable
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
              class="pl-xl-7 pl-lg-7 pl-md-7 pl-sm-5 pl-3 red darken-2"
            >
              Add Branch
            </v-toolbar>
            <v-card tile style="background-color: #f5f5f5">
              <v-card-text>
                <br />
                <v-container class="p-xl-3 p-lg-3 p-md-2 p-sm-0 p-0">
                  <v-row>
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
                        v-model="form.name"
                        label=""
                        outlined
                        clearable
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Store Name *</div>
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
                        v-model="form.location"
                        label=""
                        outlined
                        clearable
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Location *</div>
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
                        v-model="form.number"
                        label=""
                        outlined
                        clearable
                        dense
                      >
                        <template slot="label">
                          <div style="font-size: 14px">Contact Number *</div>
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
                          <div style="font-size: 14px">Email Address *</div>
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
                      <div style="font-size: 14px">Attachment *</div>
                      <div v-if="form.document">
                        Uploaded file :
                        <a
                          :href="
                            '/storage/files/employee/document/' + form.document
                          "
                          download
                        >
                          {{ tempfile }}
                        </a>
                        <v-icon v-if="form.document" @click="deletefile"
                          >mdi-delete</v-icon
                        ><br /><br />
                      </div>
                      <v-progress-linear
                        v-show="progressBar"
                        slot="progress"
                        color="green"
                        indeterminate
                      ></v-progress-linear>
                      <v-btn
                        text
                        outlined
                        color="primary"
                        class="btn btn-block"
                        style="text-transform: none"
                        @click="clickupload"
                        ><v-icon>mdi-upload</v-icon> Upload File
                      </v-btn>
                      <input
                        ref="uploader"
                        clearable
                        class="d-none"
                        type="file"
                        @change="uploaddocument"
                      />
                    </v-col>

                    <v-col
                      class="py-1"
                      cols="12"
                      xl="12"
                      lg="12"
                      sm="12"
                      md="4"
                    >
                      <v-text-field
                        style="display: none"
                        :rules="formRules"
                        v-model="form.document"
                        label="Document"
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
              <!-- buttons -->
              <v-card-actions>
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
      name: null,
      location: null,
      number: null,
      email: null,
      document: null,
    },
    headers: [
      { text: "#", value: "#", align: "start", filterable: false },
      { text: "Store Name", value: "name" },
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
        text: "Manage Branches",
        disabled: true,
      },
    ],
  }),
  methods: {
    test() {
      alert("Sample");
    },
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
    uploaddocument() {
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