<template>
<v-card>
      <v-overlay :value="overlay">
            <v-progress-circular
                indeterminate
                size="64"> 
            </v-progress-circular>
        </v-overlay>
        
  <v-card-text>
       <p class="text-h6 text--primary">
          <v-icon>mdi-pencil-box-outline</v-icon> - Risk Information Sheet
        </p>  
          <v-card-actions>
            <v-btn class="success text-p" small>Company Loop-up</v-btn>
            <v-btn dark class="blue text-p" small>Print</v-btn>
            <v-spacer></v-spacer> 
          </v-card-actions>  
          <hr>
          <div class="h4"> <v-text-field label="Account Name" v-model="AValue.account" hide-details="auto"   ></v-text-field></div> 
          <div class="caption">   <v-text-field label="Account ID #" v-model="AValue.accountid" hide-details="auto" ></v-text-field></div>
          <div class="caption">   <v-text-field label="Address" v-model="AValue.address" hide-details="auto" ></v-text-field></div>
  </v-card-text>

    
  
    <v-expansion-panels  v-model="panel"  multiple>
        
        <v-expansion-panel dense>
          <v-expansion-panel-header   color="danger text-white"  ><b>Marketing Section</b></v-expansion-panel-header>
          <v-expansion-panel-content> 
                <v-row>
                  <v-col lg="6"> 
                      <v-card class="p-4 mt-2">
                      <v-row>
                        <v-col lg="12">
                          <v-text-field label="Location of Risk" v-model="MKValue.lor" hide-details="auto" ></v-text-field>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col lg="2">
                          Policy Term:
                        </v-col>
                        <v-col lg="5">
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
                                label="From"
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
                        </v-col>
                         <v-col lg="5">
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
                                label="To"
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
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col lg="12">
                          <v-text-field label="Existing Coverage" v-model="MKValue.coverage" hide-details="auto" ></v-text-field>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col lg="6">
                          <v-text-field label="Total Sum Insured" v-model="MKValue.tsi" hide-details="auto" ></v-text-field>
                        </v-col> 
                        <v-col lg="6">
                          <v-text-field label="Existing Premium" v-model="MKValue.premium" hide-details="auto" ></v-text-field>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col lg="6">
                          <v-text-field label="Broker/Agent" v-model="MKValue.broker" hide-details="auto" ></v-text-field>
                        </v-col> 
                        <v-col lg="6">
                          <v-text-field label="Commission Rate" v-model="MKValue.commrate" hide-details="auto" ></v-text-field>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col lg="12">
                          <v-text-field label="Renewal Subjectivities" v-model="MKValue.subjectivities" hide-details="auto" ></v-text-field>
                        </v-col> 
                        <v-col lg="12">
                          <v-textarea
                            outlined
                            rows="2"
                            name="input-7-2"
                            v-model="MKValue.remarks"
                            label="Remarks"  ></v-textarea>
                        </v-col>
                      </v-row>
                    </v-card>
                  </v-col>
                  <v-col lg="6"> 
                  </v-col>
                </v-row>
          </v-expansion-panel-content>
        </v-expansion-panel>

        <v-expansion-panel>
          <v-expansion-panel-header color="danger text-white" ><b>Underwriting Section</b></v-expansion-panel-header>
          <v-expansion-panel-content>
                <v-row>
                  <v-col lg="6">
                   <v-card class="p-4 mt-2">
                      <v-row>
                        <v-col lg="6">
                            <v-text-field label="Retention" v-model="UWValue.retention" hide-details="auto" ></v-text-field>
                        </v-col>
                        <v-col lg="6">
                            <v-text-field label="Quata Share" v-model="UWValue.share" hide-details="auto" ></v-text-field>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col lg="8">
                            <v-text-field label="RI Facul" v-model="UWValue.rifacul" hide-details="auto" ></v-text-field>
                        </v-col>
                        <v-col lg="4">
                          <v-btn color="blue" block small dark>Download RI List</v-btn>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col lg="12">
                          <v-text-field label="Renewal Subjectivities" v-model="UWValue.subjectivities" hide-details="auto" ></v-text-field>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col lg="12">
                          <v-textarea
                              outlined
                              rows="2"
                              name="input-7-2"
                              v-model="UWValue.remarks"
                              label="Remarks"  ></v-textarea>
                        </v-col>
                      </v-row>
                   </v-card>
                  </v-col>
                </v-row>
          </v-expansion-panel-content>
        </v-expansion-panel>

        <v-expansion-panel  >
          <v-expansion-panel-header color="danger text-white" ><b>Risk engineering Section</b></v-expansion-panel-header>
          <v-expansion-panel-content>
                <v-row>
                  <v-col lg="6">
                   <v-card class="p-4 mt-2">
                      
                    <v-row>
                      <v-col lg="6">
                        <v-text-field label="Longitude" v-model="RMValue.lng" hide-details="auto" ></v-text-field>
                      </v-col>
                      <v-col lg="6">
                        <v-text-field label="Latitude" v-model="RMValue.lat" hide-details="auto" ></v-text-field>
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col lg="8">
                        <v-text-field  v-model="RMValue.survey" label="Latest Survey" readonly disabled ></v-text-field>
                      </v-col>
                      <v-col lg="4"> 
                        <v-btn color="blue" block small dark @click="btnOnClick(0)">Survey List</v-btn>
                      </v-col> 
                    </v-row>
                    <v-row>
                      <v-col lg="8"> 
                        <v-text-field label="Proposed Next Survey Year" v-model="RMValue.nextyear" hide-details="auto" ></v-text-field>
                      </v-col>
                       <v-col lg="4"> 
                        </v-col> 
                    </v-row>
                    <v-row>
                      <v-col lg="8">
                        <v-text-field label="IRES Rating" v-model="RMValue.ires"   hide-details="auto" ></v-text-field>
                      </v-col>
                      <v-col lg="4">
                        <v-btn color="blue" block small dark @click="btnOnClick(1)">Download IRES</v-btn>
                      </v-col>
                    </v-row>

                  <v-row>
                    <v-col lg="8">
                      <v-select :items="levellist" v-model="RMValue.eq" item-value="value" item-text="name" label="Earthquake Exposure" dense  ></v-select>
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col lg="8">
                      <v-select :items="levellist" v-model="RMValue.tp" item-value="value" item-text="name" label="Typhoon Exposure" dense  ></v-select>
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col lg="8">
                      <v-select :items="levellist" v-model="RMValue.fl" item-value="value" item-text="name" label="Flood Exposure" dense  ></v-select>
                    </v-col>
                     <v-col lg="4">
                        <v-btn color="blue" block small dark @click="btnOnClick(2)">Download NatCat</v-btn>
                      </v-col>
                  </v-row>
                  <v-row>
                    <v-col lg="12">
                       <v-textarea
                          outlined
                          rows="2"
                          name="input-7-2"
                          v-model="RMValue.remarks"
                          label="Remarks"  ></v-textarea>
                    </v-col>
                  </v-row>

                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary">Post</v-btn>
                  </v-card-actions>
                </v-card>
                </v-col>
              </v-row> 
          </v-expansion-panel-content>
        </v-expansion-panel>

        <v-expansion-panel>
          <v-expansion-panel-header color="danger text-white" ><b>Claims Section</b></v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-row>
              <v-col lg="6">
                <v-card class="p-4 mt-2">
                  <v-row>
                    <v-col lg="12">
                        <v-text-field label="5 - Year Loss Ratio" v-model="CValue.lossratio"   hide-details="auto" ></v-text-field>
                    </v-col>
                    <v-col lg="12">
                        <v-text-field label="Fire Loss" v-model="CValue.Fireloss"   hide-details="auto" ></v-text-field>
                    </v-col>
                    <v-col lg="12">
                        <v-text-field label="Earthquake Loss" v-model="CValue.EQloss"   hide-details="auto" ></v-text-field>
                    </v-col>
                    <v-col lg="12">
                        <v-text-field label="Typhoon Loss" v-model="CValue.TPloss"   hide-details="auto" ></v-text-field>
                    </v-col>
                    <v-col lg="12">
                        <v-text-field label="Flood Loss" v-model="CValue.FLloss"   hide-details="auto" ></v-text-field>
                    </v-col>
                     <v-col lg="12">
                        <v-text-field label="Other Losses" v-model="CValue.Otherlosses"   hide-details="auto" ></v-text-field>
                    </v-col>
                  </v-row>
                    <v-row>
                      <v-col lg="3">
                        <v-btn color="blue" block small dark>Claims Details</v-btn> 
                      </v-col>
                    </v-row>
                </v-card>
              </v-col>
            </v-row>
          </v-expansion-panel-content>
        </v-expansion-panel>

    </v-expansion-panels>
 
      <v-dialog v-model="lookup_dialog" width="900" >  
        <v-card>
          <v-card-title class="text-h5 grey lighten-2">
            Search Information Sheet
          </v-card-title>

          <v-card-text> 
            <br>
              



          </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
              <v-spacer></v-spacer>
            <v-btn
              color="blue darken-1"
              text
              @click="lookup_dialog = false"
            >
              Close
            </v-btn>
            </v-card-actions>
        </v-card>
      </v-dialog>

      <v-dialog v-model="risk_dialog" width="900" >  
        <v-card>
          <template v-if="btn_list == 0"><surveylist/></template>
          <template v-if="btn_list == 1"><ireslist/></template>
          <template v-if="btn_list == 2"><natcatlist/></template>  
           <v-divider></v-divider>
            <v-card-actions>
              <v-spacer></v-spacer>
            <v-btn
              color="blue darken-1"
              text
              @click="risk_dialog = false"
            >
              Close
            </v-btn> 
            </v-card-actions>
        </v-card> 
      </v-dialog>

 
