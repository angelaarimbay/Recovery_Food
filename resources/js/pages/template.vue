<template>
    <v-card>  
        <v-overlay :value="overlay">
            <v-progress-circular
                indeterminate
                size="64">
                <v-img src=""></v-img>
            </v-progress-circular>
        </v-overlay>
        
         
    </v-card>
</template> 
<script>
import axios from 'axios'
export default {
     data: () => ({  
        data:'',
            overlay: true,
        }),
   created () {   
        setTimeout(() => {
            this.overlay = false
        }, 500)
        
    },   

    methods: {  
    },
    
}
</script>