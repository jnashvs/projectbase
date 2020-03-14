<template>
  <div id="app">
    <page-adress breadcrumbTittle="Serviço"></page-adress>
    <v-app id="inspire">
      <v-form>
        <v-data-table :headers="headers" :items="servicos" class="elevation-1">
          <template v-slot:top>
            <v-toolbar flat color="white" class="cabecalho">
              <v-text-field
                @keyup="procurarservico"
                v-model="servicosearched"
                label="Pesquisar Serviço ou Veiculo"
                single-line
              ></v-text-field>
              <v-spacer></v-spacer>

              <!-- <view-service :servicos="viewdialogservice"></view-service> -->
              
              <v-dialog v-model="dialog" max-width="500px">
                <template v-slot:activator="{ on }">
                  <v-btn color="primary" dark class="mb-2" v-on="on">Novo</v-btn>
                </template>
                
                <v-card>
                  <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                  </v-card-title>

                  <v-card-text>
                    <v-container>
                      <v-row>
                        <v-col cols="12" sm="12" md="12">
                          <v-text-field v-model="editedItem.nome" :rules="nomeRules" label="Nome"></v-text-field>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col cols="12" sm="6" md="6">
                          <v-text-field
                            v-model="editedItem.valor"
                            type="number"
                            :rules="valorRules"
                            label="Valor"
                            required
                          ></v-text-field>
                        </v-col>
                        <v-col class="d-flex" cols="12" sm="6" md="6">
                          <v-select
                            v-model="editedItem.tipoveiculo"
                            :items="tipoveiculo"
                            label="Tipo Veiculo"
                          ></v-select>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col cols="12" sm="12" md="12">
                          <v-textarea v-model="editedItem.descricao" label="Descrição"></v-textarea>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-card-text>

                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="close">Cancelar</v-btn>
                    <v-btn
                      color="blue darken-1"
                      text
                      @click="save"
                      v-bind:disabled="disableButton"
                    >Guardar</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-toolbar>
          </template>

          <template v-slot:item.action="{ item }">
            <v-icon small class="mr-2" @click="editItem(item)">fas fa-edit</v-icon>
            <v-icon></v-icon>
            <v-icon small @click="deleteItem(item.id)" class="delete">fas fa-trash-alt</v-icon>
            
            <v-icon small class="mr-2" @click="viewItem(item)">fas fa-eye</v-icon>

          </template>
          <template v-slot:no-data>
            <v-btn color="primary" @click="initialize">Reset</v-btn>
          </template>
        </v-data-table>
      </v-form>
    </v-app>
  </div>
</template>

<script>
export default {
  data: () => {
    return {
      editMode: false,
      dialog: false,
      viewdialogservice: false,
      servicosearched: "",
      count: 0,
      headers: [
        { text: "Nome", value: "nome" },
        { text: "Tipo de Veiculo", value: "tipoveiculo" },
        { text: "Valor", value: "valor" },
        //{ text: "Descrição", value: "descricao" },
        { text: "Criado Em ", value: "created_at" },
        { text: "Actions", value: "action", sortable: false }
      ],
      servicos: [],
      editedIndex: -1,
      editedItem: {
        id: "",
        nome: "",
        tipoveiculo: "",
        valor: "",
        descricao: "",
        created_at: ""
      },
      defaultItem: {
        id: "",
        nome: "",
        tipoveiculo: "",
        valor: "",
        descricao: "",
        created_at: ""
      },
      nomeRules: [
        v => !!v || "Nome is required",
        v => v.length <= 250 || "Nome must be less than 250 characters"
      ],
      valorRules: [
        v => v > 0 || "Number must be more than 0",
        v => !!v || "Valor is required"
      ],
      tipoveiculo: ["Pequeno", "Medio", "Grande", "Diferenciado"]
    };
  },

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Novo Serviço" : "Editar Serviço";
    },
    disableButton: function() {
      return this.editedItem.nome.length < 1 || this.editedItem.valor < 1;
    }
  },

  watch: {
    dialog(val) {
      val || this.close();
    }
  },

  created() {
    Fire.$on("searching", () => {
      let query = this.servicosearched;

      axios.get("api/findservico?query=" + query).then(response => {
        this.servicos = response.data.data;
      });
    });

    this.initialize();
  },

  methods: {
    procurarservico: _.debounce(() => {
      console.log("sim n txomadu");
      Fire.$emit("searching");
      //Fire.$emit('nome de evento a chamar em qq parte de APP') => txoma event na qq
    }, 1000),

    initialize() {
      this.$Progress.start();
      this.servicosearched = "";
      axios.get("api/servico").then(response => {
        this.servicos = response.data.data;
      });

      this.$Progress.finish();
    },

    editItem(item) {
      this.editMode = true;
      this.editedIndex = this.servicos.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    viewItem(item) {
      this.viewdialogservice = true;
      //this.editedIndex = this.servicos.indexOf(item);
      //this.editedItem = Object.assign({}, item);
      //this.dialog = true;
      console.log("status view"+this.viewdialogservice);
    },

    deleteItem(id) {
      this.$swal({
        title: "Tens certeza?",
        text: "Não será possível reverter isso!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, apagar isso!"
      }).then(result => {
        // Send request to the server
        axios
          .delete("api/servico/" + id)
          .then(() => {
            this.initialize();
            this.$swal("Deleted!", "Serviço removido com sucesso!", "success");
          })
          .catch(() => {
            this.$swal("Failed!", "There was something wronge.", "warning");
          });
      });
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },

    save() {
      if (this.editedIndex > -1) {
        axios
          .put("/api/servico/" + this.editedItem.id, this.editedItem)
          .then(() => {
                  this.initialize();

            this.$swal(
              "Good job!",
              "Servico atualizado com sucesso!",
              "success"
            );
          })
          .catch(e => {
            console.log("errorr on update Serviço component", e);
          });
      } else {
        
        axios
          .post("/api/servico", this.editedItem)
          .then(() => {
                  this.initialize();

            this.$swal("Good job!", "Serviço criado com sucesso!", "success");
          })
          .catch(e => {
            console.log("errorr on create Serviço component", e);
          });
      }

      this.initialize();
      this.close();
    }
  }
};
</script>
<style>
@media only screen and (min-width: 600px) {
  td {
    word-break: break-all;
    width: auto;
    padding: 15px !important;
  }
}


  .cabecalho {
    padding: 20px;
    margin-bottom: 20px !important;
  }

  .delete {
    color: brown !important;
  }

  .v-data-table-header {
    margin-top: 20px !important;
  }
</style>
