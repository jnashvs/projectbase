<template>
  <div id="app" class="container">
    <page-adress breadcrumbTittle="Produtos"></page-adress>
    <form>
      <h4>Produtos</h4>
      <div class="form-produto">
        <div class="form-row">
          <div class="form-group col-md-3">
            <label>Nome</label>
            <input
              v-model="editedItem.nome"
              :rules="nomeRules"
              type="text"
              class="form-control"
              required
            />
          </div>
          <div class="form-group col-md-2">
            <label>Quantidade</label>
            <input
              v-model="editedItem.quantidade"
              :rules="valorRules"
              type="number"
              class="form-control"
              required
            />
          </div>
          <div class="form-group col-md-2">
            <label>Preço</label>
            <input
              v-model="editedItem.preco"
              :rules="valorRules"
              type="number"
              class="form-control"
              placeholder="Preço"
              required
            />
          </div>
          <div class="form-group col-md-3">
            <v-col class="d-flex" cols="12" sm="6">
          <v-select
            :items="unidade_medida"
            label="Standard"
          ></v-select>
        </v-col>
          </div>
          <div class="form-group col-md-2">
            <label>Action</label>
            <button
              @click="submit"
              v-bind:disabled="disableButton"
              type="button"
              class="btn btn-primary form-control"
            >Guardar</button>
          </div>
        </div>
      </div>
      <hr />
    </form>
    <v-form>
      <v-data-table :headers="headers" :items="produtos" class="elevation-1">
        <template v-slot:top>
          <v-toolbar flat color="white">
              <v-text-field v-model="produtosearch" label="Search Produto"></v-text-field>
                          <v-spacer></v-spacer>

            <v-dialog v-model="dialog" max-width="500px">
              <v-card>
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="12" sm="6" md="6">
                        <v-text-field v-model="editedItem.nome" label="Nome"></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="6">
                        <v-text-field
                          v-model="editedItem.quantidade"
                          type="number"
                          label="Quantidade"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col cols="12" sm="6" md="6">
                        <v-text-field v-model="editedItem.preco" type="number" label="Preço"></v-text-field>
                      </v-col>
                      <v-col class="d-flex" cols="12" sm="6" md="6">
                        <v-select
                          v-model="editedItem.unidade_medida"
                          :items="unidade_medida"
                          label="Unidade Medida"
                        ></v-select>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>

                <!-- ate aki -->

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="close">Cancelar</v-btn>
                  <v-btn color="blue darken-1" text v-bind:disabled="disableButton" @click="submit(1)">Guardar</v-btn>
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
  </div>
</template>

<script>
import PageAdress from "./PageAdress.vue";

export default {
  components: {
    PageAdress
  },
  data: () => ({
    headers: [
      { text: "Nome ", value: "nome" },
      { text: "Quantidade ", value: "quantidade" },
      { text: "Preço ", value: "preco" },
      { text: "Unidade Medida ", value: "unidade_medida" },
      { text: "Criado Em ", value: "created_at" },
      { text: "Actions", value: "action", sortable: false }
    ],
    editMode: false,
    dialog: false,
    produtos: [],
    unidade_medida: ['Litro', 'Kg', 'Area', 'Unidade'],
    produtosearch: "",
    editedIndex: -1,
    editedItem: new Form({
      id: "",
      nome: "",
      quantidade: "",
      preco: "",
      unidade_medida: "",
      created_at: ""
    }),
    defaultItem: {
      id: "",
      nome: "",
      quantidade: "",
      preco: "",
      unidade_medida: "",
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
  }),
  created() {
    /*Fire.$emit("clicked-event", this.titulo);
    console.log("test 1");*/
    this.initialize();
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Novo Serviço" : "Editar Serviço";
    },
    disableButton: function() {
      return (
        this.editedItem.nome.length < 1 ||
        this.editedItem.quantidade < 1 ||
        this.editedItem.preco < 1
      );
    }
  },

  watch: {
    dialog(val) {
      val || this.close();
    }
  },

  methods: {
    initialize() {
      this.$Progress.start();
      this.produtosearch = "";
      axios.get("api/produto").then(response => {
        this.produtos = response.data.data;
        console.log(response.data.data);
      });

      this.$Progress.finish();
    },

    editItem(item) {
      this.editMode = true;
      this.editedIndex = this.produtos.indexOf(item);
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
    submit(option) {
      //alert(JSON.stringify(this.editedItem));
      if (option === 2) {
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
          .post("/api/produto", this.editedItem)
          .then(() => {
                        this.initialize();
            this.$swal("Good job!", "Produto criado com sucesso!", "success");
          })
          .catch(() =>  {
            console.log("errorr on create Produt component");
          });
      }
    },
    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    }
  }
};
</script>

<style>
.form-produto > div:not(:last-child) {
  border-bottom: 1px solid rgb(206, 212, 218);
}
.container {
  margin-top: -25px;
}
</style>
