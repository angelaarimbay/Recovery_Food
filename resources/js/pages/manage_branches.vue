<template>
  <div>
    <v-container>
      <v-layout row wrap>
        <h5 class="heading my-auto">Branches</h5>
        <v-spacer></v-spacer>
        <v-breadcrumbs class="p-0 m-0" :items="items"></v-breadcrumbs>
      </v-layout>
    </v-container>

    <v-card class="mt-2">
      <v-container>
        <v-container>
          <v-card-actions class="pl-0">
            <v-btn
              color="#00794b"
              style="text-transform: none"
              depressed
              dark
              class="mb-2"
              small
              @click="dialog = true"
            >
              Add Branch
            </v-btn>
          </v-card-actions>

          <v-row no-gutters>
            <v-col cols="12" xl="2" lg="2" sm="12" md="3" class="mt-1">
              <v-text-field
                :value="itemsPerPage"
                label="Items per page"
                type="number"
                min="0"
                max="15"
                @input="itemsPerPage = parseInt($event, 10)"
              ></v-text-field>
            </v-col>

            <v-col cols="12" xl="4" lg="4" sm="12" md="5" class="ml-auto my-auto">
              <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search Store Name"
                single-line
                hide-details
                dense
                clearable="true"
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
            <v-toolbar dense dark color="primary" class="pl-7">
              Add Branch
            </v-toolbar>
            <v-card tile style="background-color: #f5f5f5">
              <v-card-text>
                <br />
                <v-container class="p-3">
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
                        clearable="true"
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
                        clearable="true"
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
                        clearable="true"
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
                        clearable="true"
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
                        clearable="true"
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
                  @click="clear"
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
    clear() {
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