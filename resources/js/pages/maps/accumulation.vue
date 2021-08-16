<template>
 <div> 
    <v-overlay :value="overlay">
            <v-progress-circular
                indeterminate
                size="64"> 
            </v-progress-circular>
        </v-overlay>
         <p class="text-h6 text--primary">
          <v-icon>mdi-transcribe</v-icon> Accumulation
        </p> 
    <v-card-text> 
        <v-row>
            <v-col lg="5">
                <v-card class="p-4 rounded-tr-xl"  > 
                    Current Accumulation Data as of: {{ getFormatDate(cresta_date,'MMMM D, YYYY') }}
                    <hr class="m-0">
                        <v-card flat >    
                            <v-text-field  v-model="cresta_search" label="Search Cresta ID"> </v-text-field>   
                            <v-card  flat style="overflow-y: auto;"  >
                                <v-data-table 
                                    :headers="cresta_headers" 
                                    :sort-by="['name']"
                                    :page.sync="page"
                                    :items="cresta_data" dense
                                    :search="cresta_search" 
                                    hide-default-footer
                                    :items-per-page="10" > 
                                        <template v-slot:[`item.our_si`]="{ item }">  
                                            <div class="text-right">      ₱ {{ item.our_si.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") }}</div>
                                        </template>

                                            <template v-slot:[`item.data`]="{ item }">  
                                            <v-hover v-slot="{ hover }" >
                                                <v-btn class="px-1" text :class="hover ? 'btn btn-info text-white':'btn btn-link text-info'"  small @click="getCompanyList(item)"  > 
                                                <v-icon>mdi-eye </v-icon>  
                                                </v-btn>
                                            </v-hover> 
                                        </template>   
                                </v-data-table> 
                            </v-card>
                            <hr>
                            <v-card-actions v-if="!cresta_search" class="p-0">
                                <v-pagination 
                                v-model="page"
                                :length="Math.ceil(cresta_data.length / 10)"
                                ></v-pagination>
                                <v-spacer></v-spacer>
                            </v-card-actions>  
                        </v-card> 
                </v-card>  
            </v-col>
            <v-col lg="7"> 
                <v-card flat class="pb-4" width="100%" height="400" id="mapout"></v-card>  
            </v-col>
        </v-row>
    </v-card-text>

    <v-dialog
        fullscreen
        hide-overlay
        transition="dialog-bottom-transition" 
        v-model="dialog_list"
    >         
        <v-card max-height="40" tile>
            <v-toolbar
                    flat
                    dark
                    color="primary"
                > 
                    <v-btn
                    icon
                    dark
                    @click="dialog_list = false"
                    >
                    <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Cresta Accumulation</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                  
                    </v-toolbar-items> 
            </v-toolbar>
            <br>
            <v-card-text>
                <v-row>
                    <v-col lg="12">      
                        <div class="h4">Cresta ID: {{ cresta_selected.cresta_id }}</div>
                        <div   >View Location in <a class="pl-0"  @click="callmap"  style="text-transform: none;">Google Map</a></div>
                        <v-text-field  v-model="company_search" label="Search Company"> </v-text-field>  
                        <v-data-table 
                            :headers="company_headers"  
                            :page.sync="page"
                            :items="company_data" dense
                            :search="company_search"  
                            :items-per-page="10" >  
                                        <template v-slot:[`item.our_si_or`]="{ item }">  
                                            <div class="text-right">  ₱ {{ item.our_si_or.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") }}</div>
                                        </template>
                                        <template v-slot:[`item.our_si_tty`]="{ item }">  
                                            <div class="text-right">  ₱ {{ item.our_si_tty.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") }}</div>
                                        </template>
                                        <template v-slot:[`item.our_si_fac`]="{ item }">  
                                            <div class="text-right">  ₱ {{ item.our_si_fac.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") }}</div>
                                        </template>



                                    <template v-slot:[`item.data`]="{ item }">  
                                    <v-hover v-slot="{ hover }" >
                                        <v-btn class="px-1" text :class="hover ? 'btn btn-info text-white':'btn btn-link text-info'"  small @click="initMap()"  > 
                                        <v-icon>mdi-eye</v-icon>
                                        <small> - View </small>   
                                        </v-btn>
                                    </v-hover> 
                                </template>   
                        </v-data-table>  
                    </v-col> 
                </v-row>
                <v-divider></v-divider> 
                    <v-card-text> 
                        <div class=" h4">Total Accumulation:  ₱ {{ cresta_selected.our_si.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") }}</div>
                    </v-card-text>  
            </v-card-text>
        </v-card>     
    </v-dialog>
 
        <v-dialog v-model="map_dialog" width="1100" >   
            <v-card>
            <v-card-title class="text-h5 grey lighten-2">
               Google Map
            </v-card-title>

            <v-card  class="pb-4" width="100%" height="400" id="mapin"></v-card>  
            <v-divider></v-divider>
                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                color="blue darken-1"
                text
                @click="map_dialog = false"
                >
                Close
                </v-btn> 
                </v-card-actions>
            </v-card> 
        </v-dialog>

 
   </div> 
</template>   
<script>   
import axios from 'axios' 
import Scriptjs from 'scriptjs';  
var  map, mapin, mapout;
export default {
       name: "Map",
       map: '', 
        data: () => ({
            map: null, 
            page:1,  
            overlay: true,
            cresta_selected:{ our_si: ''}, 
            dialog_list: false,
            dialog_sub: false,
            map_dialog: false,

            cresta_search: '',
            cresta_headers: [  
            {class:'border', text: 'Cresta ID',  value: 'cresta_id' }, 
            {class:'border', text: 'Our Sum Insured', value: 'our_si' },  
            {class:'border', text: 'Action', value: 'data' },   
            ],
            cresta_data: [],
            cresta_gps: '',
            cresta_date: '',

            company_search: '',
            company_headers: [  
            {class:'border', text: 'Company name',  value: 'insured' }, 
            {class:'border', text: 'Our SI Retention', value: 'our_si_or' },  
            {class:'border', text: 'Our SI Treaty', value: 'our_si_tty' },  
            {class:'border', text: 'Our SI Facul', value: 'our_si_fac' },  
            {class:'border', text: 'Information Sheet', value: 'data' },    
            ],
            company_data: [],
            
        }),
        created(){
            this.getList()
        }, 
        methods: {
            callmap(){ 
                this.map_dialog = true
                this.initMap(13,1);
            },

        
            initMap(zooms,type){  
                Scriptjs("https://maps.googleapis.com/maps/api/js?key=AIzaSyDWsOP0trKOpMqg5zDI_3WitmyNRA3JDBs&libraries=places", () => {
                 
                const myLatLng =   this.cresta_gps[0][0] ;
                if (type === 1) {
                    mapin = new google.maps.Map(document.getElementById("mapin"), {
                    center: myLatLng, zoom: zooms
                     ,mapTypeId: 'roadmap'
                    })  
                }else{
                    mapout = new google.maps.Map(document.getElementById("mapout"), {
                        center: myLatLng, zoom: zooms
                        ,mapTypeId: 'roadmap'
                    })  
                }
            
               if(type === 1){
                   map = mapin;
               }else{
                   map = mapout;
               }
                const infoWindow = new google.maps.InfoWindow(); 
                    this.cresta_gps.forEach(([position, title], i) => {
                        
                        const marker = new google.maps.Marker({
                        position,
                        map,  
                        title,
                        // label: `${i + 1}`,
                        optimized: false,
                        });
                        // Add a click listener for each marker, and set up the info window.
                        marker.addListener("click", () => {
                        infoWindow.close();
                        infoWindow.setContent(marker.getTitle());
                        infoWindow.open(marker.getMap(), marker);
                        });
                    })
                }); 
 
            },
             
            async getList(){
                let self = this;
                await axios.get("/api/get/accumulation/list")
                .then(result =>{   
                    self.cresta_date = result.data.date
                    self.cresta_data  = result.data.data 
                    self.cresta_gps = result.data.gps 
                    self.overlay = false
                }).catch(res=>{
                    self.overlay = false
                });
            }, 
            async getCompanyList(value){
               
                this.overlay = true
                let self = this;
                await axios.get("/api/get/accumulation/company/list",{params:{ cresta: value.cresta_id }})
                .then(result =>{     
                    this.dialog_list = true
                    this.cresta_selected = value 
                    self.company_data  = result.data.data 
                    self.cresta_gps = result.data.gps
                    this.overlay = false 
                }).catch(res=>{
                    this.overlay = false
                });
            }, 
            getFormatDate(e, format) {
                const date = moment(e);
                return date.format(format);
            },
        }
}
</script>