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
  <h5>Supply Category *</h5>
 <v-autocomplete
            ref="supply"
            solo 
            dense
            :rules="[() => !!supply || 'This field is required']"
            :items="supplies"
            label="Dry Goods"
            placeholder="Select..."
            required="[(a,b,c,d)]"
          ></v-autocomplete>
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

<v-col>
  <h5>Unit *</h5>
 <v-autocomplete
            ref="unit"
            solo 
            dense
            :rules="[() => !!unit || 'This field is required']"
            :items="units"
            label="Pack"
            placeholder="Select..."
            required
          ></v-autocomplete>
</v-col>

<v-col
   cols="12"
          sm="6"
          md="5"
        >
        <h5> Net Price * </h5>
 <v-text-field
            label="Enter net price"
            solo
            dense
             :rules="[() => !!net ||'']"
            :items="net"
            placeholder="Enter net price"
          >
          </v-text-field>
        </v-col>




<v-coL>
     <h5>Price W/O VAT </h5>
 <v-text-field
            placeholder="0"
            outlined
          ></v-text-field>
</v-coL>


<v-col>
  <h5>Status *</h5>
 <v-autocomplete
            ref="status"
            solo 
            dense
            :rules="[() => !!status || 'This field is required']"
            :items="status"
            label="Active"
            required
          ></v-autocomplete>
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
           
            @click="dialaog = false"
          >
            Save Changes
          </v-btn>
        </v-card-actions>
      </v-card>


    </v-dialog>
  </v-row>
  
  
 <v-card class="p-3">

 <v-card class="text h7 grey lighten-2">

 <v-row class="p-1">
   <v-row no-gutters>

      





      
       <v-col class="text1">
        Number of rows:
      </v-col>
  <v-autocomplete class="nrows"
  flat
            solo
            dense
            ref="row"
             :rules="[() => !!row || '']"
            :items="rows"
            placeholder=""
            
            
          >
          
          </v-autocomplete>

      <v-col class="text2">
         Category Filter:
      </v-col>
       <v-autocomplete class="filter"
       flat
            solo
            dense
             :rules="[() => !!category || '']"
            :items="categories"
            placeholder="Dry Goods..."
          >
          </v-autocomplete>
      <v-col class="text3">
        Search:
      </v-col>
   <v-autocomplete class="srch"
            solo
            flat
            dense
             :rules="[() => !!search || 'This field is required']"
            :items="search"
            placeholder="Supply Name..."
            required
          >
   </v-autocomplete>

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


.nrows{
  max-width:80px;
  right: 50px;
 

  
}

.filter{
  width: 0px;
  right: 40px;
  
}

.srch{
  width: 10px;
  right:30px;

}
.text1{
  left:30px;
}

.text2{
left: 43px;
}

.text3{
  left:105px;
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
      supplies: ['supply 1', 'supply 2', 'supply 3', 'supply 4', 'supply 5' ],
      errorMessages: '',
     units: ['unit 1', 'unit 2', 'unit 3', 'unit 4', 'unit 5' ],
      errorMessages: '',
        rows: ['row 1', 'row 2', 'row 3', 'row 4', 'row 5' ],
      errorMessages: '',
       status: ['Active', 'Inactive'],
      errorMessages: '',
        categories: ['Mamou', 'Utensils','Mamou rf'],
      errorMessages: '',
  
    }
    ),

  }
</script>


