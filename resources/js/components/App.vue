<template>
  <v-app class="bg-light">  <loading ref="loading" />
   
    <v-main>
        <transition name="page" mode="out-in">
        <component :is="layout" v-if="layout" />
      </transition>
    </v-main>
    <!-- <v-btn v-if="user" fab dark color="#cc0033" fixed right bottom>
        <v-badge top color="green" content="0">
          <v-icon>mdi-bell</v-icon>
        </v-badge>
    </v-btn> --> 
    <br>
    <br>
    <br>
    <v-footer
      absolute
      class="font-weight-light"
    >
      <v-col
        class="text-center text-subtitle"
        cols="12"
      >
        <strong>Powered by: Digitech</strong>
      </v-col>
    </v-footer>
  </v-app>
</template>
<style lang="scss"> /** don't remove, used in all tabpages, for responsive tab item */
  .v-slide-group__prev {
    display: none !important;
  }
  .v-slide-group__wrapper{
    width: 400px;
    overflow-x: auto;
  }
</style>
<script> 
import Loading from './Loading'
import { mapGetters } from 'vuex'
// Load layout components dynamically.
const requireContext = require.context('~/layouts', false, /.*\.vue$/)

const layouts = requireContext.keys()
  .map(file =>
    [file.replace(/(^.\/)|(\.vue$)/g, ''), requireContext(file)]
  )
  .reduce((components, [name, component]) => {
    components[name] = component.default || component
    return components
  }, {})

export default {
  el: '#app',
  components: {
    Loading
  },

  data: () => ({
    layout: null,
    defaultLayout: 'default'
  }),
  computed: mapGetters({
    user: 'auth/user'
  }),
  metaInfo () {
    const { appName } = window.config

    return {
      title: appName,
      titleTemplate: `%s · ${appName}`
    }
  },

  mounted () {
    this.$loading = this.$refs.loading
  },

  methods: {
    /**
     * Set the application layout.
     *
     * @param {String} layout
     */
    setLayout (layout) {
      if (!layout || !layouts[layout]) {
        layout = this.defaultLayout
      }

      this.layout = layouts[layout]
      
    }
  }
}
</script>
