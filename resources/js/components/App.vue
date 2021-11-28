<template>
  <v-app style="background-color: #f0f2f5">
    <loading ref="loading" />
    <div v-if="!user">
      <!-- If no user, apply this header. Else, apply nav -->
      <v-card flat tile height="48px" color="red darken-2"> </v-card>
    </div>

    <v-main>
      <component :is="layout" v-if="layout" />
    </v-main>

    <ft />
  </v-app>
</template>

<script>
import ft from "./Footer";
import Loading from "./Loading";
import axios from "axios"; //Library for sending api request
import { mapGetters } from "vuex";
//Load layout components dynamically.
const requireContext = require.context("~/layouts", false, /.*\.vue$/);

const layouts = requireContext
  .keys()
  .map((file) => [file.replace(/(^.\/)|(\.vue$)/g, ""), requireContext(file)])
  .reduce((components, [name, component]) => {
    components[name] = component.default || component;
    return components;
  }, {});

export default {
  el: "#app",
  components: {
    Loading,
    ft,
 
  },
  //Data
  data: () => ({
    layout: null,
    temppath: "",
    defaultLayout: "default",
  }),

  //Computed
  computed: mapGetters({
    user: "auth/user",
  }),

  metaInfo() {
    const { appName } = window.config;

    return {
      title: appName,
      titleTemplate: `%s | ${appName}`,
    };
  },

  created() {
    this.getLogo();
    this.$store.commit("check_layout/container", "container");
  },

  mounted() {
    this.$loading = this.$refs.loading;
  },

  //Methods
  methods: {
    async getLogo() {
      await axios.get("/api/settings/company/logo/get").then((result) => {
        this.temppath = result.data.path;
      });
    },

    /**
     * Set the application layout.
     *
     * @param {String} layout
     */
    setLayout(layout) {
      if (!layout || !layouts[layout]) {
        layout = this.defaultLayout;
      }

      this.layout = layouts[layout];
    },
  },
};
</script>



