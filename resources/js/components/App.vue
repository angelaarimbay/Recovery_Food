<template> 
<v-app>
  <nv/>  
123
  <!-- Sizes your content based upon application components -->
  <v-main>

    <!-- Provides the application the proper gutter -->
    <v-container fluid>  
      <!-- If using vue-router -->
      <router-view></router-view>
    </v-container>
  </v-main>

   <ft/> 
</v-app> 
    
</template>
<script>  
  import nv from '../components/Nav.vue';
  import ft from '../components/Footer.vue';
    export default {
        mounted() {
            console.log('Component mounted.')
        }, 
        components: {
            nv, ft 
        },
       
    }
</script>
