<template>
  <div style="min-width: 280px">
    <v-container>
      <v-layout row wrap>
        <h5 class="heading my-auto">Dashboard</h5>
        <v-spacer></v-spacer>
        <v-btn small icon @click="sheet = !sheet">
          <v-icon size="25" color="black">mdi-settings</v-icon>
        </v-btn>

        <v-bottom-sheet v-model="sheet" inset>
          <v-sheet
            class="text-center"
            height="150px"
            style="border-radius: 10px 10px 0px 0px"
          >
            <v-btn class="mt-6" text color="red" @click="sheet = !sheet">
              close
            </v-btn>
            <div class="py-3">
              This is a bottom sheet using the controlled by v-model instead of
              activator
            </div>
          </v-sheet>
        </v-bottom-sheet>
      </v-layout>
    </v-container>

    <v-container>
      <v-layout row wrap class="pb-1">
        <v-flex xs12 sm6 md4 lg3 xl3>
          <v-card
            elevation="6"
            style="
              border-radius: 10px;
              border-left: 20px solid #827717;
              white-space: nowrap;
              overflow: hidden;
            "
            class="ma-1 ma-sm-2 ma-md-3 ma-lg-3 ma-xl-3"
          >
            <v-card-title
              style="color: #827717"
              class="pb-0 h6"
              :class="{ 'justify-center': $vuetify.breakpoint.xsOnly }"
              >Total Raw Materials</v-card-title
            >
            <v-card-text class="pb-0">
              <div
                class="mb-0 h3 font-weight-bold black--text"
                :class="{ 'text-center': $vuetify.breakpoint.xsOnly }"
              >
                0
              </div>
            </v-card-text>
            <v-card-actions class="pt-0"
              ><v-btn
                text
                small
                class="ml-auto caption"
                :class="{ 'mx-auto': $vuetify.breakpoint.xsOnly }"
                style="text-transform: none"
                >View Info<v-icon small>mdi-arrow-right</v-icon></v-btn
              ></v-card-actions
            >
          </v-card>
        </v-flex>

        <v-flex xs12 sm6 md4 lg3 xl3>
          <v-card
            elevation="6"
            style="
              border-radius: 10px;
              border-left: 20px solid #827717;
              white-space: nowrap;
              overflow: hidden;
            "
            class="ma-1 ma-sm-2 ma-md-3 ma-lg-3 ma-xl-3"
          >
            <v-card-title
              style="color: #827717"
              class="pb-0 h6"
              :class="{ 'justify-center': $vuetify.breakpoint.xsOnly }"
              >Total Products</v-card-title
            >
            <v-card-text class="pb-0">
              <div
                class="mb-0 h3 font-weight-bold black--text"
                :class="{ 'text-center': $vuetify.breakpoint.xsOnly }"
              >
                0
              </div>
            </v-card-text>
            <v-card-actions class="pt-0"
              ><v-btn
                text
                small
                class="ml-auto caption"
                :class="{ 'mx-auto': $vuetify.breakpoint.xsOnly }"
                style="text-transform: none"
                >View Info<v-icon small>mdi-arrow-right</v-icon></v-btn
              ></v-card-actions
            >
          </v-card>
        </v-flex>

        <v-flex xs12 sm6 md4 lg3 xl3>
          <v-card
            elevation="6"
            style="
              border-radius: 10px;
              border-left: 20px solid #827717;
              white-space: nowrap;
              overflow: hidden;
            "
            class="ma-1 ma-sm-2 ma-md-3 ma-lg-3 ma-xl-3"
          >
            <v-card-title
              style="color: #827717"
              class="pb-0 h6"
              :class="{ 'justify-center': $vuetify.breakpoint.xsOnly }"
              >Total Purchase Orders</v-card-title
            >
            <v-card-text class="pb-0">
              <div
                class="mb-0 h3 font-weight-bold black--text"
                :class="{ 'text-center': $vuetify.breakpoint.xsOnly }"
              >
                0
              </div>
            </v-card-text>
            <v-card-actions class="pt-0"
              ><v-btn
                text
                small
                class="ml-auto caption"
                :class="{ 'mx-auto': $vuetify.breakpoint.xsOnly }"
                style="text-transform: none"
                >View Info<v-icon small>mdi-arrow-right</v-icon></v-btn
              ></v-card-actions
            >
          </v-card>
        </v-flex>

        <v-flex xs12 sm6 md4 lg3 xl3>
          <v-card
            elevation="6"
            style="
              border-radius: 10px;
              border-left: 20px solid #827717;
              white-space: nowrap;
              overflow: hidden;
            "
            class="ma-1 ma-sm-2 ma-md-3 ma-lg-3 ma-xl-3"
          >
            <v-card-title
              style="color: #827717"
              class="pb-0 h6"
              :class="{ 'justify-center': $vuetify.breakpoint.xsOnly }"
              >Total Users</v-card-title
            >
            <v-card-text class="pb-0">
              <div
                class="mb-0 h3 font-weight-bold black--text"
                :class="{ 'text-center': $vuetify.breakpoint.xsOnly }"
              >
                0
              </div>
            </v-card-text>
            <v-card-actions class="pt-0"
              ><v-btn
                text
                small
                class="ml-auto caption"
                :class="{ 'mx-auto': $vuetify.breakpoint.xsOnly }"
                style="text-transform: none"
                >View Info<v-icon small>mdi-arrow-right</v-icon></v-btn
              ></v-card-actions
            >
          </v-card>
        </v-flex>
      </v-layout>

      <v-divider
        style="border: 2px solid #bdbdbd; border-radius: 5px"
      ></v-divider>
    </v-container>
  </div>
</template>

<script>
export default {
  data: () => ({
    sheet: false,
  }),
};
</script>