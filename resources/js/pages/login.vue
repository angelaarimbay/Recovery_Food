<template>
  <div>
    <v-row>
      <v-col xl="6" cols="12" class="m-auto">
        <v-card-text
          style="background-color: grey"
          min-height=""
          min-width="" 
        >
          <v-form>
            <v-card-text>
              <v-row>
                <v-col cols="12" class="text-center">
                  <h3>Log In</h3>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" sm="12">
                  <v-text-field
                    label="Username"
                    outlined
                    hide-details="auto"
                    dense
                    style="background-color: white"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" sm="12">
                  <v-text-field
                    label="Password"
                    outlined
                    hide-details="auto"
                    dense
                    :append-icon="!value ? 'mdi-eye' : 'mdi-eye-off'"
                    @click:append="() => (value = !value)"
                    :type="!value ? 'password' : 'text'"
                    style="background-color: white"
                  ></v-text-field>
                </v-col>
              </v-row>

              <v-row>
                <v-col cols="12">
                  <v-btn dark block color="red darken-2">Log In</v-btn>
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
  </div>
</template>

<script>
export default {
  data: () => ({
    value: true,
  }),
};
</script>