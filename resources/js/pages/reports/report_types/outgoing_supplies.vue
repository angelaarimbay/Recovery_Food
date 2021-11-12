<template>
  <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
    <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
      <!-- Snackbar -->
      <v-snackbar
        :vertical="$vuetify.breakpoint.xsOnly"
        min-width="auto"
        v-model="snackbar.active"
        timeout="2500"
        class="text-center pb-0"
        :left="$vuetify.breakpoint.smAndUp"
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

      <v-card-actions class="px-0 justify-center">
        <v-tooltip bottom>
          <template #activator="data">
            <v-btn
              dark
              color="red accent-4"
              class="mx-1"
              @click="get('pdf')"
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
              dark
              color="green darken-4"
              class="mx-1"
              @click="get('excel')"
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
              dark
              color="blue-grey darken-1"
              class="mx-1"
              @click="get('print')"
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
        <v-col cols="6" xl="2" lg="3" md="6" sm="6" class="my-auto">
          <v-card-actions class="pb-0 pt-4">
            <v-select
              hide-details
              v-model="branch"
              :items="branchlist"
              item-text="branch_name"
              item-value="id"
              class="my-0"
              dense
              label="Branch"
              background-color="blue-grey lighten-5"
              flat
              solo
            >
            </v-select>
          </v-card-actions>
        </v-col>

        <!-- Category Field -->
        <v-col cols="6" xl="2" lg="3" md="6" sm="6" class="my-auto">
          <v-card-actions class="pb-0 pt-4">
            <v-select
              hide-details
              v-model="category"
              :items="suppcatlist"
              item-text="supply_cat_name"
              item-value="id"
              class="my-0"
              dense
              label="Category"
              background-color="blue-grey lighten-5"
              flat
              solo
            >
            </v-select>
          </v-card-actions>
        </v-col>

        <!-- Date Picker -->
        <v-col cols="6" xl="2" lg="3" md="6" sm="6" class="my-auto">
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
                  hide-details
                  v-model="outgoing_from"
                  label="Date From"
                  prepend-icon="mdi-calendar-range"
                  readonly
                  v-on="on"
                  class="py-0"
                  dense
                  background-color="blue-grey lighten-5"
                  flat
                  solo
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="outgoing_from"
                @input="date1 = false"
                scrollable
                no-title
                color="red darken-2"
                dark
              ></v-date-picker>
            </v-menu>
          </v-card-actions>
        </v-col>

        <v-col cols="6" xl="2" lg="3" md="6" sm="6" class="my-auto">
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
                  hide-details
                  v-model="outgoing_to"
                  label="Date Until"
                  prepend-icon="mdi-calendar-range"
                  readonly
                  v-on="on"
                  class="py-0"
                  dense
                  background-color="blue-grey lighten-5"
                  flat
                  solo
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="outgoing_to"
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
    <iframe id="print2" class="d-none" :src="print" frameborder="0"></iframe>
  </v-container>
</template>

<style>
.v-application .blue-grey.lighten-5 {
  border: 1px solid #bdbdbd !important;
}
</style>

<script>
import axios from "axios"; // Library for sending api request
export default {
  data: () => ({
    branch: "",
    print: "",
    category: "",
    suppcatlist: [],
    branchlist: [],
    snackbar: {
      active: false,
      message: "",
    },
    outgoing_from: null,
    outgoing_to: null,
    date1: false,
    date2: false,
  }),

  created() {
    this.outgoing_from = this.getFormatDate(
      new Date(new Date().getFullYear(), new Date().getMonth(), 1),
      "YYYY-MM-DD"
    );
    this.outgoing_to = this.getFormatDate(
      new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0),
      "YYYY-MM-DD"
    );

    this.suppCat();
    this.branchName();
  },

  methods: {
    getFormatDate(e, format) {
      const date = moment(e);
      return date.format(format);
    },

    async get(type) {
      if (
        this.branch == "" ||
        this.category == "" ||
        this.outgoing_from == null ||
        this.outgoing_to == null
      ) {
        this.snackbar = {
          active: true,
          iconText: "alert",
          iconColor: "error",
          message: "Error! Please complete the fields first.",
        };
      } else {
        switch (type) {
          case "pdf":
            await axios({
              url: "/api/reports/outgoingsupplies/get",
              method: "GET",
              responseType: "blob",
              params: {
                type: type,
                branch: this.branch,
                category: this.category,
                from: this.outgoing_from,
                to: this.outgoing_to,
              },
            }).then((response) => {
              if (response.data.size > 0) {
                // console.log(response.data);
                // return;
                let blob = new Blob([response.data], {
                  type: "application/pdf",
                });
                let link = document.createElement("a");
                link.href = window.URL.createObjectURL(blob);
                link.download = "Outgoing Supplies Report.pdf";
                link.click();
              } else {
                this.snackbar = {
                  active: true,
                  iconText: "alert-box",
                  iconColor: "warning",
                  message: "Nothing to export.",
                };
              }
            });
            break;
          case "excel":
            await axios({
              url: "/api/reports/outgoingsupplies/get",
              method: "GET",
              responseType: "blob",
              params: {
                type: type,
                branch: this.branch,
                category: this.category,
                from: this.outgoing_from,
                to: this.outgoing_to,
              },
            }).then((response) => {
              if (response.data.size > 0) {
                axios
                  .get("/api/reports/outgoingsupplies/get", {
                    method: "GET",
                    responseType: "arraybuffer",
                    params: {
                      type: type,
                      branch: this.branch,
                      category: this.category,
                      from: this.outgoing_from,
                      to: this.outgoing_to,
                    },
                  })
                  .then((response) => {
                    let blob = new Blob([response.data], {
                      type: "application/excel",
                    });
                    let link = document.createElement("a");
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "Outgoing Supplies Report.xlsx";
                    link.click();
                  });
              } else {
                this.snackbar = {
                  active: true,
                  iconText: "alert-box",
                  iconColor: "warning",
                  message: "Nothing to export.",
                };
              }
            });
            break;
          case "print":
            await axios({
              url: "/api/reports/outgoingsupplies/get",
              method: "GET",
              responseType: "blob",
              params: {
                type: "pdf",
                branch: this.branch,
                category: this.category,
                from: this.outgoing_from,
                to: this.outgoing_to,
              },
            }).then((response) => {
              if (response.data.size > 0) {
                let blob = new Blob([response.data], {
                  type: "application/pdf",
                });
                this.print = window.URL.createObjectURL(blob);
                this.snackbar = {
                  active: true,
                  iconText: "information",
                  iconColor: "primary",
                  message: "Printing... Please wait.",
                };
                setTimeout(function () {
                  document.getElementById("print2").contentWindow.print();
                }, 3000);
              } else {
                this.snackbar = {
                  active: true,
                  iconText: "alert-box",
                  iconColor: "warning",
                  message: "Nothing to print.",
                };
              }
            });
            break;
          default:
            break;
        }
      }
    },

    async suppCat() {
      await axios.get("/api/msupp/suppCat").then((supp_cat) => {
        this.suppcatlist.push({ supply_cat_name: "All", id: "All" });
        for (var key in supp_cat.data) {
          this.suppcatlist.push({
            supply_cat_name: supp_cat.data[key]["supply_cat_name"],
            id: supp_cat.data[key]["id"],
          });
        }
      });
    },

    async branchName() {
      await axios.get("api/osupp/branchName").then((bran_name) => {
        this.branchlist = bran_name.data;
      });
    },
  },
};
</script>