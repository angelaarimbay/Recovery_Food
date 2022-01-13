<template>
  <!-- Div -->
  <div style="min-width: 310px">
    <v-container v-if="token == ''">
      <!-- Progress Circular -->
      <v-overlay :value="overlay">
        <v-progress-circular
          size="55"
          color="red darken-2"
          indeterminate
        ></v-progress-circular>
      </v-overlay>
      <v-row v-if="user" align="center">
        <v-col cols="12">
          <v-card outlined class="mt-2" style="border-radius: 10px">
            <v-tabs
              v-model="tab"
              grow
              slider-size="4"
              color="red darken-2"
              :centered="$vuetify.breakpoint.xsOnly"
              :height="height"
              class="pa-2"
            >
              <v-tabs-slider
                style="border-radius: 20px 20px 0px 0px"
              ></v-tabs-slider>
              <v-tab
                class="
                  text-caption
                  text-xl-subtitle-1
                  text-lg-subtitle-1
                  text-md-subtitle-2
                  text-sm-body-1
                "
                style="text-transform: none"
                >Log In</v-tab
              >
              <v-tab
                class="
                  text-caption
                  text-xl-subtitle-1
                  text-lg-subtitle-1
                  text-md-subtitle-2
                  text-sm-body-1
                "
                style="text-transform: none"
                >About Us</v-tab
              >
            </v-tabs>
          </v-card>

          <v-tabs-items v-model="tab" id="custom-tab-items">
            <!-- Log In -->
            <v-tab-item>
              <v-row no-gutters>
                <!-- Logo -->
                <v-col cols="12" xl="6" lg="6" md="6">
                  <v-img
                    contain
                    :src="logo_path"
                    class="hidden-xs-only"
                  ></v-img>
                </v-col>
                <!-- Login Form -->
                <v-col
                  cols="12"
                  xl="6"
                  lg="6"
                  md="6"
                  class="pa-0 pa-xl-15 pa-lg-15 pa-md-10 pa-sm-5"
                >
                  <v-card
                    elevation="3"
                    style="border-radius: 10px"
                    class="d-flex align-center justify-center"
                    max-width="500px"
                  >
                    <v-form ref="form" @submit.prevent="submitHandler">
                      <v-card-text class="pa-4 pa-xl-7 pa-lg-7 pa-md-5 pa-sm-5">
                        <v-row>
                          <v-col cols="12" class="text-center">
                            <span
                              class="
                                text-h6
                                text-xl-h4
                                text-lg-h4
                                text-md-h5
                                text-sm-h5
                                font-weight-bold
                              "
                              style="color: #616161"
                            >
                              Welcome
                            </span>
                          </v-col>
                        </v-row>
                        <v-row>
                          <!-- Email Field -->
                          <v-col cols="12" md="12" class="py-0" id="email">
                            <v-text-field
                              :rules="formRulesEmail"
                              label="Email"
                              :dense="$vuetify.breakpoint.smAndDown"
                              clearable
                              v-model="form.email"
                              :error-messages="
                                form.errors.has('email')
                                  ? form.errors.errors.email[0]
                                  : ''
                              "
                              prepend-inner-icon="mdi-email"
                              background-color="white"
                              flat
                              solo
                              autocomplete="on"
                            ></v-text-field>
                          </v-col>
                          <!-- Password Field -->
                          <v-col cols="12" sm="12" class="py-0" id="password">
                            <v-text-field
                              :rules="passwordRules"
                              label="Password"
                              :dense="$vuetify.breakpoint.smAndDown"
                              clearable
                              v-model="form.password"
                              :error-messages="
                                form.errors.has('password')
                                  ? form.errors.errors.password[0]
                                  : ''
                              "
                              :append-icon="!value ? 'mdi-eye' : 'mdi-eye-off'"
                              @click:append="() => (value = !value)"
                              :type="!value ? 'password' : 'text'"
                              prepend-inner-icon="mdi-key"
                              background-color="white"
                              flat
                              solo
                            ></v-text-field>
                          </v-col>
                        </v-row>
                        <!-- Login Button -->
                        <v-row class="mt-0">
                          <v-col cols="12">
                            <v-btn
                              :large="$vuetify.breakpoint.mdAndUp"
                              type="submit"
                              dark
                              block
                              color="red darken-2"
                              class="
                                text-subtitle-1
                                text-xl-h5
                                text-lg-h5
                                text-md-h6
                                text-sm-h6
                              "
                              @click="login"
                              style="text-transform: none"
                              >Log In</v-btn
                            >
                          </v-col>
                        </v-row>
                      </v-card-text>
                    </v-form>
                  </v-card>
                </v-col>
              </v-row>
            </v-tab-item>

            <!-- About Us -->
            <v-tab-item>
              <v-card outlined class="mt-2 pa-4" style="border-radius: 10px">
                <v-row no-gutters>
                  <v-col cols="12" xl="6" lg="6" md="6" sm="12">
                    <v-card-title
                      class="
                        text-subtitle-1
                        text-xl-h5
                        text-lg-h5
                        text-md-h6
                        text-sm-h6
                        justify-center
                      "
                      style="color: #c62828"
                    >
                      Mission
                    </v-card-title>
                    <v-card-text id="subtext">
                      {{ this.mission }}
                    </v-card-text>
                  </v-col>
                  <v-col cols="12" xl="6" lg="6" md="6" sm="12">
                    <v-card-title
                      class="
                        text-subtitle-1
                        text-xl-h5
                        text-lg-h5
                        text-md-h6
                        text-sm-h6
                        justify-center
                      "
                      style="color: #c62828"
                    >
                      Vision
                    </v-card-title>
                    <v-card-text id="subtext">
                      {{ this.vision }}
                    </v-card-text>
                  </v-col>
                  <v-col cols="12">
                    <v-card-title
                      class="
                        text-subtitle-1
                        text-xl-h5
                        text-lg-h5
                        text-md-h6
                        text-sm-h6
                        justify-center
                      "
                      style="color: #c62828"
                    >
                      History
                    </v-card-title>
                    <v-card-text id="subtext">
                      {{ this.history }}
                    </v-card-text>
                  </v-col>
                </v-row>
              </v-card>
            </v-tab-item>
          </v-tabs-items>
        </v-col>
      </v-row>
    </v-container>
    <!-- Snackbar -->
    <v-snackbar
      bottom
      v-model="snackbar.status"
      min-width="auto"
      class="text-center pb-0"
      :vertical="$vuetify.breakpoint.xsOnly"
      timeout="2500"
      :left="$vuetify.breakpoint.smAndUp"
      ><span
        ><v-icon :color="snackbar.iconColor">{{
          `mdi-${snackbar.iconText}`
        }}</v-icon></span
      >{{ snackbar.message
      }}<template v-slot:action="{ attrs }">
        <v-btn
          :small="$vuetify.breakpoint.smAndDown"
          v-bind="attrs"
          color="primary"
          text
          @click="snackbar.active = false"
          >Close</v-btn
        >
      </template></v-snackbar
    >
  </div>
