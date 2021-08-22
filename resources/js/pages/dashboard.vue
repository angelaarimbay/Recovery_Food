<template>
  <div>
    <p class="text-h6">
      <v-icon size="30">mdi-view-dashboard</v-icon>Dashboard
    </p>

 vuetify<br>
<v-btn color="red">test</v-btn><br>
vuetify then hex color code<br>
<!-- iba ung red tlga na hex. sample ko lang yan -->
<v-btn color="#cc0022">test</v-btn><br> 
typical way inline style<br>
<v-btn style="background-color: red;">test</v-btn><br>
via id then style called<br>
 <v-btn id="color">test</v-btn><br>
via bootstrap coding<br>
  <v-btn class="bg-danger">test</v-btn><br>
or via class depende sa iyo<br>

<!--  -->
<div class="mycustomcolor">test</div><br>
 

  </div>
</template> 
<style  scoped>
 
  #color{
    background-color: red;
  }
  .mycustomcolor{
    background-color: red;

  }
</style>
<script>

</script>