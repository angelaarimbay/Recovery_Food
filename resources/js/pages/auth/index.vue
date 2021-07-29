<template>
<v-card>
    <v-card-text>
     <v-tabs >
        <v-tab class="caption pl-0">
        <v-icon left>
          mdi-account
        </v-icon>
        Accounts
      </v-tab> 
      <v-tab class="caption  pl-0">
        <v-icon left>
          mdi-lock
        </v-icon>
        Permissions
      </v-tab>
      <v-tab class="caption  pl-0">
        <v-icon left>
          mdi-sort-variant
        </v-icon>
        List
      </v-tab>
      <v-tab-item>
        <v-card-text>
            <accounnts/>
        </v-card-text>
      </v-tab-item>
      <v-tab-item>
        <v-card flat>
          <v-card-text>
            <permissions/>
          </v-card-text>
        </v-card>
      </v-tab-item>
      <v-tab-item>
        <v-card flat>
          <v-card-text>
           test
          </v-card-text>
        </v-card>
      </v-tab-item>
    </v-tabs>
    </v-card-text>
</v-card>
</template>
<script> 
  import accounnts from  '../auth/accounts.vue'; 
  import permissions from  '../auth/permissions.vue';
export default { 
    setup() {
        
    },
    components: {
            accounnts, permissions 
    },
       
}
</script>
 