</template>

<!-- Style -->
<style>
#custom-tab-items {
  background-color: transparent !important;
}

#subtext {
  text-align: justify;
}

.container {
  max-width: 1150px !important;
}

.v-application #email .white,
.v-application #password .white {
  border: 1px solid #bdbdbd !important;
}
#email .v-input--is-focused .v-input__slot,
#password .v-input--is-focused .v-input__slot {
  border: 1px solid #42a5f5 !important;
}
</style>

<!-- Script -->
<script>
import Form from "vform";
import axios from "axios";
export default {
  middleware: "guest",
  metaInfo() {
    return { title: "Log In" };
  },
  computed: {
    height() {
      if (this.$vuetify.breakpoint.smAndDown) {
        return 35;
      }
    },
  },
  //Data
  data: () => ({
    tab: null,
    user: true,
    mission: null,
    vision: null,
    history: null,
    appName: window.config.appName,
    notif: 1,
    overlay: false,
    snackbar: { status: false, message: "" },
    token: "",
    value: false,
    logo_path: "/img/Logo_NO_BG.png",
    form: new Form({
      email: "",
      password: "",
    }),
    remember: false,

    //Form Rules
    formRulesEmail: [],
    passwordRules: [],
  }),

  //Onload
  created() {
    this.getLogo();
    this.getAbout();
  },

  //Watch
  watch: {
    "form.email"(val) {
      this.formRulesEmail = [];
    },
    "form.password"(val) {
      this.passwordRules = [];
    },
  },

  //Methods
  methods: {
    reloadPage() {
      window.location.reload();
    },

    //For submithandler
    submitHandler() {
      (this.formRulesEmail = [
        (v) => !!v || "This is required",
        (v) =>
          /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
          "E-mail must be valid",
      ]),
        (this.passwordRules = [(v) => !!v || "This is required"]);
    },

    //For retrieving logo
    async getLogo() {
      await axios.get("/api/settings/company/logo/get").then((result) => {
        if (result.data.path) {
          this.logo_path = result.data.path;
        }
      });
    },

    //For retrieving Mission, Vision, History
    async getAbout() {
      await axios.get("/api/settings/company/get").then((result) => {
        if (result.data) {
          this.mission = result.data.mission;
          this.vision = result.data.vision;
          this.history = result.data.history;
        }
      });
    },

    //For logging in
    async login() {
      if (this.$refs.form.validate()) {
        this.overlay = true;
        //Submit the form.
        await axios
          .post("/api/login", this.form)
          .then((result) => {
            //Save the token.
            this.user = false;
            this.$store
              .dispatch("auth/saveToken", {
                token: result.data.token,
                remember: this.remember,
              })
              .then((res) => {
                this.snackbar.status = true;
                this.snackbar.iconText = "check";
                this.snackbar.iconColor = "primary";
                this.snackbar.message = "Login Successful.";
                this.$store.dispatch("auth/fetchUser");
                this.$store.dispatch("auth/fetchUserPermissions");
                this.$store.dispatch("auth/fetchUserRoles");
                this.$router.push({ name: "dashboard" }).catch((errr) => {});
                this.reloadPage();
              });
          })
          .catch((result) => {
            this.overlay = false;
            this.snackbar.status = true;
            this.snackbar.iconText = "alert";
            this.snackbar.iconColor = "error";
            this.snackbar.message = "Invalid Email or Password.";
          });
      }
    },
  },
};
</script>