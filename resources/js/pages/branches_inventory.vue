<template>
  <div style="min-width: 280px">
    <v-container>
      <v-layout row wrap>
        <h5 class="heading my-auto">Branches</h5>
        <v-spacer></v-spacer>
        <v-breadcrumbs class="p-1" :items="items"></v-breadcrumbs>
      </v-layout>
    </v-container>

    <v-card class="mt-2" style="border-radius: 10px">
      <v-container>
        <v-container>
          <v-row no-gutters>
            <v-col
              cols="6"
              xl="2"
              lg="2"
              md="6"
              sm="6"
              class="py-1 px-xl-2 px-lg-2 px-md-1 px-sm-1 px-1"
            >
              <v-combobox clearable dense label="Branch"> </v-combobox>
            </v-col>

            <v-col
              cols="6"
              xl="2"
              lg="2"
              md="6"
              sm="6"
              class="py-1 px-xl-2 px-lg-2 px-md-1 px-sm-1 px-1"
            >
              <v-combobox clearable dense label="Inventory"> </v-combobox>
            </v-col>

            <v-spacer></v-spacer>

            <v-col
              cols="6"
              xl="2"
              lg="3"
              md="6"
              sm="6"
              class="py-1 px-xl-2 px-lg-2 px-md-1 px-sm-1 px-1"
            >
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
                    class="py-0"
                    dense
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="dateFrom"
                  @input="date1 = false"
                  scrollable
                ></v-date-picker>
              </v-menu>
            </v-col>

            <v-col
              cols="6"
              xl="2"
              lg="3"
              md="6"
              sm="6"
              class="py-1 px-xl-2 px-lg-2 px-md-1 px-sm-1 px-1"
            >
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
                    class="py-0"
                    dense
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="dateUntil"
                  @input="date2 = false"
                  scrollable
                ></v-date-picker>
              </v-menu>
            </v-col>
          </v-row>
        </v-container>
      </v-container>
    </v-card>
  </div>
</template>

<script>
export default {
  data: () => ({
    items: [
      {
        text: "Home",
        disabled: false,
        to: "/dashboard",
      },
      {
        text: "Branches Inventory",
        disabled: true,
      },
    ],
    dateFrom: new Date().toISOString().substr(0, 10),
    dateUntil: new Date().toISOString().substr(0, 10),
    date1: false,
    date2: false,
  }),
};
</script>