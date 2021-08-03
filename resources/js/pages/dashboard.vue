<template>
<div>
    <v-overlay :value="overlay">
        <v-progress-circular
            indeterminate
            size="64">
            <v-img src=""></v-img>
        </v-progress-circular>
    </v-overlay> 
        <p class="text-h6 text--primary">
          <v-icon>mdi-view-dashboard</v-icon> Dashboard
        </p> 





    <v-card flat   >    
        <v-card-text>
            <v-row>
                <v-col lg="12"> 
                     <v-row>
                        <!--  <v-col lg="7">
                            <v-row  no-gutters>  
                               <v-col v-for="(a, i) in btns" xl="3" sm="6" cols="6" md="4" lg="3" class="p-1 m-0" :key="i"> 
                                    <v-hover v-slot="{ hover }" > 
                                        <v-card outlined class="btn btn-block btn-sm" :to="a.route"  :color="hover ? '#cc0022' : ''" style="text-decoration:none">
                                            <v-card-title class="m-0 p-0 pb-0 justify-center" >
                                                <v-icon size="25" :color="hover ? 'white' : '#cc0033'"> {{ a.icon }} </v-icon>
                                            </v-card-title>
                                            <v-card-text  class="m-0 p-0 pt-0 justify-center text-center text-caption" :class="hover ? 'text-white': ''">
                                            <small> {{ a.name }} </small>
                                            </v-card-text>
                                        </v-card>   

                                    </v-hover>
                                </v-col>    
                            </v-row>  
                        </v-col> -->
                        <v-col lg="6">
                            <v-card class="p-2" >
                                Current Accumulation data 
                                <v-divider class="m-1"/>
                                <!-- pag nka card-actions ka inline sya meaning pag may button
                                ung card mo na magkakasama jan mo lalagay in one row sya
                                since ginamit to tlgang mag mimissplace sya kahit gamitan natin
                                yang ng row col one line padin sya. 
                                paltan natin ng card-text
                                 -->
                                <v-card-text>
                                    <!-- ito ung datepicker -->
                                    <v-menu
                                        ref="menu"
                                        v-model="menu"
                                        :close-on-content-click="false"
                                        :return-value.sync="date"
                                        transition="scale-transition"
                                        offset-y
                                        min-width="auto"
                                        >
                                        <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            v-model="date" 
                                            prepend-icon="mdi-calendar"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                        ></v-text-field>
                                        </template>
                                        <v-date-picker
                                        v-model="date"
                                        no-title
                                        scrollable
                                        >
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            text
                                            color="primary"
                                            @click="menu = false"
                                        >
                                            Cancel
                                        </v-btn>
                                        <v-btn
                                            text
                                            color="primary"
                                            @click="$refs.menu.save(date)"
                                        >
                                            OK
                                        </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                    <!-- ito ung button na green -->
                                    <!-- para mag responsive sya at bumaba -->
                                    <v-row>
                                        <v-col>
                                        <v-btn small class="primary">Retrieve</v-btn>  
                                        </v-col>
                                        <v-col>
                                        <!-- ito ung upload -->
                                            <v-btn
                                                text
                                                outlined
                                                color="primary"
                                                class="btn "
                                                @click="clickupload"
                                                ><v-icon>mdi-upload</v-icon> Upload File
                                            </v-btn>
                                            <input
                                                ref="uploader" 
                                                type="file"
                                                class="d-none"
                                                clearable="true"
                                                @change="uploadimages"
                                            /> 
                                        </v-col>
                                    </v-row>
                                            <v-text-field
                                                style="display: none" 
                                                v-model="form.filename"
                                                label="Document"
                                            ></v-text-field>
                                     
                                  </v-card-text>
                                     
                            </v-card>
                        </v-col>   
                        <v-col lg="6">
                               <v-card class="p-2" height="120">
                                 Quck Search
                                 <v-divider class="m-1"/> 
                                <v-card-actions>
                                    <v-text-field prepend-icon="mdi-magnify"  label="search company"> </v-text-field>     
                                    <v-btn small class="primary">Search</v-btn>
                                </v-card-actions>       
                                </v-card>
                        </v-col>
                    </v-row>
                    <v-row> 
                       <v-col lg="6" >
                             <v-row>
                                <v-col lg="12" >
                                    <diageq />  
                                </v-col> 
                                <v-col lg="12" >
                                    <diagfl/>  
                                </v-col> 
                             </v-row>
                             <!-- <v-row>
                                <v-col lg="6" >
                                </v-col> 
                                <v-col lg="6" > 
                                </v-col> 
                             </v-row> -->
                       </v-col>
                        <v-col lg="6" >
                           
                             <top/>
                        </v-col>     
                    </v-row>
                    
                </v-col>
              
            </v-row>
        </v-card-text>
    </v-card>
    <br>
  <v-row> 
                <v-col lg="4" cols="12" >
            
                </v-col> 
                    <v-col lg="4" cols="12" >
                </v-col> 
            </v-row> 

        
</div>
</template> 
<script>
import axios from 'axios'
import quicksearch from '../pages/dashboard/quicksearch.vue'
import top from '../pages/dashboard/top.vue'
import diagty from '../pages/dashboard/diagram-ty.vue' 
import diagfl from '../pages/dashboard/diagram-fl.vue' 
import diageq from '../pages/dashboard/diagram-eq.vue' 
import diagtsi from '../pages/dashboard/diagram-tsi.vue' 

export default {
     data: () => ({  
        data:'',
        isSelecting:'',
        date: new Date().toISOString().substr(0, 10),
        menu: false,
        form: { filename: '' },
        overlay: true, 
         btns: [
          { name: 'Quick Search', icon: 'mdi-account', route: 'myprofile' },
          { name: 'Google Map', icon: 'mdi-clock' , route: 'timelogs/list' },
          { name: 'HazardHunter', icon: 'mdi-account-remove' , route: 'leave/index' },  
        ], 
        }),
   created () {   
        setTimeout(() => {
            this.overlay = false
        }, 500) 
    },   
    components:{
        quicksearch,top,diagty,diagfl,diageq,diagtsi
    },
    methods: {    
       clickupload() {
        this.isSelecting = true;
        window.addEventListener(
            "focus",
            () => {
            this.isSelecting = false;
            },
            { once: true }
        );
        this.$refs.uploader.click();
        },
        async uploadimages(e){  
        // upload multiple images 
                var dataform = new FormData();
                dataform.append('file',  e.target.files[0]);
                await axios.post('/api/upload/accumulation/excel', dataform, {
                headers: { "Content-Type": "multipart/form-data" },
                })
                .then(result=>{    
                 this.form.filename = result.data.filename
                });
        },   
        deletefile() {
            this.$refs.uploader.value = null;
            this.form.filename = null; 
        },
    },
    
}
</script>