</v-card>


</template>
<script>
import surveylist from '../survey/infosheet_survey_list.vue' 
import ireslist from '../survey/infosheet_ires_list.vue' 
import natcatlist from '../survey/infosheet_natcat_list.vue'  
  export default {
    data () {
      return {
        panel: [2],
        overlay: true,
        date: new Date().toISOString().substr(0, 10),
        menu: false,
        modal: false,
        menu2: false,
        lookup_dialog: false,
        btn_list: '',
        risk_dialog: false,



        AValue:{
          account: 'Company1',
          accountid: '123',
          address: '123 Street, Bacolod'
        },
        MKValue: {
          lor: 'Bacolod 1',
          ptfrom: '2021-06-16',
          ptto: '2021-06-16',
          coverage: 'Industrial All Risk',
          tsi: 'PHP 500,000,000.00',
          premium: '0.25%',
          broker: 'Test Broker',
          commrate: '15%',
          subjectivities: 'UW renewal',
          remarks: 'Test remarks'
        },
        UWValue: {
          retention: 'PHP 10,000.00',
          share: 'PHP 1,000,000.00',
          rifacul: 'PHP 2,000,00.00',
          subjectivities: 'test subject',
          remarks: 'test remarks for UW'
        }, 
        RMValue: {
            lat: 123,
            lng: 456,
            survey: "2021-01-21",
            nextyear: '2022',
            ires: 'Average',
            eq: 'Moderate',
            tp: 'Moderate',
            fl: 'Low',
            remarks: 'Test data only'
        },
        levellist: [
          {
          name: 'High',
          value: 'High',
          },
          {
          name: 'Moderate',
          value: 'Moderate',
          },
          {
          name: 'Low',
          value: 'Low',
          },
        ],
        CValue:{
          lossratio: '5%',
          Fireloss: 'Nil',
          EQloss: 'Nil',
          TPloss: '2015 - Typhoon A, Claimed paid = 100k',
          FLloss: 'Nil',
          Otherlosses: 'Nil'
        }
      }
    }, 
    components:{
        surveylist,
        ireslist,
        natcatlist 
    },
     created () {   
        setTimeout(() => {
            this.overlay = false
        }, 500)
        
    },   

    methods: {  
      btnOnClick(type){
        this.risk_dialog = true
        this.btn_list = type; 
      }
    },
  }
</script>