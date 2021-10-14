<template>
  <div style="min-width: 280px">
    <v-container>
      <v-layout row wrap>
        <h4
          class="font-weight-bold heading my-auto"
          :class="{ h5: $vuetify.breakpoint.smAndDown }"
        >
          Inventory
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
            >Inventory Summary</v-btn
          >
        </v-card-actions>
      </v-layout>
    </v-container>

    <!-- Main Card -->
    <v-card elevation="6" class="mt-2" style="border-radius: 10px">
      <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
        <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
          <!-- Date Picker -->
          <v-row no-gutters>
            <v-col cols="5" xl="3" lg="3" md="4" sm="6" class="my-auto">
              <v-card-actions class="py-0">
                <v-menu
                  v-model="date1"
                  :close-on-content-click="false"
                  :nudge-right="35"
                  lazy
                  transition="scale-transition"
                  offset-y
                  full-width
                  min-width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      v-model="dateFrom"
                      label="Date From"
                      prepend-icon="mdi-calendar-range"
                      readonly
                      v-on="on"
                      hide-details=""
                      dense
                      clearable
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="dateFrom"
                    @input="date1 = false"
                    scrollable
                    no-title
                    color="red darken-2"
                    dark
                  ></v-date-picker>
                </v-menu>
              </v-card-actions>
            </v-col>

            <!-- Date Picker -->
            <v-col cols="6" xl="4" lg="4" md="5" sm="7" class="my-auto">
              <v-card-actions class="py-0">
                <v-menu
                  v-model="date2"
                  :close-on-content-click="false"
                  :nudge-right="35"
                  lazy
                  transition="scale-transition"
                  offset-y
                  full-width
                  min-width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      v-model="dateUntil"
                      label="Date Until"
                      prepend-icon="mdi-calendar-range"
                      readonly
                      v-on="on"
                      hide-details=""
                      dense
                      clearable
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="dateUntil"
                    @input="date2 = false"
                    scrollable
                    no-title
                    color="red darken-2"
                    dark
                  ></v-date-picker>
                </v-menu>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="red darken-2"
                      icon
                      v-on="data.on"
                      @click="get"
                      :small="$vuetify.breakpoint.smAndDown"
                      :large="$vuetify.breakpoint.mdAndUp"
                      ><v-icon>mdi-magnify</v-icon></v-btn
                    >
                  </template>
                  <span>Search</span>
                </v-tooltip>
              </v-card-actions>
            </v-col>
          </v-row>

          <!-- Table -->
          <v-data-table
            :headers="headers"
            :items="table"
            :loading="progressbar"
            hide-default-footer
            ref="progress"
          >
            <!-- Progress Bar -->
            <v-progress-linear
              color="red darken-2"
              class="px-0 mx-0"
              slot="progress"
              indeterminate
              rounded
            ></v-progress-linear>
          </v-data-table>
        </v-container>
      </v-container>
    </v-card>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import axios from "axios"; // Library for sending api request
export default {
  middleware: "auth",
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
  },
  data: () => ({
    progressbar: false,
    table: [],
    headers: [
      {
        text: "SUPPLIES CATEGORY",
        value: "category",
        align: "start",
        filterable: false,
        class: "black--text",
      },
      {
        text: "INCOMING SUPPLIES",
        value: "incoming",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "OUTGOING SUPPLIES",
        value: "outgoing",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "STOCKS ON HAND",
        value: "stocks",
        align: "right",
        filterable: false,
        class: "black--text",
      },
    ],
    dateFrom: null,
    dateUntil: null,
    incomingDate: null,
    date1: false,
    date2: false,
  }),

  //On Load
  created() {
    if (this.user.permissionslist.includes("Access Inventory")) {
    } else {
      this.$router.push({ name: "invalid-page" }).catch((errr) => {});
    }
  },

  methods: {
    async get() {
      this.progressbar = true;
      await axios
        .get("/api/invsumm/get", {
          params: { from: this.dateFrom, to: this.dateUntil },
        })
        .then((result) => {
          this.table = result.data;
          this.progressbar = false;
        });
    },
  },
};
</script>