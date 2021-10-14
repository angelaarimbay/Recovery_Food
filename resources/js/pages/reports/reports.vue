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
        <v-tabs-slider style="display: none"></v-tabs-slider>
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
          <masterlistsupplies1 />
        </v-tab-item>

        <v-tab-item>
          <!-- Incoming Supplies Report -->
          <incomingsupplies1 />
        </v-tab-item>

        <v-tab-item>
          <!-- Outgoing Supplies Report -->
          <outgoingsupplies1 />
        </v-tab-item>

        <v-tab-item>
          <!-- Main Inventory Report -->
          <maininventory1 />
        </v-tab-item>

        <v-tab-item>
          <!-- Inventory Summary Report -->
          <inventorysummary1 />
        </v-tab-item>

        <v-tab-item>
          <!-- Sales Report -->
          <sales1 />
        </v-tab-item>

        <v-tab-item>
          <!-- Transaction Report -->
          <transaction1 />
        </v-tab-item>

        <v-tab-item>
          <!-- Purchase Order Report -->
          <purchaseorder1 />
        </v-tab-item>
      </v-tabs-items>
    </v-card>
  </div>
</template>

<style>
.v-pagination button {
  background-color: #212121 !important;
  color: #ffffff !important;
}
.v-pagination i.v-icon.v-icon {
  color: #ffffff !important;
}
.v-pagination__navigation:disabled {
  background-color: #000000 !important;
}
</style>

<script>
import masterlistsupplies1 from "./report_types/masterlist_supplies.vue";
import incomingsupplies1 from "./report_types/incoming_supplies.vue";
import outgoingsupplies1 from "./report_types/outgoing_supplies.vue";
import maininventory1 from "./report_types/main_inventory.vue";
import inventorysummary1 from "./report_types/inventory_summary.vue";
import sales1 from "./report_types/sales.vue";
import transaction1 from "./report_types/transaction.vue";
import purchaseorder1 from "./report_types/purchase_order.vue";
import { mapGetters } from "vuex";
import axios from "axios"; // Library for sending api request
export default {
  middleware: "auth",
  components: {
    masterlistsupplies1,
    incomingsupplies1,
    outgoingsupplies1,
    maininventory1,
    inventorysummary1,
    sales1,
    transaction1,
    purchaseorder1,
  },

  data: () => ({
    tab: null,
    category: "",
    snackbar: {
      active: false,
      message: "",
    },
    branchlist: [],
    table1: [],
    table2: [],

    // Table Headers TP
    headers2: [
      { text: "#", value: "count", align: "start", filterable: false },
      {
        text: "Branch",
        value: "",
        filterable: false,
      },
      { text: "Date & Time", value: "" },
      {
        text: "Reference No.",
        value: "",
        align: "right",
        filterable: false,
      },
      {
        text: "Total Product",
        value: "",
        align: "right",
        filterable: false,
      },
      {
        text: "Total Amount",
        value: "",
        align: "right",
        filterable: false,
      },
      {
        text: "Actions",
        value: "id",
        align: "center",
        sortable: false,
        filterable: false,
      },
    ],
  }),

  created() {
    if (this.user.permissionslist.includes("Access Reports")) {
      this.branchName();
    } else {
      this.$router.push({ name: "invalid-page" }).catch((errr) => {});
    }
  },

  methods: {
    itemperpage2() {
      this.page2 = 1;
      this.getTransactionReport();
    },

    async getSalesReport() {
      this.progressbar = true; // Show the progress bar
      // Get data from tables
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;
      await axios
        .get("/api/sales_report", {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,
            search: this.search,
            branch: this.branch,
            category: this.category,
            dateFrom: this.dateFrom,
            dateUntil: this.dateUntil,
          },
        })
        .then((result) => {
          // If the value is true then get the data
          this.table1 = result.data;
          this.progressbar = false; // Hide the progress bar
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    async getTransactionReport() {
      this.progressbar = true; // Show the progress bar
      // Get data from tables
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;
      await axios
        .get("/api/transaction_report", {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,
            search: this.search,
            branch: this.branch,
            category: this.category,
            dateFrom: this.dateFrom,
            dateUntil: this.dateUntil,
          },
        })
        .then((result) => {
          // If the value is true then get the data
          this.table2 = result.data;
          this.progressbar = false; // Hide the progress bar
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    async branchName() {
      await axios.get("/api/osupp/branchName").then((bran_name) => {
        this.branchlist = bran_name.data;
      });
    },
  },

  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
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