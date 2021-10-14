<template>
  <div class="main-layout">
    <navbar />  
    <div :class="(this.$router.history['_startLocation'] == '/posmenu'?'':'container')"> 
      <child />
    </div> 
     
  </div>
</template>

<script>
import Navbar from '~/components/Nav' 
import { mapGetters } from "vuex";  
export default {
  
  middleware: "auth",
  name: 'MainLayout',

  components: {
    Navbar 
  },
   computed: mapGetters({
    user: "auth/user",
  }), 
}
</script>
