<template>
  <!-- Div -->
  <div
    style="min-width: 310px"
    v-if="!user.permissionslist.includes('Access POS')"
  >
    <v-container class="pt-2">
      <v-layout row wrap>
        <span
          class="
            text-h6 text-xl-h5 text-lg-h5 text-md-h6 text-sm-h6
            font-weight-bold
            my-auto
          "
        >
          Dashboard
        </span>
        <v-spacer></v-spacer>

        <!-- Cards Settings -->
        <v-tooltip bottom>
          <template #activator="data">
            <v-btn
              :small="$vuetify.breakpoint.xsOnly"
              large
              icon
              dark
              text
              color="red darken-2"
              class="mx-1"
              v-on="data.on"
              @click="sheet = !sheet"
            >
              <v-icon>mdi-settings</v-icon>
            </v-btn>
          </template>
          <span>Manage Cards</span>
        </v-tooltip>

        <v-bottom-sheet v-model="sheet" inset width="500px">
          <v-sheet class="text-center" style="border-radius: 10px 10px 0px 0px">
            <v-btn
              color="#FF5252"
              depressed
              dark
              style="text-transform: none"
              small
              class="mt-5"
              @click="sheet = !sheet"
            >
              Close
            </v-btn>

            <!-- Cards Bottom Sheet -->
            <v-row no-gutters>
              <v-col cols="12" xl="6" lg="6" md="6" sm="6">
                <v-row
                  align="center"
                  class="mx-7 my-xl-2 my-lg-2 my-md-1 my-sm-1 my-0"
                >
                  <v-checkbox
                    v-model="checkbox1"
                    hide-details
                    color="red darken-3"
                    class="shrink mt-0 pt-0"
                  ></v-checkbox>
                  <v-card-title
                    class="h6 my-auto px-0 font-weight-bold"
                    style="color: #616161"
                    >Supplies</v-card-title
                  >
                </v-row>
              </v-col>

              <v-col cols="12" xl="6" lg="6" md="6" sm="6">
                <v-row
                  align="center"
                  class="mx-7 my-xl-2 my-lg-2 my-md-1 my-sm-1 my-0"
                >
                  <v-checkbox
                    v-model="checkbox2"
                    hide-details
                    color="red darken-3"
                    class="shrink mt-0 pt-0"
                  ></v-checkbox>
                  <v-card-title
                    class="h6 my-auto px-0 font-weight-bold"
                    style="color: #616161"
                    >Products</v-card-title
                  >
                </v-row>
              </v-col>

              <v-col cols="12" xl="6" lg="6" md="6" sm="6">
                <v-row
                  align="center"
                  class="mx-7 my-xl-2 my-lg-2 my-md-1 my-sm-1 my-0"
                >
                  <v-checkbox
                    v-model="checkbox3"
                    hide-details
                    color="red darken-3"
                    class="shrink mt-0 pt-0"
                  ></v-checkbox>
                  <v-card-title
                    class="h6 my-auto px-0 font-weight-bold"
                    style="color: #616161"
                    >Purchase Orders</v-card-title
                  >
                </v-row>
              </v-col>

              <v-col cols="12" xl="6" lg="6" md="6" sm="6">
                <v-row
                  align="center"
                  class="mx-7 my-xl-2 my-lg-2 my-md-1 my-sm-1 my-0"
                >
                  <v-checkbox
                    v-model="checkbox4"
                    hide-details
                    color="red darken-3"
                    class="shrink mt-0 pt-0"
                  ></v-checkbox>
                  <v-card-title
                    class="h6 my-auto px-0 font-weight-bold"
                    style="color: #616161"
                    >Users</v-card-title
                  >
                </v-row>
              </v-col>
            </v-row>
          </v-sheet>
        </v-bottom-sheet>
      </v-layout>
    </v-container>

    <!-- Cards -->
    <v-container class="pa-0">
      <v-row no-gutters>
        <v-col
          cols="6"
          xl="3"
          lg="3"
          md="4"
          sm="6"
          class="pa-1"
          :hidden="!hiddenCard1"
        >
          <!-- Total Supplies -->
          <v-card
            elevation="2"
            style="border-radius: 10px; border-left: 10px solid #d32f2f"
            class="pa-0"
            height="100"
          >
            <v-card-title
              style="color: #d32f2f"
              class="pt-2 caption"
              :class="{ 'justify-center': $vuetify.breakpoint.xsOnly }"
              >Total Supplies</v-card-title
            >
            <v-card-subtitle
              class="h3 pb-0 mb-0"
              style="color: #000000"
              :class="{ 'text-center': $vuetify.breakpoint.xsOnly }"
              >{{ supp }}
              <v-progress-circular
                size="25"
                indeterminate
                :hidden="hidden1"
                color="red darken-2"
              ></v-progress-circular
            ></v-card-subtitle>
            <v-card-actions
              ><v-btn
                text
                small
                class="mx-auto caption"
                style="text-transform: none; text-decoration: none"
                :to="{ name: 'masterlist-supplies' }"
                >View Info<v-icon small>mdi-information-outline</v-icon></v-btn
              ></v-card-actions
            >
          </v-card>
        </v-col>

        <v-col
          cols="6"
          xl="3"
          lg="3"
          md="4"
          sm="6"
          class="pa-1"
          :hidden="!hiddenCard2"
        >
          <!-- Total Products -->
          <v-card
            elevation="2"
            style="border-radius: 10px; border-left: 10px solid #0288d1"
            class="pa-0"
            height="100"
          >
            <v-card-title
              style="color: #0288d1"
              class="pt-2 caption"
              :class="{ 'justify-center': $vuetify.breakpoint.xsOnly }"
              >Total Products</v-card-title
            >
            <v-card-subtitle
              class="h3 pb-0 mb-0"
              style="color: #000000"
              :class="{ 'text-center': $vuetify.breakpoint.xsOnly }"
              >{{ prod }}
              <v-progress-circular
                size="25"
                indeterminate
                :hidden="hidden2"
                color="red darken-2"
              ></v-progress-circular
            ></v-card-subtitle>
            <v-card-actions
              ><v-btn
                text
                small
                class="mx-auto caption"
                style="text-transform: none; text-decoration: none"
                :to="{ name: 'masterlist-products' }"
                >View Info<v-icon small>mdi-information-outline</v-icon></v-btn
              ></v-card-actions
            >
          </v-card>
        </v-col>

        <v-col
          cols="6"
          xl="3"
          lg="3"
          md="4"
          sm="6"
          class="pa-1"
          :hidden="!hiddenCard3"
        >
          <!-- Total Purchase Orders -->
          <v-card
            elevation="2"
            style="border-radius: 10px; border-left: 10px solid #00796b"
            class="pa-0"
            height="100"
          >
            <v-card-title
              style="color: #00796b"
              class="pt-2 caption"
              :class="{ 'justify-center': $vuetify.breakpoint.xsOnly }"
              >Total PO</v-card-title
            >
            <v-card-subtitle
              class="h3 pb-0 mb-0"
              style="color: #000000"
              :class="{ 'text-center': $vuetify.breakpoint.xsOnly }"
              >{{ po }}
              <v-progress-circular
                size="25"
                indeterminate
                :hidden="hidden3"
                color="red darken-2"
              ></v-progress-circular
            ></v-card-subtitle>
            <v-card-actions
              ><v-btn
                text
                small
                class="mx-auto caption"
                style="text-transform: none; text-decoration: none"
                :to="{ name: 'purchase-orders' }"
                >View Info<v-icon small>mdi-information-outline</v-icon></v-btn
              ></v-card-actions
            >
          </v-card>
        </v-col>

        <v-col
          cols="6"
          xl="3"
          lg="3"
          md="4"
          sm="6"
          class="pa-1"
          :hidden="!hiddenCard4"
        >
          <!-- Total Users -->
          <v-card
            elevation="2"
            style="border-radius: 10px; border-left: 10px solid #f57c00"
            class="pa-0"
            height="100"
          >
            <v-card-title
              style="color: #f57c00"
              class="pt-2 caption"
              :class="{ 'justify-center': $vuetify.breakpoint.xsOnly }"
              >Total Users</v-card-title
            >
            <v-card-subtitle
              class="h3 pb-0 mb-0"
              style="color: #000000"
              :class="{ 'text-center': $vuetify.breakpoint.xsOnly }"
              >{{ useracc }}
              <v-progress-circular
                size="25"
                indeterminate
                :hidden="hidden4"
                color="red darken-2"
              ></v-progress-circular
            ></v-card-subtitle>
            <v-card-actions
              ><v-btn
                text
                small
                class="mx-auto caption"
                style="text-transform: none; text-decoration: none"
                :to="{ name: 'user-accounts' }"
                >View Info<v-icon small>mdi-information-outline</v-icon></v-btn
              ></v-card-actions
            >
          </v-card>
        </v-col>
      </v-row>

      <!-- Divider -->
      <v-divider></v-divider>

      <!-- Expired Products -->
      <v-row no-gutters>
        <v-col cols="12" xl="6" lg="6" md="6" sm="12" class="pa-1">
          <v-card
            class="d-flex align-center justify-center"
            elevation="2"
            style="border-radius: 10px"
            min-height="80px"
          >
            <v-row no-gutters>
              <!-- Nearly Expired -->
              <v-col cols="6" xl="6" lg="6" md="6" sm="6" class="pa-0">
                <v-row no-gutters align="center">
                  <v-col cols="12" xl="6" lg="12" md="12" sm="12">
                    <v-card-title
                      :class="{
                        'justify-center': $vuetify.breakpoint.mdAndDown,
                      }"
                      class="
                        text-body-2
                        text-xl-subtitle-1
                        text-lg-subtitle-1
                        text-md-subtitle-2
                        text-sm-body-2
                        pl-2 pl-xl-4 pl-lg-4 pl-md-4 pl-sm-2
                        pt-1
                        pb-0
                        pr-2
                      "
                      style="color: #d32f2f"
                    >
                      Nearly Expired
                    </v-card-title>
                  </v-col>
                  <v-col cols="12" xl="6" lg="12" md="12" sm="12">
                    <v-row no-gutters>
                      <v-col cols="12">
                        <v-card-text
                          :class="{
                            'text-center': $vuetify.breakpoint.mdAndDown,
                          }"
                          class="
                            text-right
                            font-weight-bold
                            pa-1
                            text-body-2
                            text-xl-subtitle-1
                            text-lg-subtitle-1
                            text-md-subtitle-2
                            text-sm-body-2
                            pr-2 pr-xl-4 pr-lg-4 pr-md-4 pr-sm-2
                            pl-2
                          "
                        >
                          {{ suppexpdate.warning_count }}
                          <v-progress-circular
                            size="18"
                            indeterminate
                            :hidden="hidden5"
                            color="red darken-2"
                          ></v-progress-circular>
                          Supplies
                        </v-card-text>
                      </v-col>
                      <v-col cols="12">
                        <v-card-text
                          :class="{
                            'text-center': $vuetify.breakpoint.mdAndDown,
                          }"
                          class="
                            text-right
                            font-weight-bold
                            pa-1
                            text-body-2
                            text-xl-subtitle-1
                            text-lg-subtitle-1
                            text-md-subtitle-2
                            text-sm-body-2
                            pr-2 pr-xl-4 pr-lg-4 pr-md-4 pr-sm-2
                            pl-2
                          "
                        >
                          {{ prodexpdate.warning_count }}
                          <v-progress-circular
                            size="18"
                            indeterminate
                            :hidden="hidden6"
                            color="red darken-2"
                          ></v-progress-circular
                          >Products
                        </v-card-text>
                      </v-col>
                    </v-row>
                  </v-col>
                </v-row>
              </v-col>

              <!-- Divider -->
              <v-divider class="my-2" vertical></v-divider>

              <!-- Expired -->
              <v-col cols="6" xl="6" lg="6" md="6" sm="6" class="pa-0">
                <v-row no-gutters align="center">
                  <v-col cols="12" xl="6" lg="12" md="12" sm="12">
                    <v-card-title
                      :class="{
                        'justify-center': $vuetify.breakpoint.mdAndDown,
                      }"
                      class="
                        text-body-2
                        text-xl-subtitle-1
                        text-lg-subtitle-1
                        text-md-subtitle-2
                        text-sm-body-2
                        pl-2 pl-xl-4 pl-lg-4 pl-md-4 pl-sm-2
                        pt-1
                        pb-0
                        pr-2
                      "
                      style="color: #d32f2f"
                    >
                      Expired
                    </v-card-title>
                  </v-col>
                  <v-col cols="12" xl="6" lg="12" md="12" sm="12">
                    <v-row no-gutters>
                      <v-col cols="12">
                        <v-card-text
                          :class="{
                            'text-center': $vuetify.breakpoint.mdAndDown,
                          }"
                          class="
                            text-right
                            font-weight-bold
                            pa-1
                            text-body-2
                            text-xl-subtitle-1
                            text-lg-subtitle-1
                            text-md-subtitle-2
                            text-sm-body-2
                            pr-2 pr-xl-4 pr-lg-4 pr-md-4 pr-sm-2
                            pl-2
                          "
                        >
                          {{ suppexpdate.expired_count }}
                          <v-progress-circular
                            size="18"
                            indeterminate
                            :hidden="hidden5"
                            color="red darken-2"
                          ></v-progress-circular>
                          Supplies
                        </v-card-text>
                      </v-col>
                      <v-col cols="12">
                        <v-card-text
                          :class="{
                            'text-center': $vuetify.breakpoint.mdAndDown,
                          }"
                          class="
                            text-right
                            font-weight-bold
                            pa-1
                            text-body-2
                            text-xl-subtitle-1
                            text-lg-subtitle-1
                            text-md-subtitle-2
                            text-sm-body-2
                            pr-2 pr-xl-4 pr-lg-4 pr-md-4 pr-sm-2
                            pl-2
                          "
                        >
                          {{ prodexpdate.expired_count }}
                          <v-progress-circular
                            size="18"
                            indeterminate
                            :hidden="hidden6"
                            color="red darken-2"
                          ></v-progress-circular
                          >Products
                        </v-card-text>
                      </v-col>
                    </v-row>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
          </v-card>
        </v-col>

        <v-col cols="12" xl="6" lg="6" md="6" sm="12" class="pa-1">
          <v-card
            class="d-flex align-center justify-center"
            elevation="2"
            style="border-radius: 10px"
            min-height="80px"
          >
            <v-row no-gutters>
              <!-- Supplies Request -->
              <v-col cols="6" xl="6" lg="6" md="6" sm="6" class="pa-0">
                <v-row no-gutters align="center">
                  <v-col cols="12" xl="8" lg="12" md="12" sm="12">
                    <v-card-title
                      :class="{
                        'justify-center': $vuetify.breakpoint.mdAndDown,
                      }"
                      class="
                        text-body-2
                        text-xl-subtitle-1
                        text-lg-subtitle-1
                        text-md-subtitle-2
                        text-sm-body-2
                        pl-2 pl-xl-4 pl-lg-4 pl-md-4 pl-sm-2
                        pt-1
                        pb-0
                        pr-2
                      "
                      style="
                        color: #d32f2f;
                        word-break: keep-all;
                        text-align: center;
                      "
                    >
                      Supplies Request(s)
                    </v-card-title>
                  </v-col>
                  <v-col cols="12" xl="4" lg="12" md="12" sm="12">
                    <v-row no-gutters>
                      <v-col cols="12">
                        <v-card-text
                          :class="{
                            'text-center': $vuetify.breakpoint.mdAndDown,
                          }"
                          class="
                            text-right
                            font-weight-bold
                            pa-1
                            text-body-2
                            text-xl-subtitle-1
                            text-lg-subtitle-1
                            text-md-subtitle-2
                            text-sm-body-2
                            pr-2 pr-xl-4 pr-lg-4 pr-md-4 pr-sm-2
                            pl-2
                          "
                        >
                          {{ supprequest }}
                          <v-progress-circular
                            size="18"
                            indeterminate
                            :hidden="hidden7"
                            color="red darken-2"
                          ></v-progress-circular>
                        </v-card-text>
                      </v-col>
                    </v-row>
                  </v-col>
                </v-row>
              </v-col>

              <!-- Divider -->
              <v-divider class="my-2" vertical></v-divider>

              <!-- Products Request -->
              <v-col cols="6" xl="6" lg="6" md="6" sm="6" class="pa-0">
                <v-row no-gutters align="center">
                  <v-col cols="12" xl="8" lg="12" md="12" sm="12">
                    <v-card-title
                      :class="{
                        'justify-center': $vuetify.breakpoint.mdAndDown,
                      }"
                      class="
                        text-body-2
                        text-xl-subtitle-1
                        text-lg-subtitle-1
                        text-md-subtitle-2
                        text-sm-body-2
                        pl-2 pl-xl-4 pl-lg-4 pl-md-4 pl-sm-2
                        pt-1
                        pb-0
                        pr-2
                      "
                      style="
                        color: #d32f2f;
                        word-break: keep-all;
                        text-align: center;
                      "
                    >
                      Products Request(s)
                    </v-card-title>
                  </v-col>
                  <v-col cols="12" xl="4" lg="12" md="12" sm="12">
                    <v-row no-gutters>
                      <v-col cols="12">
                        <v-card-text
                          :class="{
                            'text-center': $vuetify.breakpoint.mdAndDown,
                          }"
                          class="
                            text-right
                            font-weight-bold
                            pa-1
                            text-body-2
                            text-xl-subtitle-1
                            text-lg-subtitle-1
                            text-md-subtitle-2
                            text-sm-body-2
                            pr-2 pr-xl-4 pr-lg-4 pr-md-4 pr-sm-2
                            pl-2
                          "
                        >
                          {{ prodrequest }}
                          <v-progress-circular
                            size="18"
                            indeterminate
                            :hidden="hidden8"
                            color="red darken-2"
                          ></v-progress-circular>
                        </v-card-text>
                      </v-col>
                    </v-row>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
      </v-row>

      <!-- Divider -->
      <v-divider></v-divider>

      <!-- Graphs -->
      <v-row no-gutters>
        <v-spacer></v-spacer>
        <v-col cols="12" xl="6" lg="6" md="12" sm="12">
          <v-row no-gutters class="mb-3">
            <!-- Branch Selection -->
            <v-col cols="12" xl="6" lg="6" md="6" sm="12">
              <v-select
                :items="branchlist"
                v-model="branch"
                item-text="branch_name"
                item-value="id"
                label="Branch"
                @change="getProductsGraph"
                hide-details
                style="font-size: 12px"
                class="pa-1"
                dense
                solo
                dark
              >
              </v-select>
            </v-col>
            <!-- Year Selection -->
            <v-col cols="5" xl="3" lg="3" md="3" sm="5">
              <v-select
                v-model="year"
                item-text=""
                item-value="id"
                :items="ylist"
                label="Year"
                @change="getProductsGraph"
                hide-details
                style="font-size: 12px"
                class="pa-1"
                dense
                solo
                dark
              >
              </v-select>
            </v-col>
            <!-- Month Selection -->
            <v-col cols="7" xl="3" lg="3" md="3" sm="7">
              <v-select
                v-model="month"
                item-text=""
                item-value="id"
                :items="mlist"
                label="Month"
                @change="getProductsGraph"
                hide-details
                style="font-size: 12px"
                class="pa-1"
                dense
                solo
                dark
              >
              </v-select> </v-col
          ></v-row>
        </v-col>
      </v-row>

      <v-row no-gutters>
        <!-- Sales Graph -->
        <v-col cols="12" xl="6" lg="6" md="6" sm="12" class="pa-1">
          <v-card
            elevation="2"
            style="border-radius: 10px"
            :loading="progressbar1"
            ref="progress"
          >
            <v-card-title
              dark
              class="
                py-2
                text-body-2
                text-xl-subtitle-1
                text-lg-subtitle-1
                text-md-subtitle-2
                text-sm-body-2
              "
              style="
                color: #d32f2f;
                font-weight: bold;
                background-color: #e0e0e0;
              "
              >Sales Graph</v-card-title
            >
            <v-divider class="my-0"></v-divider>
            <bar-chart
              class="pa-2"
              :options="options"
              :chart-data="datacollection"
            >
            </bar-chart>
            <v-progress-linear
              color="red darken-2"
              class="px-0 mx-0"
              slot="progress"
              indeterminate
              rounded
            ></v-progress-linear>
          </v-card>
        </v-col>
        <!-- Products Graph -->
        <v-col cols="12" xl="6" lg="6" md="6" sm="12" class="pa-1">
          <v-card
            elevation="2"
            style="border-radius: 10px"
            :loading="progressbar2"
            ref="progress"
          >
            <v-card-title
              class="
                py-2
                text-body-2
                text-xl-subtitle-1
                text-lg-subtitle-1
                text-md-subtitle-2
                text-sm-body-2
              "
              style="
                color: #d32f2f;
                font-weight: bold;
                background-color: #e0e0e0;
              "
              >Purchase Graph</v-card-title
            >
            <v-divider class="my-0"></v-divider>
            <bar-chart1
              class="pa-2"
              :options="options1"
              :chart-data="datacollection1"
            >
            </bar-chart1>
            <v-progress-linear
              color="red darken-2"
              class="px-0 mx-0"
              slot="progress"
              indeterminate
              rounded
            ></v-progress-linear>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<!-- Style -->
