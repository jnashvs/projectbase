<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-md-4 col-sm-6 col-lg-4">
                <span class="card-title">
                  <input
                    type="text"
                    class="form-control input-sm"
                    placeholder="Nome Funcionário ..."
                    v-model="nome"
                  />
                </span>
              </div>

              <div class="col-md-8 col-sm-6 col-lg-8">
                <div class="card-tools float-right">
                  <a class="btn btn-success" @click="newModal()">
                    Novo Funcionário
                    <i class="fa fa-plus"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nome</th>
                  <th>Categoria</th>
                  <th>Telefone</th>
                  <th>Morada</th>
                  <th>Criado Em</th>

                  <th>Acção</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>

    <!-- START MODAL POPUP -->

    <div
      class="modal fade"
      id="createFuncionario"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="!editmode" class="modal-title" id="exampleModalLabel">Criar Novo Funcionario</h5>
            <h5
              v-show="editmode"
              class="modal-title"
              id="exampleModalLabel"
            >Actualizar Dados Funcionario</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form @submit.prevent="editmode ? updateFuncionario() : createFuncionario()">
            <div class="modal-body">
              <!-- START FORM FOR MODAL -->

              <div class="row justify-content-center">
                <div class="col-md-12 col-lg-12 col-sm-12">
                  <div class="form-group">
                    <input
                      v-model="form.nome"
                      type="text"
                      name="nome"
                      placeholder="Nome"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('nome') }"
                    />
                    <has-error :form="form" field="nome"></has-error>
                  </div>

                  <div class="form-group">
                    <input
                      v-model="form.telefone"
                      type="text"
                      name="telefone"
                      placeholder="Telefone"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('telefone') }"
                    />
                    <has-error :form="form" field="telefone"></has-error>
                  </div>

                  <div class="form-group">
                    <label
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('categoria') }"
                      for="selectCategoria"
                    >
                    Categoria
                    </label>
                    <select v-model="form.categoria" class="form-control" id="selectCategoria">
                      <option selected value="">Escolha...</option>
                      <option value="1">Lavador</option>
                      <option value="2">Supervisor</option>
                      <option value="3">Gestor</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <input
                      v-model="form.morada"
                      type="text"
                      name="morada"
                      placeholder="Morada"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('morada') }"
                    />
                    <has-error :form="form" field="morada"></has-error>
                  </div>

                  <div class="form-group">
                    <input
                      v-model="form.email"
                      type="text"
                      name="email"
                      placeholder="Email"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('email') }"
                    />
                    <has-error :form="form" field="email"></has-error>
                  </div>

                <div class="form-group">
                    <input type="file" class="form-control" id="fileFuncionario"
                    name="foto"
                    placeholder="Escolha uma foto..."
                    :class="{ 'is-invalid': form.errors.has('foto') }"
                    >
                </div>

                </div>
              </div>
              <!-- END FORM MODAL -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
              <button v-show="!editmode" type="submit" class="btn btn-primary">Criar</button>
              <button v-show="editmode" type="submit" class="btn btn-primary">Actualizar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- END MODAL POPUP -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      nome: "",
      editmode: false,
      funcionarios: [],
      form: new Form({
        id: "",
        nome: "",
        morada: "",
        telefone: "",
        categoria: "",
        email: "",
        foto: ""
      })
    };
  },
  methods: {
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#createFuncionario").modal("show");
    },
    /*createCliente() {
      this.form
        .post("/api/cliente")
        .then(() => {
          this.loadClientes();
          $("#createCliente").modal("hide");
          this.form.reset();
          this.$swal("Good job!", "Cliente criado com sucesso!", "success");
        })
        .catch(() => {
          console.log("errorr on create Cliente component");
        });
    },
    
    editModal(cliente) {
      this.editmode = true;
      this.form.reset();
      $("#createFuncionario").modal("show");
      this.form.fill(cliente);
    },
    updateCliente() {
      this.form
        .put("api/cliente/" + this.form.id)
        .then(() => {
          this.$Progress.start();

          this.loadClientes();

          $("#createCliente").modal("hide");
          this.form.reset();
          this.$swal(
            "Good job!",
            "Dados Cliente atualizado com sucesso!",
            "success"
          );
        })
        .catch(() => {
          console.log("errorr on update cliente component");
        });
    },
    loadClientes() {
      this.$Progress.start();

      axios.get("api/cliente/").then(({ data }) => (this.clientes = data.data));
      this.$Progress.finish();
    },
    deleteCliente(id) {
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
        this.form
          .delete("api/cliente/" + id)
          .then(() => {
            this.loadClientes();
            this.$swal("Deleted!", "Cliente removido com sucesso!", "success");
          })
          .catch(() => {
            this.$swal("Failed!", "There was something wronge.", "warning");
          });
      });
    }
  },*/
    created() {
      this.$Progress.start();
      //this.loadClientes();
      this.$Progress.finish();
    }

    /*
  computed: {
    filtarclientes: function() {
      return this.clientes.filter(cliente => {
        return cliente.nome.match(this.nome);
      });
    }*/
  }

  // td drt ate
};
</script>
