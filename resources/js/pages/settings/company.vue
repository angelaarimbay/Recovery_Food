 
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

    <v-container>
      <v-layout row wrap>
        <h4
          class="font-weight-bold heading my-auto"
          :class="{ h5: $vuetify.breakpoint.smAndDown }"
        >
          Company
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
            >Company</v-btn
          >
        </v-card-actions>
      </v-layout>
    </v-container>

    <!-- Main Card -->
    <v-card elevation="1" class="mt-2" style="border-radius: 10px">
      <v-form ref="mainForm" id="mainForm">
        <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-1">
          <v-row justify="center">
            <!-- Image -->
            <v-col
              cols="12"
              xl="6"
              lg="12"
              md="12"
              sm="12"
              style="max-width: 525px"
            >
              <v-card-title
                class="
                  text-subtitle-1 text-xl-h5 text-lg-h5 text-md-h6 text-sm-h6
                  p-0
                  justify-center
                "
                style="color: #c62828"
                >Logo</v-card-title
              >
              <v-img
                style="border: 2px solid #757575; border-radius: 10px"
                contain
                :src="temppath"
                height="320"
              ></v-img>
              <v-progress-linear
                v-show="progressBar"
                color="red darken-2"
                indeterminate
                rounded
              ></v-progress-linear>
              <v-row no-gutters>
                <v-col cols="12" class="py-2">
                  <v-tooltip bottom>
                    <template #activator="data">
                      <!-- Upload Button -->
                      <v-btn
                        v-on="data.on"
                        block
                        outlined
                        color="grey darken-1"
                        class="btn-block"
                        style="text-transform: none; font-size: 12px"
                        @click="clickupload"
                        :small="$vuetify.breakpoint.smAndDown"
                      >
                        <v-icon>mdi-upload</v-icon> Upload Image
                      </v-btn>
                    </template>
                    <span>Choose an image</span>
                  </v-tooltip>
                </v-col>
              </v-row>
              <input
                id="upload"
                ref="uploader"
                clearable
                accept="image/png, image/jpeg"
                class="d-none"
                type="file"
                @change="uploaddocument"
              />
              <div style="font-size: 12px" class="pt-2" v-if="form.attachment">
                <span>Image Attachment:</span>
                <v-row no-gutters justify="center" align="center">
                  <v-col cols="10">
                    <a :href="temppath" download>
                      {{ tempfile }}
                    </a>
                  </v-col>

                  <v-col cols="2" class="text-center">
                    <!-- Delete Button -->
                    <v-tooltip bottom>
                      <template #activator="data">
                        <v-icon
                          v-on="data.on"
                          color="red darken-2"
                          class="text-center"
                          @click="deletefile"
                          >mdi-delete</v-icon
                        >
                      </template>
                      <span>Remove Image</span>
                    </v-tooltip>
                  </v-col>
                </v-row>
              </div>

              <v-divider class="my-2"></v-divider>

              <!-- VAT -->
              <v-card-title
                class="
                  text-subtitle-1 text-xl-h5 text-lg-h5 text-md-h6 text-sm-h6
                  p-0
                  justify-center
                "
                style="color: #c62828"
                >VAT</v-card-title
              >
              <v-row no-gutters>
                <v-col
                  cols="6"
                  xl="6"
                  lg="6"
                  md="6"
                  sm="6"
                  class="tfield py-1 px-0 pr-1"
                >
                  <span style="font-size: 12px">Supplies VAT</span>
                  <v-text-field
                    :rules="formRulesVAT"
                    v-model="form.supp_vat"
                    dense
                    persistent-placeholder
                    clearable
                    counter
                    @keydown="VATKeydown($event)"
                    maxlength="6"
                    @blur="resetSV"
                    background-color="white"
                    flat
                    solo
                    style="font-size: 12px"
                  ></v-text-field>
                </v-col>
                <v-col
                  cols="6"
                  xl="6"
                  lg="6"
                  md="6"
                  sm="6"
                  class="tfield py-1 px-0 pl-1"
                >
                  <span
                    style="font-size: 12px"
                    class="pl-0 pl-xl-1 pl-lg-1 pl-md-1 pl-sm-1"
                    >Products VAT</span
                  >
                  <v-text-field
                    :rules="formRulesVAT"
                    v-model="form.prod_vat"
                    dense
                    clearable
                    persistent-placeholder
                    counter
                    @keydown="VATKeydown($event)"
                    maxlength="6"
                    @blur="resetPV"
                    background-color="white"
                    flat
                    solo
                    style="font-size: 12px"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-col>

            <v-col
              cols="12"
              xl="6"
              lg="12"
              md="12"
              sm="12"
              style="max-width: 525px"
            >
              <v-divider :hidden="$vuetify.breakpoint.lgAndUp" class="my-2"></v-divider>
              <!-- History -->
              <v-card-title
                class="
                  text-subtitle-1 text-xl-h5 text-lg-h5 text-md-h6 text-sm-h6
                  p-0
                  justify-center
                "
                style="color: #c62828"
                >History</v-card-title
              >
              <v-col
                cols="12"
                xl="12"
                lg="12"
                md="12"
                sm="12"
                class="tfield py-1 px-0"
              >
                <v-textarea
                  :rules="formRulesText"
                  v-model="form.history"
                  height="125px"
                  counter
                  @keydown="textKeydown($event)"
                  maxlength="300"
                  background-color="white"
                  flat
                  solo
                  style="font-size: 12px"
                >
                  <template slot="label">
                    <div style="font-size: 12px">Insert text here</div>
                  </template></v-textarea
                >
              </v-col>

              <v-divider class="my-2"></v-divider>

              <!-- Mission -->
              <v-card-title
                class="
                  text-subtitle-1 text-xl-h5 text-lg-h5 text-md-h6 text-sm-h6
                  p-0
                  justify-center
                "
                style="color: #c62828"
                >Mission</v-card-title
              >
              <v-col
                cols="12"
                xl="12"
                lg="12"
                md="12"
                sm="12"
                class="tfield py-1 px-0"
              >
                <v-textarea
                  :rules="formRulesText"
                  v-model="form.mission"
                  height="125px"
                  counter
                  @keydown="textKeydown($event)"
                  maxlength="300"
                  background-color="white"
                  flat
                  solo
                  style="font-size: 12px"
                >
                  <template slot="label">
                    <div style="font-size: 12px">Insert text here</div>
                  </template></v-textarea
                >
              </v-col>
              <!-- Vision -->
              <v-card-title
                class="
                  text-subtitle-1 text-xl-h5 text-lg-h5 text-md-h6 text-sm-h6
                  p-0
                  justify-center
                "
                style="color: #c62828"
                >Vision</v-card-title
              >
              <v-col
                cols="12"
                xl="12"
                lg="12"
                md="12"
                sm="12"
                class="tfield py-1 px-0"
              >
                <v-textarea
                  :rules="formRulesText"
                  v-model="form.vision"
                  height="125px"
                  counter
                  @keydown="textKeydown($event)"
                  maxlength="300"
                  background-color="white"
                  flat
                  solo
                  style="font-size: 12px"
                >
                  <template slot="label">
                    <div style="font-size: 12px">Insert text here</div>
                  </template></v-textarea
                >
              </v-col>
              <v-btn
                style="text-transform: none"
                color="primary"
                depressed
                :disabled="button"
                dark
                @click="save"
                :small="$vuetify.breakpoint.xsOnly"
                block
              >
                Save
              </v-btn>
            </v-col>
          </v-row>
        </v-container>
      </v-form>
    </v-card>
  </div>
