 
<template>
  <div style="min-width: 280px">
    <!-- Snackbar -->
    <v-snackbar
      :vertical="$vuetify.breakpoint.xsOnly"
      min-width="auto"
      v-model="snackbar.active"
      timeout="2500"
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

    <v-form ref="mainForm" id="mainForm">
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
      <v-card elevation="6" class="mt-2" style="border-radius: 10px">
        <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-1">
          <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
            <v-row>
              <!-- Image -->
              <v-col cols="12" xl="6" lg="6" md="12" sm="12">
                <v-card-title
                  class="
                    text-subtitle-1 text-xl-h5 text-lg-h5 text-md-h6 text-sm-h6
                    p-0
                    justify-center
                  "
                  >Logo/Image</v-card-title
                >
                <v-img
                  class="border"
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
                        <v-btn
                          v-on="data.on"
                          block
                          outlined
                          color="grey darken-1"
                          class="btn-block"
                          style="text-transform: none"
                          @click="clickupload"
                          :small="$vuetify.breakpoint.smAndDown"
                        >
                          <v-icon>mdi-upload</v-icon> Upload Image
                        </v-btn>
                      </template>
                      <span>Choose an image</span>
                    </v-tooltip>
                  </v-col>

                  <v-col cols="12" v-if="form.attachment">
                    <v-tooltip bottom>
                      <template #activator="data">
                        <v-btn
                          v-on="data.on"
                          block
                          class="primary"
                          style="text-transform: none"
                          @click="savefile"
                          :small="$vuetify.breakpoint.smAndDown"
                        >
                          <v-icon color="white">mdi-content-save</v-icon>
                        </v-btn>
                      </template>
                      <span>Save Logo/Image</span>
                    </v-tooltip>
                  </v-col>
                </v-row>
                <input
                  ref="uploader"
                  clearable
                  accept="image/*"
                  class="d-none"
                  type="file"
                  @change="uploaddocument"
                />
                <div class="pt-2" v-if="form.attachment">
                  Image Attachment:
                  <v-row no-gutters justify="center" align="center">
                    <v-col cols="10">
                      <a :href="temppath" download>
                        {{ tempfile }}
                      </a>
                    </v-col>

                    <v-col cols="2" class="text-center">
                      <v-tooltip bottom>
                        <template #activator="data">
                          <v-icon
                            large
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
              </v-col>

              <!-- VAT -->
              <v-col cols="12" xl="6" lg="6" md="12" sm="12">
                <v-card-title
                  class="
                    text-subtitle-1 text-xl-h5 text-lg-h5 text-md-h6 text-sm-h6
                    p-0
                    justify-center
                  "
                  >VAT</v-card-title
                >
                <v-row no-gutters>
                  <v-col cols="12" xl="6" lg="6" md="6" sm="6" class="py-1">
                    <v-row no-gutters>
                      <v-col cols="10">
                        <v-text-field
                          :rules="formRulesSVAT"
                          v-model="form1.vat"
                          label="Supplies VAT"
                          dense
                          outlined
                          persistent-placeholder
                          clearable
                          counter
                          @keydown="VATKeydown($event)"
                          maxlength="6"
                          @blur="resetSV"
                          @focus="clearSV"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="2" class="text-center">
                        <v-tooltip bottom>
                          <template #activator="data">
                            <v-icon
                              v-on="data.on"
                              x-large
                              color="primary"
                              @click="saveVat('s')"
                              :large="$vuetify.breakpoint.smAndDown"
                              >mdi-content-save</v-icon
                            >
                          </template>
                          <span>Save</span>
                        </v-tooltip>
                      </v-col>
                    </v-row>
                  </v-col>
                  <v-col cols="12" xl="6" lg="6" md="6" sm="6" class="py-1">
                    <v-row no-gutters>
                      <v-col cols="10">
                        <v-text-field
                          :rules="formRulesPVAT"
                          v-model="form2.vat"
                          label="Products VAT"
                          dense
                          outlined
                          clearable
                          persistent-placeholder
                          counter
                          @keydown="VATKeydown($event)"
                          maxlength="6"
                          @blur="resetPV"
                          @focus="clearPV"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="2" class="text-center">
                        <v-tooltip bottom>
                          <template #activator="data">
                            <v-icon
                              v-on="data.on"
                              x-large
                              color="primary"
                              @click="saveVat('p')"
                              :large="$vuetify.breakpoint.smAndDown"
                              >mdi-content-save</v-icon
                            >
                          </template>
                          <span>Save</span>
                        </v-tooltip>
                      </v-col>
                    </v-row>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
          </v-container>
        </v-container>
      </v-card>
    </v-form>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import axios from "axios";
