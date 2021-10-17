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
              >Roles/Permissions</v-btn
            >
          </v-card-actions>
        </v-layout>
      </v-container>

      <!-- Main Card -->
      <v-card
        elevation="6"
        class="mt-2 p-4"
        style="border-radius: 10px"
        height="400"
      >
        <v-tabs
          slider-size="4"
          v-model="tab"
          color="red darken-2"
          show-arrows
          center-active
          centered
        >
          <v-tabs-slider style="display: none"></v-tabs-slider>
          <v-tab
            :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
            style="text-transform: none"
          >
            Company
          </v-tab>
          <v-tab
            :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
            style="text-transform: none"
          >
            Vat
          </v-tab>
        </v-tabs>

        <v-tabs-items v-model="tab">
          <v-tab-item>
            <span>Company Logo</span>
            <v-row>
              <v-col cols="3">
                <v-img
                  class="border"
                  contain
                  :src="temppath"
                  width="100%"
                  height="203"
                ></v-img>
                <v-progress-linear
                  v-show="progressBar"
                  color="green"
                  indeterminate
                ></v-progress-linear>
                <v-card-actions>
                  <v-btn
                    text
                    small
                    dark
                    class="info"
                    style="text-transform: none"
                    @click="clickupload"
                  >
                    <v-icon>mdi-camera</v-icon>
                  </v-btn>
                  <v-btn
                    text
                    small
                    dark
                    class="danger d-none"
                    style="text-transform: none"
                    @click="deletefile"
                  >
                    <v-icon>mdi-close</v-icon>
                  </v-btn>
                  <v-btn
                    text
                    small
                    dark
                    class="success"
                    style="text-transform: none"
                    @click="savefile"
                  >
                    <v-icon>mdi-content-save</v-icon>
                  </v-btn>
                </v-card-actions>
                <input
                  ref="uploader"
                  clearable="true"
                  class="d-none"
                  type="file"
                  @change="uploaddocument"
                />
              </v-col>
            </v-row>
            <div v-if="form.attachment">
              Uploaded file :
              <a :href="temppath" download>
                {{ tempfile }}
              </a>
            </div>
          </v-tab-item>
          <v-tab-item>
            <v-card-text>
              <v-row>
                <v-col xl="4" cols="12">
                  <v-card-actions>
                    <v-text-field
                      v-model="form1.vat"
                      label="Supplies Vat"
                      hide-details=""
                      dense
                      outlined
                    ></v-text-field>
                    <v-icon color="info" @click="saveVat('s')" size="40"
                      >mdi-content-save</v-icon
                    >
                  </v-card-actions>
                </v-col>
              </v-row>
              <v-row>
                <v-col xl="4" cols="12">
                  <v-card-actions>
                    <v-text-field
                      v-model="form2.vat"
                      label="Products Vat"
                      dense
                      hide-details=""
                      outlined
                    ></v-text-field>
                    <v-icon color="info" @click="saveVat('p')" size="40"
                      >mdi-content-save</v-icon
                    >
                  </v-card-actions>
                </v-col>
              </v-row>
            </v-card-text>
          </v-tab-item>
        </v-tabs-items>
      </v-card>
    </v-form>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    tempfile: "",
    tab: null,
    temppath: "",
    isSelecting: false,
    progressBar: false,
    snackbar: {
      active: false,
      message: "",
    },
    form: { attachment: "" },
    form1: { vat: "", type: "" },
    form2: { vat: "", type: "" },
  }),
  created() {
    this.getLogo();
    this.getVat("s");
    this.getVat("p");
  },

  methods: {
    deletefile() {
      this.$refs.uploader.value = null;
      this.form.attachment = null;
      this.temppath = null;
      this.tempfile = null;
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
          this.temppath = result.data.path;
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
        this.temppath = result.data.path;
      });
    },

    async saveVat(type) {
      type == "s" ? (this.form1.type = type) : (this.form2.type = type);
      await axios
        .post(
          "/api/settings/vat/store",
          type == "s" ? this.form1 : this.form2
        )
        .then((result) => {
          this.snackbar = {
            active: true,
            iconText: "check",
            iconColor: "success",
            message: "Successfully saved.",
          };
        });
    },

    async getVat(type) {
         
      await axios
        .get("/api/settings/vat/get", { params: { type: type } })
        .then((result) => {
            console.log(result.data)
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