<template>
  <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
    <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
      <!-- Progress Circular -->
      <v-overlay :value="overlay">
        <v-progress-circular size="55" color="red darken-2" indeterminate>
        </v-progress-circular>
      </v-overlay>
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
      <!-- Category Field -->
      <v-row no-gutters justify="center">
        <v-col cols="4" class="px-1" style="max-width: 150px">
          <v-card-actions class="pb-1 pt-4 px-0">
            <v-select
              hide-details
              v-model="category"
              :items="suppcatlist"
              item-text="supply_cat_name"
              item-value="id"
              dense
              placeholder="Category"
              background-color="grey darken-3"
              dark
              flat
              solo
              style="font-size: 12px"
            >
            </v-select>
          </v-card-actions>
        </v-col>

        <!-- Date Picker -->
        <v-col cols="4" class="px-1" style="max-width: 150px">
          <v-card-actions class="pb-1 pt-4 px-0">
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
                  v-model="incoming_from"
                  placeholder="Date From"
                  :prepend-inner-icon="showIcon ? 'mdi-calendar-range' : ''"
                  readonly
                  v-on="on"
                  dense
                  background-color="grey darken-3"
                  dark
                  flat
                  solo
                  style="font-size: 12px"
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="incoming_from"
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
        <v-col cols="4" class="px-1" style="max-width: 150px">
          <v-card-actions class="pb-1 pt-4 px-0">
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
                  v-model="incoming_to"
                  placeholder="Date Until"
                  :prepend-inner-icon="showIcon ? 'mdi-calendar-range' : ''"
                  readonly
                  v-on="on"
                  dense
                  background-color="grey darken-3"
                  dark
                  flat
                  solo
                  style="font-size: 12px"
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="incoming_to"
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
    <iframe id="print1" class="d-none" :src="print" frameborder="0"></iframe>
  </v-container>
</template>

<style>
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

<script>
import axios from "axios"; // Library for sending api request
export default {
  computed: {
    showIcon() {
      if (this.$vuetify.breakpoint.smAndUp) {
        return true;
      } else {
        return false;
      }
    },
  },
  data: () => ({
    category: "",
    suppcatlist: [],
    print: "",
    snackbar: {
      active: false,
      message: "",
    },
    incoming_from: null,
    incoming_to: null,
    date1: false,
    date2: false,
    overlay: false,
  }),

  created() {
    this.incoming_from = this.getFormatDate(
      new Date(new Date().getFullYear(), new Date().getMonth(), 1),
      "YYYY-MM-DD"
    );
    this.incoming_to = this.getFormatDate(
      new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0),
      "YYYY-MM-DD"
    );
    this.suppCat();
  },

  methods: {
    getFormatDate(e, format) {
      const date = moment(e);
      return date.format(format);
    },

    async get(type) {
      if (
        this.category == "" ||
        this.incoming_from == null ||
        this.incoming_to == null
      ) {
        this.snackbar = {
          active: true,
          iconText: "alert",
          iconColor: "error",
          message: "Error! Please complete the fields first.",
        };
      } else {
        this.overlay = true;
        switch (type) {
          case "pdf":
            await axios({
              url: "/api/reports/incomingsupplies/get",
              method: "GET",
              responseType: "blob",
              params: {
                type: type,
                category: this.category,
                from: this.incoming_from,
                to: this.incoming_to,
              },
            }).then((response) => {
              if (response.data.size > 0) {
                let blob = new Blob([response.data], {
                  type: "application/pdf",
                });
                let link = document.createElement("a");
                link.href = window.URL.createObjectURL(blob);
                link.download = "Incoming Supplies Report.pdf";
                link.click();
                this.snackbar = {
                  active: true,
                  iconText: "check",
                  iconColor: "success",
                  message: "Successfully exported.",
                };
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
              url: "/api/reports/incomingsupplies/get",
              method: "GET",
              responseType: "blob",
              params: {
                type: "pdf",
                category: this.category,
                from: this.incoming_from,
                to: this.incoming_to,
              },
            }).then((response) => {
              if (response.data.size > 0) {
                axios
                  .get("/api/reports/incomingsupplies/get", {
                    method: "GET",
                    responseType: "arraybuffer",
                    params: {
                      type: type,
                      category: this.category,
                      from: this.incoming_from,
                      to: this.incoming_to,
                    },
                  })
                  .then((res) => {
                    let blob = new Blob([res.data], {
                      type: "application/excel",
                    });
                    let link = document.createElement("a");
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "Incoming Supplies Report.xlsx";
                    link.click();
                    this.snackbar = {
                      active: true,
                      iconText: "check",
                      iconColor: "success",
                      message: "Successfully exported.",
                    };
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
              url: "/api/reports/incomingsupplies/get",
              method: "GET",
              responseType: "blob",
              params: {
                type: "pdf",
                category: this.category,
                from: this.incoming_from,
                to: this.incoming_to,
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
                  document.getElementById("print1").contentWindow.print();
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
        this.overlay = false;
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
  },
};
</script>