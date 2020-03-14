<template>
    <v-dialog v-model="displayviewservice" max-width="500px">
         
                <v-card>
                 
                  <v-card-text>
                    <v-container>
                      
                      <v-row>
                        <v-col cols="12" sm="12" md="12">
                          <v-textarea label="Descrição" v-model="value"> </v-textarea>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-card-text>

                </v-card>
              </v-dialog>
  
</template>


<script>
export default {
  name: "view-service",
  props: ["servicos", "servicosdados"],
  data: () => ({
    displayviewservice: '',
    value: '',
    servicosview: [],
  }),
  mounted() {
      this.displayviewservice = this.servicos;
            this.value = this.servicos;
            //this.editedItem = this.servicosview;

      //console.log("working v serv"+this.servicosview)
    
}
};
</script>