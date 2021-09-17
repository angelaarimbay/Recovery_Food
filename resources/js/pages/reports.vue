<template>
  <div style="min-width: 280px">
    <v-container>
      <v-layout row wrap>
        <h4
          class="font-weight-bold heading my-auto"
          :class="{ h5: $vuetify.breakpoint.smAndDown }"
        >
          Reports
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
            >Reports</v-btn
          >
        </v-card-actions>
      </v-layout>
    </v-container>

    <!-- Main Card -->
    <v-card elevation="6" class="mt-2" style="border-radius: 10px">
      <v-tabs
        slider-size="4"
        v-model="tab"
        color="red darken-2"
        :height="height"
        show-arrows
        center-active
        centered
      >
        <v-tabs-slider style="border-radius: 5px 5px 0 0"></v-tabs-slider>
        <v-tab
          :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
          style="text-transform: none"
        >
          Masterlist Supplies Report
        </v-tab>
        <v-tab
          :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
          style="text-transform: none"
        >
          Incoming Supplies Report
        </v-tab>
        <v-tab
          :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
          style="text-transform: none"
        >
          Outgoing Supplies Report
        </v-tab>
        <v-tab
          :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
          style="text-transform: none"
        >
          Main Inventory Report
        </v-tab>
        <v-tab
          :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
          style="text-transform: none"
        >
          Inventory Summary Report
        </v-tab>
        <v-tab
          :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
          style="text-transform: none"
        >
          Sales Report
        </v-tab>
        <v-tab
          :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
          style="text-transform: none"
        >
          Transaction Report
        </v-tab>
        <v-tab
          :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
          style="text-transform: none"
        >
          Purchase Orders Report
        </v-tab>
      </v-tabs>

      <v-tabs-items v-model="tab">
        <v-tab-item>
          <!-- Masterlist Supplies Report -->
          <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
            <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
              <v-card-actions class="px-0 justify-center">
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-pdf</v-icon></v-btn
                    >
                  </template>
                  <span>Export to PDF</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-excel</v-icon></v-btn
                    >
                  </template>
                  <span>Export to Excel</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-printer</v-icon></v-btn
                    >
                  </template>
                  <span>Print</span>
                </v-tooltip></v-card-actions
              >
              <!-- Category Field -->
              <v-row no-gutters justify="center">
                <v-col cols="6" xl="2" lg="3" md="4" sm="6" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-select
                      :items="suppcatlist"
                      item-text="supply_cat_name"
                      item-value="id"
                      class="my-0"
                      clearable
                      dense
                      label="Category"
                    >
                    </v-select>
                  </v-card-actions>
                </v-col>
              </v-row>
            </v-container>
          </v-container>
        </v-tab-item>

        <v-tab-item>
          <!-- Incoming Supplies Report -->
          <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
            <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
              <v-card-actions class="px-0 justify-center">
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-pdf</v-icon></v-btn
                    >
                  </template>
                  <span>Export to PDF</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-excel</v-icon></v-btn
                    >
                  </template>
                  <span>Export to Excel</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-printer</v-icon></v-btn
                    >
                  </template>
                  <span>Print</span>
                </v-tooltip></v-card-actions
              >
              <!-- Category Field -->
              <v-row no-gutters justify="center">
                <v-col cols="12" xl="2" lg="3" md="3" sm="12" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-select
                      :items="suppcatlist"
                      item-text="supply_cat_name"
                      item-value="id"
                      class="my-0"
                      clearable
                      dense
                      label="Category"
                    >
                    </v-select>
                  </v-card-actions>
                </v-col>

                <!-- Date Picker -->
                <v-col cols="6" xl="2" lg="3" md="3" sm="6" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-menu
                      v-model="date1"
                      :close-on-content-click="false"
                      :nudge-right="35"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="dateFromIncoming"
                          label="Date From"
                          prepend-icon="mdi-calendar-range"
                          readonly
                          v-on="on"
                          class="py-0"
                          dense
                          clearable
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="dateFromIncoming"
                        @input="date1 = false"
                        scrollable
                        no-title
                        color="red darken-2"
                        dark
                      ></v-date-picker>
                    </v-menu>
                  </v-card-actions>
                </v-col>

                <v-col cols="6" xl="2" lg="3" md="3" sm="6" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-menu
                      v-model="date2"
                      :close-on-content-click="false"
                      :nudge-right="35"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="dateUntilIncoming"
                          label="Date Until"
                          prepend-icon="mdi-calendar-range"
                          readonly
                          v-on="on"
                          class="py-0"
                          dense
                          clearable
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="dateUntilIncoming"
                        @input="date2 = false"
                        scrollable
                        no-title
                        color="red darken-2"
                        dark
                      ></v-date-picker>
                    </v-menu>
                  </v-card-actions>
                </v-col>
              </v-row>
            </v-container>
          </v-container>
        </v-tab-item>

        <v-tab-item>
          <!-- Outgoing Supplies Report -->
          <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
            <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
              <v-card-actions class="px-0 justify-center">
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-pdf</v-icon></v-btn
                    >
                  </template>
                  <span>Export to PDF</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-excel</v-icon></v-btn
                    >
                  </template>
                  <span>Export to Excel</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-printer</v-icon></v-btn
                    >
                  </template>
                  <span>Print</span>
                </v-tooltip></v-card-actions
              >
              <!-- Branch Field -->
              <v-row no-gutters justify="center">
                <v-col cols="6" xl="2" lg="3" md="3" sm="12" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-select
                      :items="branchlist"
                      item-text="supply_cat_name"
                      item-value="id"
                      class="my-0"
                      clearable
                      dense
                      label="Branch"
                    >
                    </v-select>
                  </v-card-actions>
                </v-col>

                <!-- Category Field -->
                <v-col cols="6" xl="2" lg="3" md="3" sm="12" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-select
                      :items="suppcatlist"
                      item-text="supply_cat_name"
                      item-value="id"
                      class="my-0"
                      clearable
                      dense
                      label="Category"
                    >
                    </v-select>
                  </v-card-actions>
                </v-col>

                <!-- Date Picker -->
                <v-col cols="6" xl="2" lg="3" md="3" sm="6" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-menu
                      v-model="date3"
                      :close-on-content-click="false"
                      :nudge-right="35"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="dateFromOutgoing"
                          label="Date From"
                          prepend-icon="mdi-calendar-range"
                          readonly
                          v-on="on"
                          class="py-0"
                          dense
                          clearable
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="dateFromOutgoing"
                        @input="date3 = false"
                        scrollable
                        no-title
                        color="red darken-2"
                        dark
                      ></v-date-picker>
                    </v-menu>
                  </v-card-actions>
                </v-col>

                <v-col cols="6" xl="2" lg="3" md="3" sm="6" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-menu
                      v-model="date4"
                      :close-on-content-click="false"
                      :nudge-right="35"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="dateUntilOutgoing"
                          label="Date Until"
                          prepend-icon="mdi-calendar-range"
                          readonly
                          v-on="on"
                          class="py-0"
                          dense
                          clearable
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="dateUntilOutgoing"
                        @input="date4 = false"
                        scrollable
                        no-title
                        color="red darken-2"
                        dark
                      ></v-date-picker>
                    </v-menu>
                  </v-card-actions>
                </v-col>
              </v-row>
            </v-container>
          </v-container>
        </v-tab-item>

        <v-tab-item>
          <!-- Main Inventory Report -->
          <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
            <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
              <v-card-actions class="px-0 justify-center">
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-pdf</v-icon></v-btn
                    >
                  </template>
                  <span>Export to PDF</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-excel</v-icon></v-btn
                    >
                  </template>
                  <span>Export to Excel</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-printer</v-icon></v-btn
                    >
                  </template>
                  <span>Print</span>
                </v-tooltip></v-card-actions
              >
              <!-- Category Field -->
              <v-row no-gutters justify="center">
                <v-col cols="6" xl="2" lg="3" md="4" sm="6" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-select
                      :items="suppcatlist"
                      item-text="supply_cat_name"
                      item-value="id"
                      class="my-0"
                      clearable
                      dense
                      label="Category"
                    >
                    </v-select>
                  </v-card-actions>
                </v-col>
              </v-row>
            </v-container>
          </v-container>
        </v-tab-item>

        <v-tab-item>
          <!-- Inventory Summary Report -->
          <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
            <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
              <v-card-actions class="px-0 justify-center">
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-pdf</v-icon></v-btn
                    >
                  </template>
                  <span>Export to PDF</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-excel</v-icon></v-btn
                    >
                  </template>
                  <span>Export to Excel</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-printer</v-icon></v-btn
                    >
                  </template>
                  <span>Print</span>
                </v-tooltip></v-card-actions
              >
            </v-container>
          </v-container>
        </v-tab-item>

        <v-tab-item>
          <!-- Sales Report -->
        </v-tab-item>

        <v-tab-item>
          <!-- Transaction Report -->
        </v-tab-item>

        <v-tab-item>
          <!-- Purchase Order Report -->
          <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
            <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
              <v-card-actions class="px-0 justify-center">
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-pdf</v-icon></v-btn
                    >
                  </template>
                  <span>Export to PDF</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-excel</v-icon></v-btn
                    >
                  </template>
                  <span>Export to Excel</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-printer</v-icon></v-btn
                    >
                  </template>
                  <span>Print</span>
                </v-tooltip></v-card-actions
              >

              <v-row no-gutters justify="center">
                <!-- Date Picker -->
                <v-col cols="6" xl="2" lg="3" md="4" sm="6" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-menu
                      v-model="date9"
                      :close-on-content-click="false"
                      :nudge-right="35"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="dateFromPO"
                          label="Date From"
                          prepend-icon="mdi-calendar-range"
                          readonly
                          v-on="on"
                          class="py-0"
                          dense
                          clearable
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="dateFromPO"
                        @input="date9 = false"
                        scrollable
                        no-title
                        color="red darken-2"
                        dark
                      ></v-date-picker>
                    </v-menu>
                  </v-card-actions>
                </v-col>

                <v-col cols="6" xl="2" lg="3" md="4" sm="6" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-menu
                      v-model="date10"
                      :close-on-content-click="false"
                      :nudge-right="35"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="dateUntilPO"
                          label="Date Until"
                          prepend-icon="mdi-calendar-range"
                          readonly
                          v-on="on"
                          class="py-0"
                          dense
                          clearable
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="dateUntilPO"
                        @input="date10 = false"
                        scrollable
                        no-title
                        color="red darken-2"
                        dark
                      ></v-date-picker>
                    </v-menu>
                  </v-card-actions>
                </v-col>
              </v-row>
            </v-container>
          </v-container>
        </v-tab-item>
      </v-tabs-items>
    </v-card>
  </div>
</template>

<script>
export default {
  data: () => ({
    tab: null,
    suppcatlist: [],
    branchlist: [],
    dateFromIncoming: null,
    dateUntilIncoming: null,
    dateFromOutgoing: null,
    dateUntilOutgoing: null,
    dateFromPO: null,
    dateUntilPO: null,
    date1: false,
    date2: false,
    date3: false,
    date4: false,
    date9: false,
    date10: false,
  }),

  async suppCat() {
    await axios.get("api/msupp/suppCat").then((supp_cat) => {
      this.suppcatlist = supp_cat.data;
    });
  },

  async branchName() {
    await axios.get("api/osupp/branchName").then((bran_name) => {
      this.branchlist = bran_name.data;
    });
  },

  computed: {
    height() {
      switch (this.$vuetify.breakpoint.name) {
        case "xs":
          return 35;
        default:
          return 42;
      }
    },
  },
};
</script>