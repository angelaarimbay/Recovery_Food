<template>
  <div>
    <v-container v-if="token == ''">
      <v-overlay :value="overlay">
        <v-progress-circular size="64"></v-progress-circular>
      </v-overlay>
      <v-row v-if="user">
        <v-col xl="6" cols="12" class="m-auto">
          <v-card-text
            style="background-color: grey"
            min-height=""
            min-width=""
          >
            <v-form
              ref="form"
              @submit.prevent="login"
              @keydown="form.onKeydown($event)"
            >
              <v-card-text>
                <v-row>
                  <v-col cols="12" class="text-center">
                    <h3>Log In</h3>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col cols="12" sm="12">
                    <v-text-field
                      :rules="rules.formRules"
                      hide-details="auto"
                      label="Username"
                      outlined
                      dense
                      persistent-placeholder
                      v-model="form.email"
                      :error-messages="
                        form.errors.has('email')
                          ? form.errors.errors.email[0]
                          : ''
                      "
                      style="background-color: white"
                    ></v-text-field>
                  </v-col>

                  <v-col cols="12" sm="12">
                    <v-text-field
                      label="Password"
                      outlined
                      persistent-placeholder
                      :rules="rules.passwordRules"
                      hide-details="auto"
                      dense
                      v-model="form.password"
                      :error-messages="
                        form.errors.has('password')
                          ? form.errors.errors.password[0]
                          : ''
                      "
                      :append-icon="!value ? 'mdi-eye' : 'mdi-eye-off'"
                      @click:append="() => (value = !value)"
                      :type="!value ? 'password' : 'text'"
                      style="background-color: white"
                    ></v-text-field>
                  </v-col>
                </v-row>

                <v-row>
                  <v-col cols="12">
                    <v-btn
                      type="submit"
                      dark
                      block
                      color="red darken-2"
                      :loading="form.busy"
                      @click="login"
                      >Log In</v-btn
                    >
                  </v-col>
                </v-row>
              </v-card-text>
            </v-form>
          </v-card-text>
        </v-col>
        <v-col xl="6" cols="12">
          <v-img src="/img/Logo.jpg"></v-img>
        </v-col>
      </v-row>
    </v-container>
    <v-snackbar
      bottom
      right
      v-model="snackbar.status"
      :color="snackbar.color + ' lighten-2'"
      class="text-center"
      >{{ snackbar.message }}</v-snackbar
    >
  </div>
</template>

<script>
import Form from "vform";
import axios from "axios";
export default {
  middleware: "guest",

  metaInfo() {
    return { title: "login" };
  },
  data: () => ({
    user: true,
    drawer: null,
    appName: window.config.appName,
    notif: 1,
    overlay: false,
    snackbar: { status: false, message: "", color: "" },
    token: "",
    value: false,
    rules: {
      formRules: [(v) => !!v || "This is required"],
      passwordRules: [
        (v) => !!v || "This is required",
        (v) => (v && v.length <= 10) || "Password must be 10 characters",
      ],
    },
    form: new Form({
      email: "",
      password: "",
    }),
    remember: false,
  }),

  methods: {
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
              .then((result) => {
                this.snackbar.status = true;
                this.snackbar.color = "primary";
                this.snackbar.message = "Login Successfully";
                this.overlay = false;
                this.$store.dispatch("auth/fetchUser");
                // this.$store.dispatch('auth/fetchUserPermissions')
                // this.$store.dispatch('auth/fetchUserRoles')
                this.$router.push({ name: "dashboard" });
              });
          })
          .catch((result) => {
            console.log(result);
            this.overlay = false;
            this.snackbar.status = true;
            this.snackbar.color = "red";
            this.snackbar.message = "Invalid Email/Password, Please try again.";
          });
      }
    },
  },
};
</script>