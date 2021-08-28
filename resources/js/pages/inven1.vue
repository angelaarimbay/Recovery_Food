<template>
<div>
   <p class="text-h6">
      Masterlist Supplies  
    </p> 
        
    <p class="home">Home > </p> 

  <p class="masterlist">Masterlist Supplies
<p class="date">Date: </p>    
  
<p class="md">Month Date:</p>

<v-row justify="center">
    <v-dialog
      v-model="dialog"
      width="600px"
      height="400px"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn id="btn"
          color="blue"
          dark
          v-bind="attrs"
          v-on="on"
        >
        Add Masterlist Supply
        </v-btn>
      </template>





 <v-card>
   <v-card-title class="text-h5 grey lighten-2">
         Add Masterlist Supply
       </v-card-title>






<v-col>
  Supply Category
  <v-autocomplete
            label="Supply"
            solo
            dense
            required
             :rules="[() => !! supply|| 'This is required']"
            :items="supplies"
            placeholder="Select pack..."
          >
          </v-autocomplete>
</v-col>







      <v-col> <h5>Supply Name * </h5>
          <v-text-field
            label="Enter supply name"
            placeholder="Enter supply name"
            solo
            required
             :rules="[() => !!supply|| 'This is required']"
          >
          </v-text-field>
        </v-col>

 <v-col> <h5>Supply Description * </h5>
          <v-text-field
            label="Enter supply description"
            placeholder="Enter supply description"
            solo
             :rules="[() => !!description || '']"
          >
          </v-text-field>
        </v-col>

<v-col><h5>Unit * </h5>
 <v-autocomplete
            label="Pack"
            solo
            dense
            required
             :rules="[() => !! pack|| 'This is required']"
            :items="pack"
            placeholder="Select pack..."
          >
          </v-autocomplete>
        </v-col>

<v-col> <h5>Net Price * </h5>
 <v-text-field 
            label="Enter net price"
            solo
            dense
             :rules="[() => !!net ||'']"
            :items="net"
            placeholder="Enter net price"
          ></v-text-field>
        </v-col>
        
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn id="close"
            color="black"
            text
            @click="dialog = false"
          >
            Close
          </v-btn>

          <v-btn id="save"
          color="white" text
           
            @click="dialog = false"
          >
            Save Changes
          </v-btn>
        </v-card-actions>
      </v-card>


    </v-dialog>
  </v-row>
  
 <v-card class="p-3">  

 <v-card class="text-h7 grey lighten-2">

 <v-row class="p-3">
   <v-row no-gutters>

      


      
       <v-col>
          Number of Rows
      </v-col>
  <v-autocomplete
            solo
            dense
            ref="row"
             :rules="[() => !!row || 'This field is required']"
            :items="rows"
            placeholder="Select..."
            required
          ></v-autocomplete>

      





      <v-col>
         Category Filter
      </v-col>
       <v-autocomplete
            solo
            dense
             :rules="[() => !!category || '']"
            :items="category"
            placeholder="Dry Goods..."
            
          >
          </v-autocomplete>


      <v-col>
        Search:
      </v-col>
   <v-text-field
            solo
            dense
             :rules="[() => !!search || 'This field is required']"
            :items="search"
            placeholder="Supply Name..."
            required
          >
           
          
          </v-text-field>



   </v-row>
 </v-row>
       </v-card>
        <v-container> 
         <v-card-actions>     
                    </v-card-actions> 
                    <v-data-table>
                      
                    </v-data-table>
                </v-container>
    </v-card>
    
</div>
</template>




 



<style>
 .home{
  text-indent: 830px;
  position: relative;
bottom: 43px;}

.masterlist{
  position: relative;
  left:890px;
  bottom: 85px;
  font-size: 20px;
}
.date{
  text-indent: 830px;
  position: relative;
bottom: 90px;
left:90px;
}

.md{
 text-indent: 830px;
  position: relative;
bottom: 100px;
left:49px;
}
#btn{
  bottom: 150px;
  right: 411px;
}
#save{
  background-color: rgb(91, 156, 241);
}
#close{
  background-color: white;
}

.list{
  background-color: lightgray;
 bottom:510px;
 padding:10px;
}

.p-3{
  bottom: 110px;
}
</style>









<script>
import template from './template.vue'
  export default 
  components; { template }
    data () 
      return {
        dialog: false,
      }
</script>















<script>
  export default {
    data: () => ({
      supplies: [' sup 1', ' sup 2', 'sup 3', ' sup 4', ' sup 5', 'sup 6', 'sup 7', ' sup 9', 'sup 10'],
      formHasErrors: false,
    })}
</script>



<script>
  export default {
    data: () => ({
      rows: [' row 1', ' row 2', 'row 3', ' row 4', ' row 5', 'row 6', 'row 7', ' row 9', 'row 10'],
      formHasErrors: false,
    }),}

</script>