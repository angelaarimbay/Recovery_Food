<template>
    <v-card class="p-4 ">  
        <!----------------------------------------------------------------TITLE MO OR HEADER--> 
            <!-- BALA KA KUNG GSTO MO GAMITIN UNG ROW/COL minsan h4 lang or strong or h5 html lang -->
            <v-row>
                <v-col class="p-0">
                <div class="p-4">
                    <h4>
                    <v-icon> mdi-alert </v-icon>
                    Set mo title mo and icon
                    </h4>
                </div>
                </v-col>
            </v-row>
         
        <v-container> 
                <v-container>
                <!----------------------------------------------------------------MENU SA IBABAW NG TABLE--> 
                    <v-card-actions>
                        <!-- <v-spacer></v-spacer>  --> 
                        <!-- enable mo ung spacer kung gsto mo sa right side ung buttons -->
                        <v-btn
                            color="#00794b"
                            style="text-transform: none"
                            depressed
                            dark
                            class="mb-2"
                            small
                            @click="dialog = true"
                        >  Add new
                        </v-btn> 
                    </v-card-actions> 
                <!----------------------------------------------------------------TABLE MO MISMO-->
                    <v-data-table 
                        dense
                        :headers="headers"
                        :data="table"
                        :items-per-page="5" 
                    > 
                    </v-data-table>
                </v-container>

                   <!----------------------------------------------------------------DIALOG / FORM-->
            <v-form >
                <v-dialog v-model="dialog" max-width="500px">
                    <v-toolbar color="primary" dark>
                    pangalan ng dialaog mo
                    <v-spacer></v-spacer>
                    <v-icon class="float-right" text @click="dialog = false">mdi-close </v-icon>
                    </v-toolbar>
                    <v-card >
                    <v-card-text style="background-color: #dadcdc">
                        <br />
                        <v-card> 
                        <v-container style="background-color: #f2f3f0" class="p-4">
                            <v-row>

                            <v-col class="py-1" cols="12" xl="12" lg="12" sm="12" md="12">
                                <v-select
                                :rules="formRules"
                                v-model="form.type"
                                label=""
                                :items="listDocuments"
                                item-text="name"
                                item-value="id"
                                >
                                <template slot="label">
                                    <div style="font-size: 14px; color: red">
                                    sample ng dropdown list
                                    </div>
                                </template>
                                </v-select>
                            </v-col>

                            <v-col class="py-1" cols="12" xl="12" lg="12" sm="12" md="12">
                                <v-text-field
                                :rules="formRules"
                                v-model="form.name"
                                label=""
                                >
                                <template slot="label">
                                    <div style="font-size: 14px; color: red">Name *</div>
                                </template>
                                </v-text-field>
                            </v-col>

                            <v-col class="py-1" cols="12" xl="12" lg="12" sm="12" md="12">
                                <v-text-field
                                :rules="formRules"
                                v-model="form.description"
                                label=""
                                >
                                <template slot="label">
                                    <div style="font-size: 14px; color: red">
                                    Description *
                                    </div>
                                </template>
                                </v-text-field>
                            </v-col>

                            <v-col
                                class="py-1 bg-white"
                                cols="12"
                                xl="12"
                                lg="12"
                                sm="12"
                                md="12"
                            >
                                <hr />
                                <div class="text-danger">Attachment *</div>
                                <div v-if="form.document">
                                Uploaded file :
                                <a
                                    :href="
                                    '/storage/files/employee/document/' + form.document
                                    "
                                    download
                                >
                                    {{ tempfile }}
                                </a>
                                <v-icon v-if="form.document" @click="deletefile"
                                    >mdi-delete</v-icon
                                ><br /><br />
                                </div>
                                <v-progress-linear
                                v-show="progressBar"
                                slot="progress"
                                color="green"
                                indeterminate
                                ></v-progress-linear>
                                <v-btn
                                text
                                outlined
                                color="primary"
                                class="btn btn-block"
                                style="text-transform: none"
                                @click="clickupload"
                                ><v-icon>mdi-upload</v-icon> Upload File
                                </v-btn>
                                <input
                                ref="uploader"
                                clearable="true"
                                class="d-none"
                                type="file"
                                @change="uploaddocument"
                                />
                                <br />
                                <small class="text-danger"
                                >*The system only accepts one file per document. For multiple files, please compress it to .zip or .rar file.</small
                                >
                            </v-col>

                            <v-col class="py-1" cols="12" xl="12" lg="12" sm="12" md="4">
                                <v-text-field
                                style="display: none"
                                :rules="formRules"
                                v-model="form.document"
                                label="Document"
                                ></v-text-field>
                            </v-col>
                            </v-row>
                        </v-container>
                        </v-card>
                    </v-card-text>
                    <!-- buttons -->
                    <v-card-actions style="background-color: #dadcdc">
                        <v-spacer></v-spacer>
                        <v-btn
                        color="#00794b"
                        depressed
                        :disabled="button"
                        dark
                        @click="test()"
                        style="text-transform: none"
                        >
                        Save
                        </v-btn>
                    </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-form> 
        </v-container>

 
    </v-card>
