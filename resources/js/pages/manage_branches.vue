<template>
  <div style="min-width: 280px">
    <!-- Snackbar -->
    <v-snackbar
      :vertical="$vuetify.breakpoint.xsOnly"
      min-width="auto"
      v-model="snackbar.active"
      timeout="2500"
      app
      bottom
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

    <v-container>
      <v-layout row wrap>
        <h5 class="heading my-auto">Branches</h5>
        <v-spacer></v-spacer>

        <!-- Breadcrumbs -->
        <v-card-actions class="px-0">
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
            >Manage Branches</v-btn
          >
        </v-card-actions>
      </v-layout>
    </v-container>

    <!-- Main Card -->
    <v-card elevation="6" class="mt-2" style="border-radius: 10px">
      <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
        <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
          <v-card-actions class="pl-0">
            <v-btn
              color="#00794b"
              style="text-transform: none"
              depressed
              dark
              :small="$vuetify.breakpoint.smAndDown"
              class="mb-xl-2 mb-lg-2 mb-md-1 mb-sm-1 mb-1"
              @click="openDialog"
            >
              Add Branch
            </v-btn>
          </v-card-actions>

          <!-- Search Filters -->
          <v-list dense nav class="px-0 py-0">
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
                  <!-- Items Per Page -->
                  <v-col cols="4" xl="2" lg="2" md="3" sm="4">
                    <v-card-actions>
                      <v-select
                        style="max-width: 82px"
                        dense
                        v-model="itemsPerPage"
                        label="Items per page"
                        @change="itemperpage"
                        :items="[
                          1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15,
                        ]"
                      >
                      </v-select>
                    </v-card-actions>
                  </v-col>

                  <v-spacer></v-spacer>

                  <!-- Search Field -->
                  <v-col
                    cols="8"
                    xl="4"
                    lg="4"
                    md="6"
                    sm="8"
                    style="max-width: 230px"
                  >
                    <v-card-actions>
                      <v-text-field
                        v-model="search"
                        label="Branch Name"
                        single-line
                        dense
                        clearable
                      ></v-text-field>
                      <v-btn
                        :small="$vuetify.breakpoint.smAndDown"
                        :large="$vuetify.breakpoint.mdAndUp"
                        color="red darken-2"
                        icon
                        @click="get"
                      >
                        <v-icon>mdi-magnify</v-icon></v-btn
                      >
                    </v-card-actions>
                  </v-col>
                </v-row>
              </v-list>
            </v-list-group>
          </v-list>

          <!-- Table -->
          <v-data-table
            :headers="headers"
            :items="table.data"
            :loading="progressbar"
            :page.sync="page"
            ref="progress"
            :items-per-page="itemsPerPage"
            hide-default-footer
            @page-count="pageCount = $event"
          >
            <!-- Progress Bar -->
            <v-progress-linear
              color="red"
              class="px-0 mx-0"
              slot="progress"
              indeterminate
              rounded
            ></v-progress-linear>

            <template v-slot:[`item.count`]="{ item }">
              {{ item.row }}</template
            >
            <template v-slot:[`item.status`]="{ item }">
              <v-chip
                style="justify-content: center"
                :style="widthSize"
                :small="$vuetify.breakpoint.smAndDown"
                :color="
                  item.status === 'Active'
                    ? '#43A047'
                    : item.status === 'Inactive'
                    ? '#FF6F00'
                    : ''
                "
                dark
              >
                {{ item.status }}
              </v-chip>
            </template>
            <template v-slot:[`item.id`]="{ item }">
              <v-btn
                icon
                color="red darken-2"
                @click="edit(item)"
                :x-small="$vuetify.breakpoint.smAndDown"
              >
                <v-icon>mdi-pencil</v-icon>
              </v-btn>
            </template>
          </v-data-table>

          <!-- Paginate -->
          <div class="text-center pt-2">
            <v-pagination
              v-model="page"
              :total-visible="5"
              :length="table.last_page"
              color="red darken-2"
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
              Branch
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
                        v-model="form.branch_name"
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
                        v-model="form.phone_number"
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
                        v-model="form.email_add"
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

                      <!-- <v-img width="200" :src="'/storage/branches/'+form.branch_image"></v-img> -->
                      <!-- pag merong file. didisplay ung file. -->
                      <div v-if="form.branch_image">  
                        Uploaded file :
                        <a :href=" '/storage/branches/' + form.branch_image " download >
                          {{ tempfile }}
                        </a>
                        
                        <v-icon v-if="form.branch_image" @click="deletefile"
                          >mdi-delete</v-icon
                        ><br /><br />
                      </div>
                      <!-- ito ung loading pag aupload. nasasayo kung 
                      gagamit ka. pag ndi delete mo -->
                      <v-progress-linear
                        v-show="progressbar"
                        slot="progress"
                        color="green"
                        indeterminate
                      ></v-progress-linear>
                            <!-- ito ung button ni vue. nasasayo ung design-->
                      <v-btn 
                        dark 
                        color="primary"
                        class="btn btn-block"
                        style="text-transform: none"
                        @click="clickupload"
                        ><v-icon>mdi-upload</v-icon> Upload File
                      </v-btn>
                      <!-- need ito for upload  -->
                      <input
                        ref="uploader"
                        clearable
                        accept="image/*"
                        class="d-none"
                        type="file"
                        @change="attachment"
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
                       
                        v-model="form.branch_image"
                        label="Document"
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>

              <!-- Dialog Form Buttons -->
              <v-card-actions class="px-xl-9 px-lg-9 px-md-8 px-sm-6 px-6 py-4">
                <v-spacer></v-spacer>
                <v-btn
                  color="error"
                  depressed
                  :disabled="button"
                  dark
                  @click="cancel"
                  style="text-transform: none"
                  :small="$vuetify.breakpoint.smAndDown"
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
                  :small="$vuetify.breakpoint.smAndDown"
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

