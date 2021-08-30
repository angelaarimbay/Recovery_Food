<template>
  <div style="min-width: 280px">
    <v-container>
      <v-layout row wrap>
        <h5 class="heading my-auto">Branches</h5>
        <v-spacer></v-spacer>
        <v-card-actions class="px-0">
          <v-btn
            plain
            small
            v-ripple="false"
            to="/dashboard"
            class="px-0"
            style="text-decoration: none; text-transform: none; font-size: 11px"
            >Home</v-btn
          >
          /
          <v-btn
            small
            text
            disabled
            class="px-0"
            style="text-transform: none; font-size: 11px"
            >Branches Info</v-btn
          >
        </v-card-actions>
      </v-layout>
    </v-container>

    <v-container>
      <v-layout row wrap>
        <v-card elevation="6" style="border-radius: 10px" class="mt-2">
          <v-row no-gutters>
            <v-col
              cols="12"
              xl="7"
              lg="7"
              md="12"
              sm="12"
              class="pl-xl-3 pl-lg-2"
            >
              <v-card-title
                class="font-weight-bold py-xl-10 py-lg-10 py-md-6 py-sm-6 py-4"
                :class="{
                  'body-2': $vuetify.breakpoint.xsOnly,
                  h4: $vuetify.breakpoint.smOnly,
                  h4: $vuetify.breakpoint.mdonly,
                  h3: $vuetify.breakpoint.lgAndUp,
                  'justify-center': $vuetify.breakpoint.smAndDown,
                }"
                style="color: #827717"
              >
                Recovery Food - Crossroad BGC
              </v-card-title>
              <v-card-text
                class="font-weight-bold py-lg-3 py-md-2 py-sm-1 py-1"
                :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
              >
                Location:
              </v-card-text>
              <v-card-text
                class="font-weight-bold py-lg-3 py-md-2 py-sm-1 py-1"
                :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
              >
                Contact Number:
              </v-card-text>
              <v-card-text
                class="font-weight-bold py-lg-3 py-md-2 py-sm-1 py-1"
                :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
              >
                Email Address:
              </v-card-text>
            </v-col>

            <v-col
              cols="12"
              xl="5"
              lg="5"
              md="12"
              sm="12"
              class="pr-xl-2 pr-lg-1"
            >
              <v-img
                src="/img/branch_1.jpg"
                max-height="250"
                class="ma-3 ma-sm-4"
                style="border-radius: 10px"
              ></v-img>
            </v-col>
          </v-row>
        </v-card>
      </v-layout>
    </v-container>
  </div>
</template>