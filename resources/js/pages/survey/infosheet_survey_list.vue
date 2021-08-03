<template>
<div>
    <v-overlay class="text-dark mx-auto" color="white" :value="overlay">
        
        <v-progress-circular
            indeterminate
            :rotate="360"
            :width="10"
            color="primary" 
            size="70">
            <v-icon size="35" color="danger">mdi-folder-lock-open</v-icon>
            <v-img src=""></v-img>
        </v-progress-circular> 
    </v-overlay>


      <v-card-title class="text-h5 grey lighten-2">
            Survey List
          </v-card-title>
        

          <v-card-text>  
            <v-card-text>
              <v-btn class="info" small @click="survey_add_dialog = true">Add new</v-btn>
            </v-card-text>
              <v-data-table
                :headers="survey_headers"
                :items="survey_data"
                :items-per-page="5"
                class="elevation-1"
              >
                <template v-slot:[`item.filename`]="{ value }">
                    <a :href="`/storage/files/survey/` + value" target="blank_">
                    <v-hover v-slot="{ hover }">
                        <v-btn
                        text
                        small
                        :class="
                            hover
                            ? 'btn btn-info btn-sm text-white'
                            : 'btn btn-sm btn-link text-primary'
                        "
                        >
                        <v-icon>mdi-download</v-icon> <small> - Download </small>
                        </v-btn>
                    </v-hover>
                    </a>
                </template>
                <template v-slot:[`item.date`] = "{ item }">
                        {{  getFormatDate(item.date,'MM/DD/YYYY') }}                   
                </template>
                <template v-slot:[`item.id`]="{ item }">
                <v-hover v-slot="{ hover }">
                    <v-btn
                    class="px-1"
                    :class="
                        hover
                        ? 'btn btn-primary text-white'
                        : 'btn btn-link text-primary'
                    "
                    text
                    small
                  
                    >
                    <v-icon> mdi-pencil </v-icon>
                    <small> - Edit </small>
                    </v-btn>
                </v-hover>
                </template>
              
              </v-data-table> 
          </v-card-text>
         

 
      <v-dialog v-model="survey_add_dialog" width="800"  >  
        <v-card>
          <v-card-title class="text-h5 grey lighten-2">
            Add New Survey
          </v-card-title> 
          <v-card-text>
            <v-container>  
                <v-text-field label="Title" v-model="data.title"   hide-details="auto" ></v-text-field>
                <v-text-field label="Description" v-model="data.description"   hide-details="auto" ></v-text-field>
                <v-menu ref="menu" max-width="280" v-model="menu" :close-on-content-click="false" :return-value.sync="date" transition="scale-transition" offset-ymin-width="auto" >
                  <template  v-slot:activator="{ on, attrs }">
                  <v-text-field  v-model="data.date" label="Date" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" ></v-text-field></template>
                  
                  <v-date-picker  v-model="data.date" no-title scrollable >
                  <v-spacer></v-spacer>
                  <v-btn text color="primary" @click="menu = false" >
                      Cancel
                  </v-btn>
                  <v-btn text color="primary" @click="$refs.menu.save(data.date)">
                      OK
                  </v-btn>
                  </v-date-picker>
                </v-menu>              
                   <hr />
                  <div class="text-danger">Attachment *</div>
                  <div v-if="data.filename">
                    Uploaded file :
                    <a
                      :href="'/storage/files/downloads/' + data.filename"
                      download
                    >
                      {{ tempfile }}
                    </a>
                    <v-icon v-if="form.filename" @click="deletefile"
                      >mdi-delete</v-icon
                    ><br /><br />
                  </div>
                  <v-btn
                    text
                    outlined
                    color="primary"
                    class="btn btn-block"
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
                    >* Note that, you can only upload 1 file, recomend that use
                    Rar/Zip if multiple.</small
                  >
                  <v-text-field
                    style="display: none" 
                    v-model="data.filename"
                    label="Document"
                  ></v-text-field>
            </v-container>
          </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
              <v-spacer></v-spacer>
            <v-btn
              color="blue darken-1"
              text
              @click="survey_add_dialog = false"
            >
              Close
            </v-btn>
             <v-btn
              color="primary darken-1"
              text
              @click="store"
            >
              Save
            </v-btn>
            </v-card-actions>
        </v-card>
      </v-dialog>
</div>
</template> 
<script> 
import axios from 'axios' 
import template from '../template.vue';
  export default {
  components: { template },
    data () {
      return {
            progressBar: true,
            isSelecting: false,
            overlay: true,
            menu: false,
            date: new Date().toISOString().substr(0, 10), 
            survey_dialog: false, 
            survey_headers: 
            [ 
                { text: 'Survey Date', value: 'date' },
                { text: 'Title', value: 'title' },
                { text: 'Description', value: 'description' },
                { text: 'Attachment', value: 'filename' },  
                { text: 'Action', value: 'id' },  
            ],
            survey_data: [], 
            survey_add_dialog: false,
            data:{
                title:'',
                description: '',
                dated: '',
                file: '', 
            }
        }
    },
    created(){
        this.getList();
    },
    methods: {
        async getList(){
            let self = this;
            await axios.get("/api/get/survey/list")
            .then(result =>{  
                self.survey_data  = result.data 
                this.overlay = false
            }).catch(res=>{
                this.overlay = false
            });
        }, 
        async store(){
            let self = this;
            await axios.post("/api/store/survey", this.data)
            .then(result =>{   
                this.survey_add_dialog = false;
                this.getList(); 
            }).catch(res=>{ 
            });
        }, 
 
        getFormatDate(e, format) {
            const date = moment(e);
            return date.format(format);
        },
       
        // for uploading picture (e) as event
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
        deletefile() {
        this.$refs.uploader.value = null;
        this.data.filename = null;
        },

        async uploaddocument(e) {
        if (e) {
            this.progressBar = true;
            var dataform = new FormData();
            dataform.append("file", e.target.files[0]);
            await axios
            .post("/api/upload/survey", dataform, { 
                headers: { "Content-Type": "multipart/form-data" },
            })
            .then((result) => { 
   
                this.data.filename = result.data;
                this.progressBar = false;
            });
        }
        },
    }
   
}
</script>
