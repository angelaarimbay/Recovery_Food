
<template>
<div>
    <v-container v-if="token == ''">
         <v-overlay :value="overlay">
          <v-progress-circular size="64"></v-progress-circular>
        </v-overlay>
        <v-row no-gutters> 
            <v-col md="5"  class="m-1" >
                <v-card  width="500" height="300" flat >  
                    <v-card-text >
                      <v-card flat  >
                        
                       <v-row> 
                        <v-col  class=" text-center">
                          <h4>Change Password</h4>
                        </v-col>
                       </v-row> 
                       <br>
                        <v-form ref="form"  >
                            <v-text-field :rules="rules.passwordRules" 
                              :append-icon="!value1 ? 'mdi-eye' : 'mdi-eye-off'"
                                        @click:append="() => (value1 = !value1)"
                                        :type="!value1 ? 'password' : 'text'" 
                                label="New Password" v-model="form.password" ></v-text-field>
                            <v-text-field :rules="rules.passwordRules"  
                               :append-icon="!value ? 'mdi-eye' : 'mdi-eye-off'"
                            @click:append="() => (value = !value)"
                            :type="!value ? 'password' : 'text'"
                             label="Confirm Passowrd" v-model="form.confirmation"  ></v-text-field>
                            
                              <v-card-actions> 
                                <v-btn   class="text-white" color="#cc0033" block  @click="change">Save</v-btn>
                              </v-card-actions>  
                            
                        </v-form>
                      </v-card>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col md="5"  class="m-1" >
              
                <v-card  width="500" height="300" flat >  
                    <v-card-text >
                        If you forget your password, you may contact Digitect department for support.
                      <br><b>  Tips for setting up a strong password:</b> 
                      <br> <v-icon size="10">mdi-circle</v-icon>  Use a unique password that is hard to guess
                      <br> <v-icon size="10">mdi-circle</v-icon>  Be at least 8 characters in length
                      <br> <v-icon size="10">mdi-circle</v-icon>  Contain both upper and lowercase alphabetic characters (e.g. A-Z, a-z)
                      <br> <v-icon size="10">mdi-circle</v-icon>  Have at least one numerical character (e.g. 0-9)
                      <br> <v-icon size="10">mdi-circle</v-icon>  Have at least one special character (e.g. ~!@#$%^&*()_-+=)
                    </v-card-text>
                </v-card>
            </v-col>

        </v-row>
    </v-container>
    
  <v-snackbar bottom right v-model="snackbar.status" :color="snackbar.color+' lighten-2'" class="text-center"  >{{ snackbar.message }}</v-snackbar>
</div>
</template>
<script>
import Form from 'vform'  
import axios from "axios";
import Swal from "sweetalert2"; 
export default {
  middleware: 'auth', 
  data: () => ({
    overlay: false,
    snackbar: { status: false, message: '', color: ''},
    token: '',
    value: null,
    value1: null,
    rules:{
      emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ],
      passwordRules: [
        v => !!v || 'This is required',
        v => (v && v.length <= 10) || 'Password must be 10 characters',
      ],
    }, 
    form: new Form({
      password: '',
      confirm: ''
    }),
    remember: false
  }),

  methods: {
    async change () {
     if(this.$refs.form.validate()){
    
      // Submit the form.
      Swal.fire({
        title: "Do you want to save this changes?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#00794b",
        cancelButtonColor: "#CC0022",
        confirmButtonText: "Confirm",
      }).then((result) => {
        if (result.value) {  
              axios
              .post("/api/changepassword", this.form)
              .then((result) => {  
                 Swal.fire({
                  type: "success",
                  title: "Password has been saved.", 
                });
                
            }) 
        } 
      }); 
     }  
    }

  }
}
</script>