export default {
  middleware: "auth",
  metaInfo() {
    return { title: "Settings" };
  },
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
  },
  data: () => ({
    tempfile: "",
    tab: null,
    temppath: "/img/Logo.jpg",
    isSelecting: false,
    progressBar: false,
    snackbar: {
      active: false,
      message: "",
    },
    form: { attachment: "" },
    form1: { vat: 0, type: "" },
    form2: { vat: 0, type: "" },

    // Form Rules
    formRulesSVAT: [
      (v) => !!v || "This is required",
      (v) => /^[0-9]\d{0,7}(?:\.\d{1,4})?$/.test(v) || "VAT must be valid",
    ],
    formRulesPVAT: [
      (v) => !!v || "This is required",
      (v) => /^[0-9]\d{0,7}(?:\.\d{1,4})?$/.test(v) || "VAT must be valid",
    ],
  }),
  created() {
    this.getLogo();
    this.getVat("s");
    this.getVat("p");
  },

  methods: {
    VATKeydown(e) {
      if (/[\s~`!@#$%^&()_={}[\]\\"*|:;,<>+'\/?-]/.test(e.key)) {
        e.preventDefault();
      }
    },

    clearSV() {
      if (this.form1.vat == 0) {
        this.form1.vat = null;
      }
    },

    resetSV() {
      if (this.form1.vat == null) {
        if (this.form1.vat) {
          this.form1 = this.getVat("s");
        } else {
          this.form1.vat = 0;
          this.$refs.mainForm.resetValidation();
        }
      }
    },

    clearPV() {
      if (this.form2.vat == 0) {
        this.form2.vat = null;
      }
    },

    resetPV() {
      if (this.form2.vat == null) {
        if (this.form2.vat) {
          this.form2 = this.getVat("p");
        } else {
          this.form2.vat = 0;
          this.$refs.mainForm.resetValidation();
        }
      }
    },

    async deletefile() {
      this.progressBar = true;
      this.$refs.uploader.value = null;
      this.form.attachment = null;
      this.temppath = "/img/Logo.jpg";
      this.tempfile = null;
      await axios.post("/api/settings/company/logo/delete").then((result) => {
        this.progressBar = false;
        this.snackbar = {
          active: true,
          iconText: "check",
          iconColor: "success",
          message: "Successfully removed.",
        };
      });
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
    async uploaddocument(e) {
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
    },
    async savefile(e) {
      await axios
        .post("/api/settings/company/logo/store", this.form)
        .then((result) => {
          this.snackbar = {
            active: true,
            iconText: "check",
            iconColor: "success",
            message: "Successfully saved.",
          };
        });
    },

    async getLogo() {
      await axios.get("/api/settings/company/logo/get").then((result) => {
        this.form.attachment = result.data.tempfile;
        this.tempfile = result.data.filename;
        this.temppath = result.data.path ?? "/img/Logo.jpg";
      });
    },

    async saveVat(type) {
      type == "s" ? (this.form1.type = type) : (this.form2.type = type);
      if (this.$refs.mainForm.validate()) {
        await axios
          .post(
            "/api/settings/vat/store",
            type == "s" ? this.form1 : this.form2
          )
          .then((result) => {
            switch (result.data) {
              case 1:
                this.snackbar = {
                  active: true,
                  iconText: "check",
                  iconColor: "success",
                  message: "Successfully saved.",
                };
                break;
              case 0:
                this.snackbar = {
                  active: true,
                  iconText: "alert-box",
                  iconColor: "warning",
                  message: "No changes has been made.",
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
    },

    async getVat(type) {
      await axios
        .get("/api/settings/vat/get", { params: { type: type } })
        .then((result) => {
          switch (result.data.type) {
            case "s":
              this.form1 = result.data;
              break;
            case "p":
              this.form2 = result.data;
              break;
            default:
              break;
          }
        });
    },
  },
};
</script>