<style>
.container {
  max-width: 1500px !important;
}

.v-list-item__content {
  color: white !important;
}
.v-menu__content.theme--light .v-list {
  background: #212121 !important;
}
.theme--light.v-list-item:hover:before {
  opacity: 0.2 !important;
}
</style>

<!-- Script -->
<script>
import BarChart from "../charts/BarChart";
import BarChart1 from "../charts/BarChart";
import { mapGetters } from "vuex";
import axios from "axios"; // Library for sending api request
export default {
  middleware: "auth",
  metaInfo() {
    return { title: "Dashboard" };
  },
  components: {
    BarChart,
    BarChart1,
  },
  //Computed
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
    hiddenCard1() {
      if (this.checkbox1 == false) {
        return false;
      } else {
        return true;
      }
    },
    hiddenCard2() {
      if (this.checkbox2 == false) {
        return false;
      } else {
        return true;
      }
    },
    hiddenCard3() {
      if (this.checkbox3 == false) {
        return false;
      } else {
        return true;
      }
    },
    hiddenCard4() {
      if (this.checkbox4 == false) {
        return false;
      } else {
        return true;
      }
    },
  },
  //Data
  data: () => ({
    sheet: false,
    checkbox1: true,
    checkbox2: true,
    checkbox3: true,
    checkbox4: true,
    branch: 1,
    year: new Date().getFullYear(),
    month: "All",
    supp: null,
    prod: null,
    po: null,
    mlist: [],
    ylist: [],
    useracc: null,
    suppexpdate: [],
    prodexpdate: [],
    supprequest: null,
    prodrequest: null,
    hidden1: true,
    hidden2: true,
    hidden3: true,
    hidden4: true,
    hidden5: true,
    hidden6: true,
    hidden7: true,
    hidden8: true,
    progressbar1: false,
    progressbar2: false,
    branchlist: [],
    datacollection: {},
    options: {
      legend: {
        display: false,
      },
      plugins: {
        zoom: {
          zoom: {
            wheel: {
              enabled: true,
            },
            pinch: {
              enabled: true,
            },
            mode: "xy",
          },
        },
      },

      responsiveAnimationDuration: 0,
      tooltips: {
        enabled: true,
        mode: "single",
        callbacks: {
          label: function (data) {
            return [
              "₱ " +
                data.yLabel
                  .toFixed(2)
                  .toString()
                  .replace(/\B(?=(\d{3})+(?!\d))/g, ","),
            ];
          },
          title: function (data) {
            return "Sale: " + data[0].label;
          },
        },
      },
      scales: {
        yAxes: [
          {
            ticks: {
              beginAtZero: true,
              callback: function (value, index, values) {
                return (
                  "PHP " +
                  value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                );
              },
            },
          },
        ],
      },
    },

    datacollection1: {},
    options1: {
      legend: {
        display: false,
      },
      plugins: {
        zoom: {
          zoom: {
            wheel: {
              enabled: true,
            },
            pinch: {
              enabled: true,
            },
            mode: "xy",
          },
        },
      },

      responsiveAnimationDuration: 0,
      tooltips: {
        enabled: true,
        mode: "single",
        callbacks: {
          label: function (data) {
            return [
              data.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
            ];
          },
          title: function (data) {
            return "Purchase: " + data[0].label;
          },
        },
      },
      scales: {
        yAxes: [
          {
            ticks: {
              beginAtZero: true,
              callback: function (value, index, values) {
                return value;
              },
            },
          },
        ],
      },
    },
  }),

  //Methods
  methods: {
    list() {
      this.mlist = ["All"];
      for (var key in moment.months()) {
        this.mlist.push(moment.months()[key]);
      }

      var currentYear = new Date().getFullYear(),
        years = [];
      var startYear = new Date().getFullYear() - 3;
      while (startYear <= currentYear) {
        years.push(startYear++);
      }
      this.ylist = years;
    },

    //For retrieving supply count
    async getSupp() {
      this.hidden1 = false;
      await axios
        .get("/api/dashboard/getSupp")
        .then((result) => {
          this.supp = result.data;
          this.hidden1 = true;
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    //For retrieving product count
    async getProd() {
      this.hidden2 = false;
      await axios
        .get("/api/dashboard/getProd")
        .then((result) => {
          this.prod = result.data;
          this.hidden2 = true;
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    //For retrieving purchase order count
    async getPO() {
      this.hidden3 = false;
      await axios
        .get("/api/dashboard/getPO")
        .then((result) => {
          this.po = result.data;
          this.hidden3 = true;
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    //For retrieving user count
    async getUser() {
      this.hidden4 = false;
      await axios
        .get("/api/dashboard/getUser")
        .then((result) => {
          this.useracc = result.data;
          this.hidden4 = true;
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    //For retrieving expired supply count
    async getSuppExpDate() {
      this.hidden5 = false;
      await axios
        .get("/api/dashboard/getSuppExpDate")
        .then((result) => {
          this.hidden5 = true;
          this.suppexpdate = result.data;
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    //For retrieving expired product count
    async getProdExpDate() {
      this.hidden6 = false;
      await axios
        .get("/api/dashboard/getProdExpDate")
        .then((result) => {
          this.hidden6 = true;
          this.prodexpdate = result.data;
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    //For retrieving supply request count
    async getSuppRequests() {
      this.hidden7 = false;
      await axios
        .get("/api/dashboard/getSuppRequests")
        .then((result) => {
          this.hidden7 = true;
          this.supprequest = result.data;
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    //For retrieving product request count
    async getProdRequests() {
      this.hidden8 = false;
      await axios
        .get("/api/dashboard/getProdRequests")
        .then((result) => {
          this.hidden8 = true;
          this.prodrequest = result.data;
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    //For retrieving sales graph
    async getSalesGraph() {
      this.progressbar1 = true;
      await axios
        .get("/api/dashboard/getSalesGraph", {
          params: {
            branch: this.branch,
            year: this.year,
            month: new Date(Date.parse(this.month + " 1, 2020")).getMonth() + 1,
          },
        })
        .then((result) => {
          this.datacollection = {
            labels: result.data.month,
            datasets: [
              {
                label: "Sale",
                backgroundColor: [
                  "#D32F2F",
                  "#FF8A80",
                  "#D32F2F",
                  "#FF8A80",
                  "#D32F2F",
                  "#D32F2F",
                  "#FF8A80",
                  "#D32F2F",
                  "#FF8A80",
                  "#D32F2F",
                  "#FF8A80",
                  "#D32F2F",
                ],
                data: result.data.data,
              },
            ],
          };
          this.progressbar1 = false;
        })
        .catch((result) => {});
    },

    //For retrieving products graph
    async getProductsGraph() {
      this.getSalesGraph();
      this.progressbar2 = true;
      await axios
        .get("/api/dashboard/getProductsGraph", {
          params: {
            branch: this.branch,
            year: this.year,
            month: new Date(Date.parse(this.month + " 1, 2020")).getMonth() + 1,
          },
        })
        .then((result) => {
          this.datacollection1 = {
            labels: result.data.name,
            datasets: [
              {
                label: "Purchase",
                backgroundColor: [
                  "#D32F2F",
                  "#FF8A80",
                  "#D32F2F",
                  "#FF8A80",
                  "#D32F2F",
                ],
                data: result.data.sold,
              },
            ],
          };
          this.progressbar2 = false;
        })
        .catch((result) => {});
    },

    //For retrieving branch names
    async branchName() {
      await axios
        .get("/api/branches/inventory/branchName")
        .then((bran_name) => {
          this.branchlist = bran_name.data;
        });
    },
  },

  //Onload
  created() {
    if (this.user.permissionslist.includes("Access Dashboard")) {
      this.getSupp();
      this.getProd();
      this.list();
      this.getPO();
      this.getUser();
      this.getSuppExpDate();
      this.getProdExpDate();
      this.getSuppRequests();
      this.getProdRequests();
      this.getSalesGraph();
      this.getProductsGraph();
      this.branchName();
    } else {
      if (this.user.permissionslist.includes("Access POS")) {
        this.$router.push({ name: "pos" }).catch((errr) => {});
      } else {
        if (this.user.roles[0].name == "Stockman") {
          this.$router
            .push({ name: "masterlist-supplies" })
            .catch((errr) => {});
        }
        if (this.user.roles[0].name == "Production Assistant") {
          this.$router
            .push({ name: "masterlist-products" })
            .catch((errr) => {});
        }
        if (this.user.roles[0].name == "Supervisor") {
          this.$router.push({ name: "supplies-inventory" }).catch((errr) => {});
        }
      }
    }
  },
};
</script>