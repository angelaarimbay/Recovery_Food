<template>
<div>
    <v-app-bar height="40" app>
       <v-app-bar-nav-icon  @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>GIS</v-toolbar-title>

      <v-spacer></v-spacer>
 

      <v-btn icon>
        <v-icon color="blue">mdi-bell</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon color="danger">mdi-logout</v-icon>
      </v-btn>
 
  </v-app-bar>
 <v-navigation-drawer 
        app
        v-model="drawer"
       
    >
      <template v-slot:prepend>
        <v-list-item> 
          <v-list-item-content>
            <v-img src="/img/pgasompo.png"></v-img>
          </v-list-item-content>
        </v-list-item>
      </template>

      <v-divider></v-divider>
 


    <v-list>
        <v-list-item to="/dashboard">
          <v-list-item-icon>
            <v-icon size="19" class="text-danger">mdi-view-dashboard</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title >Dashboard</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item to="/accumulation">
          <v-list-item-icon>
            <v-icon size="19" class="text-danger">mdi-transcribe</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title >Accumulation</v-list-item-title>
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

<script>
  export default {
    data () {
      return {
        drawer: true, 
      }
    },
  }
</script>