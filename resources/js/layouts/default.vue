<template>
  <div class="main-layout">
    <navbar /> 
    <div class="container">
      <child />
    </div>
  </div>
</template>

<script>
import Navbar from '~/components/Nav'

export default {
  
  middleware: "auth",
  name: 'MainLayout',

  components: {
    Navbar
  }
}
</script>
