<template>
  <div id="app">
    <v-app id="inspire">
      <v-data-table :headers="headers" :items="clientes" sort-by="nome" class="elevation-1">
        <template v-slot:top>
          <v-toolbar flat color="white">
            <v-toolbar-title>Clientes</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
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
                        <v-text-field
                          v-model="editedItem.nome"
                          :rules="nomeRules"
                          label="Nome"
                          required
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedItem.telefone"
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
                          required
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
          <v-icon small class="mr-2" @click="editItem(item)">edit</v-icon>
          <v-icon small @click="deleteItem(item.id)">delete</v-icon>
        </template>
        <template v-slot:no-data>
          <v-btn color="primary" @click="initialize">Reset</v-btn>
        </template>
      </v-data-table>
    </v-app>
  </div>
</template>

<script>
export default {
  data: () => {
    return {
      editMode: false,
      dialog: false,
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
      editedItem: {
        id: "",
        nome: "",
        veiculo: "",
        telefone: "",
        morada: "",
        email: "",
        created_at: ""
      },
      defaultItem: {
        id: "",
        nome: "",
        veiculo: "",
        telefone: "",
        morada: "",
        email: "",
        created_at: ""
      },
      emailRules: [
        //v => !!v || "E-mail is required",
        v => (v != null ? /.+@.+/.test(v) || "E-mail must be valid" : null)
      ],
      nomeRules: [
        v => !!v || "Nome is required",
        v => v.length <= 250 || "Nome must be less than 250 characters"
      ],
      moradaRules: [
        //v => !!v || "Morada is required",
        v => v.length <= 250 || "Morada must be less than 250 characters"
      ],
      veiculoRules: [
        v => !!v || "Veiculo is required",
        v => v.length <= 50 || "Veiculo must be less than 50 characters"
      ],
      telefoneRules: [
        v => !!v || "Telefone is required",
        v => v.number || "Telefone must be integer"
      ]
    };
  },

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Novo Cliente" : "Editar Cliente";
    },
    disableButton: function() {

      return this.editedItem.nome.length < 1 ||
        this.editedItem.telefone < 1  ||
        this.editedItem.veiculo.length < 1;
    }
  },

  watch: {
    dialog(val) {
      val || this.close();
    }
  },

  created() {
    this.initialize();
  },

  methods: {
    initialize() {
      this.$Progress.start();
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
        confirmButtonText: "Sim, apagar isso!"
      }).then(result => {
        // Send request to the server
        console.log("before delet yess");
        axios
          .delete("api/cliente/" + id)
          .then(() => {
            console.log("delet yess");
            this.initialize();
            this.$swal("Deleted!", "Cliente removido com sucesso!", "success");
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
          .put("/api/cliente/" + this.editedItem.id, this.editedItem)
          .then(() => {
            this.$swal(
              "Good job!",
              "Cliente atualizado com sucesso!",
              "success"
            );
          })
          .catch(e => {
            console.log("errorr on update Cliente component", e);
          });
      } else {
        axios
          .post("/api/cliente", this.editedItem)
          .then(() => {
            this.$swal("Good job!", "Cliente criado com sucesso!", "success");
          })
          .catch(e => {
            console.log("errorr on create Cliente component", e);
          });
      }

      this.initialize();
      this.close();
    }
  }
};
</script>