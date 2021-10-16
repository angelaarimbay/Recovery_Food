<template>
  <div class="main-layout">
    <navbar />   
      
      <child :class="class_cont"/>  
  </div>
</template>

<script>
import Navbar from '~/components/Nav' 
import { mapGetters } from "vuex";  
import Child from '../components/Child.vue';
export default {
  
  middleware: "auth",
  name: 'MainLayout',

  components: {
    Navbar,
    Child 
  },
   computed: mapGetters({
    user: "auth/user",
    class_cont: 'check_layout/class_container'
  }),   
}
</script>
