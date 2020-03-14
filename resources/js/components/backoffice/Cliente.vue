<template>
  <div id="app">
    <page-adress breadcrumbTittle="Cliente"></page-adress>
    <v-app id="inspire">
      <v-form>
        <v-data-table :headers="headers" :items="clientes" class="elevation-1">
          <template v-slot:top>
            <v-toolbar flat color="white">
                <v-text-field
                  @keyup="procurarcliente"
                  v-model="clientesearched"
                  label="Pesquisar Cliente ou Veiculo"
                  single-line
                ></v-text-field>
              <v-spacer></v-spacer>
              <v-dialog v-model="dialog" max-width="500px">
                <template v-slot:activator="{ on }">
                  <v-btn color="primary" dark class="mb-2" v-on="on">Novo Cliente</v-btn>
                </template>
                <v-card>
                  <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                  </v-card-title>

                  <v-card-text>
                    <v-container>
                      <v-row>
                        <v-col cols="12" sm="6" md="4">
                          <v-text-field v-model="editedItem.nome" :rules="nomeRules" label="Nome"></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                          <v-text-field
                            v-model="editedItem.telefone"
                            type="number"
                            :rules="telefoneRules"
                            label="Telefone"
                            required
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                          <v-text-field
                            v-model="editedItem.veiculo"
                            :rules="veiculoRules"
                            label="Veiculo"
                            required
                          ></v-text-field>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col cols="12" sm="6" md="6">
                          <v-text-field
                            v-model="editedItem.morada"
                            :rules="moradaRules"
                            label="Morada"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="6">
                          <v-text-field
                            v-model="editedItem.email"
                            :rules="emailRules"
                            label="E-mail"
                          ></v-text-field>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-card-text>

                  <!-- ate aki -->

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
            <v-icon small @click="deleteItem(item.id)">fas fa-trash-alt</v-icon>
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
import PageAdress from "./PageAdress.vue";

export default {
  data: () => {
    return {
      breadcumb: "Fornecedor",
      editMode: false,
      dialog: false,
      clientesearched: "",
      count: 0,
      headers: [
        { text: "Nome", value: "nome" },
        { text: "Telefone", value: "telefone" },
        { text: "Veiculo ", value: "veiculo" },
        { text: "Morada ", value: "morada" },
        { text: "Criado Em ", value: "created_at" },
        { text: "Actions", value: "action", sortable: false }
      ],
      clientes: [],
      editedIndex: -1,
      editedItem: new Form({
        id: "",
        nome: "",
        veiculo: "",
        telefone: "",
        morada: "",
        email: "",
        created_at: ""
      }),
      defaultItem: {
        id: "",
        nome: "",
        veiculo: "",
        telefone: "",
        morada: "",
        email: "",
        created_at: ""
      },
      emailRules: [],
      nomeRules: [
        v => !!v || "Nome is required",
        v => v.length <= 250 || "Nome must be less than 250 characters"
      ],
      moradaRules: [
        v => v.length <= 250 || "Morada must be less than 250 characters"
      ],
      veiculoRules: [
        v => !!v || "Veiculo is required",
        v => v.length <= 50 || "Veiculo must be less than 50 characters"
      ],
      telefoneRules: [
        v => v > 0 || "Number must be more than 0",
        v => !!v || "Telefone is required"
      ]
    };

  },

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Novo Cliente" : "Editar Cliente";
    },
    disableButton: function() {
      if (this.editedItem.email.length < 1) {
        return (
          this.editedItem.nome.length < 1 ||
          this.editedItem.telefone < 1 ||
          this.editedItem.veiculo.length < 1
        );
      }
      if (
        this.editedItem.email.length > 1 &&
        /.+@.+/.test(this.editedItem.email)
      ) {
        this.emailRules = [v => /.+@.+/.test(v) || "E-mail must be valid"];

        return (
          this.editedItem.nome.length < 1 ||
          this.editedItem.telefone < 1 ||
          this.editedItem.veiculo.length < 1
        );
      } else return true;
    }
  },

  watch: {
    dialog(val) {
      val || this.close();
    }
  },

  created() {
    Fire.$on("searching", () => {
      let query = this.clientesearched;

      axios.get("api/findcliente?query=" + query).then(response => {
        this.clientes = response.data.data;
      });
    });

    this.initialize();
  },

  methods: {
    procurarcliente: _.debounce(() => {
      console.log("sim n txomadu");
      Fire.$emit("searching");
      //Fire.$emit('nome de evento a chamar em qq parte de APP') => txoma event na qq
    }, 1000),

    initialize() {
      this.$Progress.start();
      this.clientesearched = "";
      axios.get("api/cliente").then(response => {
        this.clientes = response.data.data;
      });

      this.$Progress.finish();
    },

    editItem(item) {
      this.editMode = true;
      this.editedIndex = this.clientes.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(id) {
      this.$swal({
        title: "Tens certeza?",
        text: "Não será possível reverter isso!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, apagar isso!",
      }).then(result => {

        if(result.value) {
                  axios
          .delete("api/cliente/" + id)
          .then(() => {
            this.initialize();
            this.$swal("Deleted!", "Cliente removido com sucesso!", "success");
          })
          .catch(() => {
            this.$swal("Failed!", "There was something wronge.", "warning");
          });

          } else {
            this.$swal('Cancelled', 'You give up to deleted this file', 'info')
          }

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
          .put("/api/cliente/" + this.editedItem.id, this.editedItem)
          .then(() => {
            this.initialize();
            this.$swal(
              "Good job!",
              "Cliente atualizado com sucesso!",
              "success"
            );
          })
          .catch(() =>  {
            console.log("errorr on update Cliente component");
          });
      } else {
        axios
          .post("/api/cliente", this.editedItem)
          .then(() => {
                        this.initialize();

            this.$swal("Good job!", "Cliente criado com sucesso!", "success");
          })
          .catch(() =>  {
            console.log("errorr on create Cliente component");
          });
      }
      //this.close();
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