</template> 

<script> 
export default {
    // 'data' itoy declaration lang ng variables. (alam nyo nmn cguro un) ung pag nag declare ka pwede mo lagyan ng value

    // ibang ibang variable yan pag :false or :true common sense pag false ndi pinapakita pag true pinapakita

    // pag "" or '' or null or 1,2,3,4,5.... , alam mo na na string un pwedeng mo rin ilagay number 

    // pag [] meaning object (kung ndi ka familiar ito ung JSON format kung ndi kaparin familiar, para syang array pero nested)
    // halimbawa in one [] object have multiple index, each index have array with values na merong specific columns/key and values (sample ung headers)
    // ni uuse natin ung object sa v-datatable (table) un ung data (rows) ung headers un ung columns

    //yan lang ung kadalasang gamit sa mga declarations. basic lang yan. then ito advance  

    // ung formrules nmn ung value nun naka regex format or pwedeng ganyang lang for validation ng form. mag re-red ung textbox mo ng matic pag ndi na meet ung required
    // minsan meron rules na for integer lang minsan for email lang meon nan dun sa website ni vuetify. ndi nyo na need gumamit nung ginagamit nyo dating plugins na for favalidation ng form. sa simpleng rules lang na ganto
    // maba-validate mo na ung textbox

  data: () => ({
    editedIndex: -1,
    button: false,
    dialog: false,
    listDocuments: [ { name: 'sample', value: '1' }],
    deleteid: "",
    progressBar: false,
    tempfile: "",
    table: [],
    formRules: [  v => !!v || 'This is required'], 
    // kada add mo ng textbox lagyan mo ng v-model="form.variable_mo"
    form:  { 
        type:null,     
        name:null,     
        description:null,  
        document:null,      
    },    
    // ito ung column names, depende syo kung ano ung papakita mo. ndi lahat ng columns sa form need makita  
    // important dito ung 'text' for column name and 'value' for rows, others for design or sorting lang 
    headers: [
      { text: "Document Name", value: "type.name", align: "start" },
      { text: "Name", value: "name" },
      { text: "Document", value: "document" },
      { text: "Status", value: "status.name" },
      { text: "Actions", value: "id", sortable: false },
    ],
  }),

  // ito ung part na pag ni access mo ung page auto call ng function (auto run/call function)
  created() {
  
  },

  // advance coding na to. passing value to another page, need ko to demo pag needed. 
  computed: {
    
  },

  // ito ung parang javascript gagawa ka ng function
  methods: {
    // test() cacall mo lang sa @click ng button mo para  ma call sya. sample: <v-btn @click="test()"> Call </v-btn> 
      test(){
          alert("123");
      },

    //   ito no need to familliarize copy paste lang to. ako mismo gumawa nito para sa file upload button
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
    uploaddocument(){
        alert("sample lang to. ndi mag aupload ung file mo. wla kpa sa controller")
    }
  },
    // ito ung automatic na functionality, halimbawa ung declared variable mo na dialog or ID nag change value, 
    // ma dedetect ng 'watch' na nag change ung value nya cacall nya ung functions, same lang to sa method pero sa variable lang ung watch nag bebased ndi sa @click or @change, minsan ginagamit din to for other purposes.
  watch: {
    dialog(val) {
    //   alert("yes") // uncomment mo to then try mo press ung button,  ito ung nag tritriger pag ni open mo ung dialog
    },
    id: {
      handler: function (v) { 
      },
    },
  },
}
</script>
