<template>
<div>
   <p class="text-h6">
      Masterlist Supplies  
    </p> 
        
    <p class="home">Home > </p> 

  <p class="masterlist">Masterlist Supplies
<p class="date">Date:</p>
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

<v-col> <h5>Supply Category * </h5>
 <v-autocomplete
            label="Dry Goods"
            solo
            dense
             :rules="[() => !!country || 'This field is required']"
            :items="countries"
            placeholder="Select..."
            required
          ></v-autocomplete>
        </v-col>

      <v-col> <h5>Supply Name * </h5>
          <v-text-field
            label="Enter supply name"
            placeholder="Enter supply name"
            solo
             :rules="[() => !!country || 'This field is required']"
          ></v-text-field>
        </v-col>

 <v-col> <h5>Supply Description * </h5>
          <v-text-field
            label="Enter supply description"
            placeholder="Enter supply description"
            solo
             :rules="[() => !!country || 'This field is required']"
          ></v-text-field>
        </v-col>

<v-col> <h5>Unit * </h5>
 <v-autocomplete
            label="Pack"
            solo
            dense
             :rules="[() => !!country || 'This field is required']"
            :items="countries"
            placeholder="Select..."
            required
          ></v-autocomplete>
        </v-col>




        <v-card-text>
          <v-container>
            <v-row>
              <v-col
                cols="12"
                sm="6"
                md="4"
              >
                <v-text-field
                  label="Legal first name*"
                  required
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="4"
              >
                <v-text-field
                  label="Legal middle name"
                  hint="example of helper text only on focus"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="4"
              >
                <v-text-field
                  label="Legal last name*"
                  hint="example of persistent helper text"
                  persistent-hint
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  label="Email*"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  label="Password*"
                  type="password"
                  required
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
              >
                <v-select
                  :items="['0-17', '18-29', '30-54', '54+']"
                  label="Age*"
                  required
                ></v-select>
              </v-col>
              <v-col
                cols="12"
                sm="6"
              >
                <v-autocomplete
                  :items="['Skiing', 'Ice hockey', 'Soccer', 'Basketball', 'Hockey', 'Reading', 'Writing', 'Coding', 'Basejump']"
                  label="Interests"
                  multiple
                ></v-autocomplete>
              </v-col>
            </v-row>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
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
        <!----------------------------------------------------------------TITLE MO OR HEADER--> 
            <!-- BALA KA KUNG GSTO MO GAMITIN UNG ROW/COL minsan h4 lang or strong or h5 html lang -->
            

       <v-row>

         <div class="list">
          Add Masterlist Supply
         </div>
       </v-row>
        

        <v-container> 
                <v-container class>
                <!----------------------------------------------------------------MENU SA IBABAW NG TABLE--> 
                    <v-card-actions>
                        <!-- <v-spacer></v-spacer>  --> 
                        <!-- enable mo ung spacer kung gsto mo sa right side ung buttons -->
                     
                    </v-card-actions> 
                <!----------------------------------------------------------------TABLE MO MISMO-->
                   
                </v-container>

                   <!----------------------------------------------------------------DIALOG / FORM-->
            <v-form >
              
            </v-form> 
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
      countries: ['Dry goods 1', 'Dry goods 2', 'Dry goods 3', 'Dry goods 4', 'Dry goods 5', 'Dry goods 6', 'Dry goods 7 & 8', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia &amp; Herzegovina', 'Botswana', 'Brazil', 'British Virgin Islands', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia', 'Cameroon', 'Cape Verde', 'Cayman Islands', 'Chad', 'Chile', 'China', 'Colombia', 'Congo', 'Cook Islands', 'Costa Rica', 'Cote D Ivoire', 'Croatia', 'Cruise Ship', 'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Estonia', 'Ethiopia', 'Falkland Islands', 'Faroe Islands', 'Fiji', 'Finland', 'France', 'French Polynesia', 'French West Indies', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guam', 'Guatemala', 'Guernsey', 'Guinea', 'Guinea Bissau', 'Guyana', 'Haiti', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Isle of Man', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jersey', 'Jordan', 'Kazakhstan', 'Kenya', 'Kuwait', 'Kyrgyz Republic', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Mauritania', 'Mauritius', 'Mexico', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Montserrat', 'Morocco', 'Mozambique', 'Namibia', 'Nepal', 'Netherlands', 'Netherlands Antilles', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Norway', 'Oman', 'Pakistan', 'Palestine', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Poland', 'Portugal', 'Puerto Rico', 'Qatar', 'Reunion', 'Romania', 'Russia', 'Rwanda', 'Saint Pierre &amp; Miquelon', 'Samoa', 'San Marino', 'Satellite', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'South Africa', 'South Korea', 'Spain', 'Sri Lanka', 'St Kitts &amp; Nevis', 'St Lucia', 'St Vincent', 'St. Lucia', 'Sudan', 'Suriname', 'Swaziland', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', `Timor L'Este`, 'Togo', 'Tonga', 'Trinidad &amp; Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks &amp; Caicos', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan', 'Venezuela', 'Vietnam', 'Virgin Islands (US)', 'Yemen', 'Zambia', 'Zimbabwe'],
      errorMessages: '',
      name: null,
      address: null,
      city: null,
      state: null,
      zip: null,
      country: null,
      formHasErrors: false,
    }),

    computed: {
      form () {
        return {
          name: this.name,
          address: this.address,
          city: this.city,
          state: this.state,
          zip: this.zip,
          country: this.country,
        }
      },
    },

    watch: {
      name () {
        this.errorMessages = ''
      },
    },

    methods: {
      addressCheck () {
        this.errorMessages = this.address && !this.name
          ? `Hey! I'm required`
          : ''

        return true
      },
      resetForm () {
        this.errorMessages = []
        this.formHasErrors = false

        Object.keys(this.form).forEach(f => {
          this.$refs[f].reset()
        })
      },
      submit () {
        this.formHasErrors = false

        Object.keys(this.form).forEach(f => {
          if (!this.form[f]) this.formHasErrors = true

          this.$refs[f].validate(true)
        })
      },
    },
  }
</script>

