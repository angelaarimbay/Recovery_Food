<template>
<div>
    <v-app-bar height="60" dark color="danger" app>
       <v-app-bar-nav-icon  @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

 
       Recovery Food Management System 

      <v-spacer></v-spacer>
     <v-menu offset-y>
      <template v-slot:activator="{ on, attrs }">
        <v-btn 
          dark
          text
          v-bind="attrs"
          v-on="on"
        >
          <v-icon class="round">mdi-account</v-icon> <small>Account</small>
        </v-btn>
      </template>
      <v-list>
        <v-list-item >
          <v-list-item-title>Menu 1 </v-list-item-title> 
        </v-list-item>
         <v-list-item >
          <v-list-item-title>Menu 2 </v-list-item-title> 
        </v-list-item>
         <v-list-item >
          <v-list-item-title>Menu 3 </v-list-item-title> 
        </v-list-item>
      </v-list>
    </v-menu>
  </v-app-bar>
 <v-navigation-drawer 
        app
        v-model="drawer"
       
    >
      <template v-slot:prepend>
        <v-list-item class="p-0 m-0"> 
          <v-list-item-content class="test-background">
            <v-img class="mx-auto" max-height="50" max-width="50" src="/img/logo.jpg"></v-img>
          </v-list-item-content>
        </v-list-item>
      </template>

      <v-divider></v-divider>
 


    <v-list>
      
        <v-list-item   style="text-decoration: none "  to="/dashboard">
          <v-list-item-icon>
            <v-icon size="19" class="text-danger">mdi-view-dashboard</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <span>12222322222222222</span>
          </v-list-item-content>
        </v-list-item>
      
          <v-list-item link style="text-decoration: none " :to='{ name: "home"}'>
          <v-list-item-icon>
            <v-icon size="19" class="text-danger">mdi-transcribe</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
              Cyrus page  
          </v-list-item-content>
        </v-list-item>





        <v-list-group no-action >
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon size="19" class="text-danger">mdi-link</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title > Links</v-list-item-title>
            </v-list-item-content>
          </template>
         
          <v-list-item  class="pl-4 ml-4" :to="'/maps/googlemap'" >
             <v-list-item-icon>
              <v-icon size="19" class="text-danger">mdi-map</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title > Google Map</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item class="pl-4 ml-4"  :to="'#'" onclick="window.open(`https://hazardhunter.georisk.gov.ph/#`,'_blank')"> 
            <v-list-item-icon>
              <v-icon size="19" class="text-danger">mdi-link</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title > HazardHunter.PH </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>


        <v-list-group no-action >
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon size="19" class="text-danger">mdi-server-security</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title > Settings</v-list-item-title>
            </v-list-item-content>
          </template>
         
          <v-list-item  class="pl-4 ml-4"  :to="'/auth/index'" >
             <v-list-item-icon>
              <v-icon size="19" class="text-danger">mdi-account-key</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title > Account </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item  class="pl-4 ml-4"  :to="'/auth/index'" >
             <v-list-item-icon>
              <v-icon size="19" class="text-danger">mdi-account-key</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title > Change Password </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item  class="pl-4 ml-4"  :to="'/auth/index'" >
             <v-list-item-icon>
              <v-icon size="19" class="text-danger">mdi-security</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title > Permissions </v-list-item-title>
            </v-list-item-content>
          </v-list-item>  
        </v-list-group> 
    </v-list>







    </v-navigation-drawer>

</div>
</template>
<style>
  .coloroffont{
    color: blue;
  }
</style>
<script>
  export default {
    data () {
      return { 
        drawer: true,  
      }
    },
  }
</script>