</template>

<!-- Style -->
<style>
textarea {
  text-align: justify;
}

.v-input__control .v-icon.notranslate.v-icon--link.mdi.mdi-close {
  font-size: 16px;
}

.container {
  max-width: 1500px !important;
}

.v-application .tfield .white {
  border: 1px solid #bdbdbd !important;
}
.tfield .v-input--is-focused .v-input__slot {
  border: 1px solid #42a5f5 !important;
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
  //Computed
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
  },

  //Data
  data: () => ({
    tempfile: "",
    tab: null,
    temppath: "/img/Logo.jpg",
    isSelecting: false,
    progressBar: false,
    button: false,
    snackbar: {
      active: false,
      message: "",
    },
    form: {
      id: "",
      attachment: "",
      prod_vat: 0,
      supp_vat: 0,
      history: "",
      mission: "",
      vision: "",
    },

    //Form rules
    formRulesVAT: [
      (v) => !!v || "This is required",
      (v) => /^[0-9]\d{0,7}(?:\.\d{1,4})?$/.test(v) || "VAT must be valid",
    ],
    formRulesText: [
      (v) => !!v || "This is required",
    ],
  }),

  //Onload
  created() {
    this.get();
  },

  //Methods
  methods: {
    //Keydown
    VATKeydown(e) {
      if (/[\s~`!@#$%^&()_={}[\]\\"*|:;,<>+'\/?-]/.test(e.key)) {
        e.preventDefault();
      }
    },
    textKeydown(e) {
      if (/[~`!@$%^&={}[\]\\*|:;<>+\?]/.test(e.key)) {
        e.preventDefault();
      }
    },

    resetSV() {
      if (this.form.supp_vat == null) {
        this.form.supp_vat = 0;
      }
    },

    resetPV() {
      if (this.form.prod_vat == null) {
        this.form.prod_vat = 0;
      }
    },

    //For deleting uploaded file
    async deletefile() {
      this.form.attachment = "";
      this.tempfile = "";
      this.temppath = "/img/Logo.jpg";
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

    //For uploading file
    async uploaddocument(e) {
      if (e.target.files[0].size > 10485760) {
        this.snackbar = {
          active: true,
          iconText: "alert-box",
          iconColor: "error",
          message: "The image size should be less than or equal to 10 MB.",
        };
      } else {
        var file = document.querySelector("#upload");
        if (/\.(jpe?g|png)$/i.test(file.files[0].name) === false) {
          this.snackbar = {
            active: true,
            iconText: "alert-box",
            iconColor: "error",
            message: "Please select JPEG or PNG only.",
          };
        } else {
          this.progressBar = true;
          var dataform = new FormData();
          dataform.append("file", e.target.files[0]);
          await axios
            .post("/api/settings/company/logo/upload", dataform, {
              headers: { "Content-Type": "multipart/form-data" },
            })
            .then((result) => {
              this.progressBar = false;
              this.form.attachment = result.data.tempfile;
              this.tempfile = result.data.filename;
              this.temppath = result.data.path ?? "/img/Logo.jpg";
            });
        }
      }
    },

    //For retrieving logo
    async getLogo() {
      await axios.get("/api/settings/company/logo/get").then((result) => {
        this.form.attachment = result.data.tempfile;
        this.tempfile = result.data.filename;
        this.temppath = result.data.path ?? "/img/Logo.jpg";
      });
    },

    //For saving data
    async save() {
      if (this.$refs.mainForm.validate()) {
        await axios
          .post("/api/settings/company/save", this.form)
          .then((result) => {
            this.snackbar = {
              active: true,
              iconText: "check",
              iconColor: "success",
              message: "Successfully saved.",
            };
          });
      }
    },

    //For retrieving data
    async get() {
      await axios
        .get("/api/settings/company/get")
        .then((result) => {
          if (result.data) {
            this.form.id = result.data.id;
            this.form.history = result.data.history;
            this.form.mission = result.data.mission;
            this.form.vision = result.data.vision;
            this.form.prod_vat = result.data.prod_vat;
            this.form.supp_vat = result.data.supp_vat;
            if (result.data.attachment.tempfile) {
              this.form.attachment = result.data.attachment.tempfile;
              this.tempfile = result.data.attachment.filename;
              this.temppath = result.data.attachment.path;
            } else [(this.temppath = "/img/Logo.jpg")];
          }
        })
        .catch((result) => {
          //If false or error when saving
        });
    },
  },
};
</script>