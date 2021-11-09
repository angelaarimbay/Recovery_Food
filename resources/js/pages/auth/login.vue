<template>
  <div style="min-width: 280px">
    <v-container v-if="token == ''">
      <v-overlay :value="overlay">
        <v-progress-circular
          size="55"
          color="red darken-2"
          indeterminate
        ></v-progress-circular>
      </v-overlay>
      <v-row v-if="user" align="center">
        <v-col cols="12" xl="6" lg="6" md="6">
          <v-img contain :src="logo_path" class="hidden-xs-only"></v-img>
        </v-col>
        <v-col
          cols="12"
          xl="6"
          lg="6"
          md="6"
          class="pa-0 pa-xl-15 pa-lg-15 pa-md-10 pa-sm-5"
        >
          <v-card
            elevation="6"
            style="border-radius: 10px"
            class="d-flex align-center justify-center"
          >
            <v-form ref="form" @submit.prevent="submitHandler">
              <v-card-text class="pa-4 pa-xl-7 pa-lg-7 pa-md-5 pa-sm-5">
                <v-row>
                  <v-col cols="12" class="text-center">
                    <span
                      class="
                        text-h6 text-xl-h4 text-lg-h4 text-md-h5 text-sm-h5
                        font-weight-bold
                      "
                      style="color: #616161"
                    >
                      Welcome
                    </span>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col cols="12" md="12" class="py-1">
                    <v-text-field
                      :rules="formRulesEmail"
                      label="Email"
                      outlined
                      dense
                      clearable
                      persistent-placeholder
                      v-model="form.email"
                      :error-messages="
                        form.errors.has('email')
                          ? form.errors.errors.email[0]
                          : ''
                      "
                      prepend-icon="mdi-email"
                    ></v-text-field>
                  </v-col>

                  <v-col cols="12" sm="12" class="py-1">
                    <v-text-field
                      label="Password"
                      outlined
                      persistent-placeholder
                      :rules="passwordRules"
                      dense
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
                      prepend-icon="mdi-key"
                    ></v-text-field>
                  </v-col>
                </v-row>

                <v-row>
                  <v-col cols="12">
                    <v-btn
                      type="submit"
                      dark
                      block
                      large
                      color="red darken-2"
                      class="
                        text-subtitle-1
                        text-xl-h5
                        text-lg-h5
                        text-md-h6
                        text-sm-h6
                      "
                      :loading="form.busy"
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
    </v-container>
    <v-snackbar
      bottom
      v-model="snackbar.status"
      min-width="auto"
      class="text-center"
      :vertical="$vuetify.breakpoint.xsOnly"
      timeout="2500"
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

<script>
import Form from "vform";
import axios from "axios";
export default {
  middleware: "guest",
  metaInfo() {
    return { title: "Log In" };
  },
  data: () => ({
    user: true,
    drawer: null,
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
    formRulesEmail: [],
    passwordRules: [],
  }),
  created() {
    this.getLogo();
  },

  watch: {
    "form.email"(val) {
      this.formRulesEmail = [];
    },
    "form.password"(val) {
      this.passwordRules = [];
    },
  },

  methods: {
    submitHandler() {
      (this.formRulesEmail = [
        (v) => !!v || "This is required",
        (v) =>
          /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
          "E-mail must be valid",
      ]),
        (this.passwordRules = [(v) => !!v || "This is required"]);
      this.login();
    },
    async getLogo() {
      await axios.get("/api/settings/company/logo/get").then((result) => {
        if (result.data.path) {
          this.logo_path = result.data.path;
        }
      });
    },

    async login() {
      if (this.$refs.form.validate()) {
        this.overlay = true;
        // Submit the form.
        await axios
          .post("/api/login", this.form)
          .then((result) => {
            // Save the token.
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