<template> 
<v-card>
    <v-card-text> 
    <v-row> 
        <v-col lg="8">             
            <input id="pac-input" placeholder="Search" class="text-form block" style="font-size: 25px; padding: 5px; margin: 10px; background-color: white;  width: 70%;" type="text"> 
            <v-card width="100%" height="600" id="map"></v-card> 
        </v-col>
        <v-col lg="4">
                
            <v-card class="p-4 rounded-tr-xl"> 
                    <hr class="m-0">
                <v-card flat >    
                    <v-text-field  v-model="search" label="Search Company"> </v-text-field>   
                    <v-card  flat style="overflow-y: auto;"  >
                        <v-data-table 
                            :headers="headers" 
                            :sort-by="['name']"
                            :page.sync="page"
                            :items="data" dense
                            :search="search" 
                            hide-default-footer
                            :items-per-page="10" > 
                                    <template v-slot:[`item.iron`]="{ item }">  
                                    <v-hover v-slot="{ hover }" >
                                        <v-btn class="px-1" text :class="hover ? 'btn btn-info text-white':'btn btn-link text-info'"  small @click="dialog = true"  > 
                                        <v-icon> mdi-go </v-icon> 
                                        <small> - View </small>   
                                        </v-btn>
                                    </v-hover> 
                                </template>   
                        </v-data-table> 
                    </v-card>
                    <hr>
                    <v-card-actions v-if="!search" class="p-0">
                        <v-pagination 
                        v-model="page"
                        :length="Math.ceil(data.length / 6)"
                        ></v-pagination>
                        <v-spacer></v-spacer>
                    </v-card-actions> 


                    <!-- dialog -->

                    <v-dialog
                        transition="dialog-top-transition"
                        max-width="600"
                        v-model="dialog"
                    > 
                    
                        <v-card>
                            <v-toolbar color="danger" dark >Accumulation Details</v-toolbar>
                            <br>
                            <v-card-text>
                                <div class="text-h5">Company name</div><br>         
                            <v-row>
                                <v-col class="p-0 pl-2 border-bottom" xl="4">test</v-col>
                                <v-col class="p-0 pl-2 border-bottom"  xl="4">test</v-col>
                                <v-col class="p-0 pl-2 border-bottom"  xl="4">test</v-col>
                            </v-row>
                            <v-row>
                                <v-col class="p-0 pl-2 border-bottom" xl="4">test</v-col>
                                <v-col class="p-0 pl-2 border-bottom"  xl="4">test</v-col>
                                <v-col class="p-0 pl-2 border-bottom"  xl="4">test</v-col>
                            </v-row>
                            <v-row>
                                <v-col class="p-0 pl-2 border-bottom" xl="4">test</v-col>
                                <v-col class="p-0 pl-2 border-bottom"  xl="4">test</v-col>
                                <v-col class="p-0 pl-2 border-bottom"  xl="4">test</v-col>
                            </v-row>
                            </v-card-text>
                            <v-card-actions class="justify-end">
                            <v-btn
                                text
                                @click="dialog = false"
                            >Close</v-btn>
                            </v-card-actions>
                        </v-card> 
                    </v-dialog>

            

                </v-card>
            </v-card>

        </v-col>
    </v-row>
</v-card-text>


 

</v-card> 
</template>
<script>
import Scriptjs from 'scriptjs'; 
import quicksearch from '../dashboard/quicksearch.vue'
var map;
    export default {
        name: "Map",
        data: () => ({  
            map: null,
            page:1, 
            dialog: false,
            search: '',
            headers: [  
            {class:'border', text: 'Company',  value: 'name' }, 
            {class:'border', text: 'Action', value: 'iron' },  
            ],
            data: [
            {
                name: 'Frozen Yogurt', 
                iron: '1%',
            },
            {
                name: 'Ice cream sandwich Ice cream sandwich Ice cream sandwich', 
                iron: '1%',
            },
            {
                name: 'Eclair', 
                iron: '7%',
            },
            {
                name: 'Cupcake', 
                iron: '8%',
            },
            {
                name: 'Gingerbread', 
                iron: '16%',
            },
            {
                name: 'Jelly bean', 
                iron: '0%',
            },
            {
                name: 'Lollipop', 
                iron: '2%',
            },
            {
                name: 'Honeycomb', 
                iron: '45%',
            },
            {
                name: 'Donut', 
                iron: '22%',
            },
            {
                name: 'KitKat', 
                iron: '6%',
            },
            {
                name: 'KitKat', 
                iron: '6%',
            },
            ],

        }),   
        components:{
            quicksearch 
        },
        mounted(){  
            Scriptjs("https://maps.googleapis.com/maps/api/js?key=AIzaSyDWsOP0trKOpMqg5zDI_3WitmyNRA3JDBs&libraries=places", () => {
                this.initMap();      
            }); 
        },
        methods: {
            initMap(){
                 map = new google.maps.Map(document.getElementById("map"), {
                    center: { lat: 14.5995, lng: 120.9842 }, zoom: 11
                     ,mapTypeId: 'roadmap'
                })
                this.searchAddress()
            },
            searchAddress(){
                            // Create the search box and link it to the UI element.
                var input = document.getElementById('pac-input');
                var searchBox = new google.maps.places.SearchBox(input);
                 map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                // Bias the SearchBox results towards current map's viewport.
                map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
                });

                var markers = [];
                // Listen for the event fired when the user selects a prediction and retrieve
                // more details for that place.
                searchBox.addListener('places_changed', function() {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                // Clear out the old markers.
                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
                markers = [];

                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function(place) {
                    if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                    }

                    // Create a marker for each place.
                    markers.push(new google.maps.Marker({
                    map:  map,
                    title: place.name,
                    position: place.geometry.location
                    }));

                    if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                    } else {
                    bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
                });
            }
        }
    }
    
</script>
 <style>
  #map {
    height: 300px;
    width: 300px; 
  }
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
  }
</style>
 