<style>
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
import axios from "axios"; // Library for sending api request
export default {
  data: () => ({
    progressbar: false,
    snackbar: {
      active: false,
      message: "",
    },
    search: "",
    editedIndex: -1,
    button: false,
    dialog: false,
    status: ["Active", "Inactive"],
    deleteid: "",
    tempfile: "", //----------------------------------upload
    table: [],

    // Form Rules
    formRules: [(v) => !!v || "This is required"],
    formRulesNumberRange: (v) => {
      if (!isNaN(parseFloat(v)) && v >= 1 && v <= 100) return true;
      return "Number has to be between 1% and 100%";
    },
    formRulesNumber: [
      (v) => Number.isInteger(Number(v)) || "The value must be an integer",
    ],

    // Form Data
    form: {
      id: null,
      status: null,
      branch_name: null,
      location: null,
      phone_number: null,
      email_add: null,
      branch_image: null, 
    },

    // For comparing data
    currentdata: {},

    // Table Headers
    headers: [
      { text: "#", value: "count", align: "start", filterable: false },
      { text: "Branch Name", value: "branch_name" },
      {
        text: "Status",
        value: "status",
        align: "center",
        filterable: false,
      },
      {
        text: "Actions",
        value: "id",
        align: "center",
        sortable: false,
        filterable: false,
      },
    ],
    page: 1,
    pageCount: 0,
    itemsPerPage: 5,
  }),

  // Dynamic Width
  computed: {
    widthSize() {
      switch (this.$vuetify.breakpoint.name) {
        case "xs":
          return { width: "65px" };
        case "sm":
          return { width: "65px" };
        default:
          return { width: "72px" };
      }
    },
  },

  // Onload
  created() {
    this.get();
  },

  methods: {
    itemperpage() {
      this.page = 1;
      this.get();
    },

    // Format for everytime we call on database
    // Always add await and async
    compare() {
      // Compare exsiting data vs edited data
      // If nothing change then no request
      if (!this.currentdata) {
        return true;
      }
      // Check if not existed
      // Check each value if the same or not
      var found = 0;
      for (var key in this.form) {
        if (this.currentdata[key] != this.form[key]) {
          found += 1;
        }
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
        this.cancel();
      }
    },

    // Saving data to database
    async save() {
      if (this.$refs.form.validate()) {
        // Validate first before compare
        if (this.compare()) {
          console.log(this.form)
          // Save or update data in the table
          await axios
            .post("api/branches/save", this.form)
            .then((result) => {
              //if the value is true then save to database
              switch (result.data) {
                case 0:
                  this.snackbar = {
                    active: true,
                    iconText: "check",
                    iconColor: "success",
                    message: "Successfully saved.",
                  };
                  this.get();
                  this.cancel();
                  break;
                case 1:
                  this.snackbar = {
                    active: true,
                    iconText: "alert",
                    iconColor: "error",
                    message: "The branch name already exists.",
                  };
                  break;
                default:
                  break;
              }
            })
            .catch((result) => {
              // If false or error when saving 
            });
        }
      }
    },
    async get() {
      this.progressbar = true; // Show the progress bar
      // Get data from tables
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;
      await axios
        .get("api/branches/get", {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,
            search: this.search,
          },
        })
        .then((result) => {
          // If the value is true then get the data
          this.table = result.data;
          this.progressbar = false; // Hide the progress bar
        })
        .catch((result) => {
          // If false or error when saving
        });
    },


    //----------------------------------upload
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
    deletefile() {
      this.$refs.uploader.value = null;
     
            this.tempfile = ''
            this.form.branch_image = ''
    },  
    async attachment(e){
    var dataform = new FormData(); //u can use typical jquery formdata
      dataform.append("file", e.target.files[0]);

      await axios.post('api/branches/attachment', dataform, {
          headers: { "Content-Type": "multipart/form-data" }
          }).then(result=>{
            this.tempfile = result.data.fakename
            this.form.branch_image = result.data.filename
          
      });
    },  
    //----------------------------------upload
    // Editing/updating of row
    edit(row) {
      this.currentdata = JSON.parse(JSON.stringify(row));
      this.form.id = row.id;
      this.form.status = row.status;
      this.form.branch_name = row.branch_name;
      this.form.location = row.location;
      this.form.phone_number = row.phone_number;
      this.form.email_add = row.email_add;
      this.form.branch_image = row.branch_image;
      this.tempfile = (row.branch_image? row.branch_image.split("-")[0]:null);
      this.dialog = true;
    },

    // Open Dialog Form
    openDialog() {
      this.$refs.form.reset();
      this.dialog = true;
    },

    // Reset Forms
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
