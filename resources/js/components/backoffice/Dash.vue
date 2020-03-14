<template>
  <div class="container">
        <page-adress breadcrumbTittle=""></page-adress>

    <div class="row">
      <div class="col-md-4 col-lg-4 col-xl-3">
        <div class="card">
          <!---->
          <!---->
          <div class="card-body">
            <div>
              <div class="row">
                <div class="col-12">
                  <div class="icon-big text-center icon-warning">
                    <i class="ti-server"></i>CARROS LAVADOS
                  </div>
                </div>
                <div class="col-12">
                  <div class="numbers">
                    <b>Total:</b>3
                  </div>
                </div>
                <div class="col-12">
                  <div class="numbers">
                    <b>Valor total:</b>46.00€
                  </div>
                </div>
              </div>

              <div>
                <hr />

                <div class="stats">
                  <i class="ti-reload"></i> Hoje
                </div>
              </div>
            </div>
          </div>
          <!---->
        </div>
      </div>
      <div class="col-md-4 col-lg-4 col-xl-3">
        <div class="card">
          <!---->
          <!---->
          <div class="card-body">
            <div>
              <div class="row">
                <div class="col-12">
                  <div class="icon-big text-center icon-success">
                    <i class="ti-server"></i>TOTAL CLIENTES REGISTADO
                  </div>
                </div>
                <div class="col-12">
                  <div class="numbers">
                    <b>Total:</b>9
                  </div>
                </div>
                <div class="col-12">
                  <div class="numbers">
                    <b>Total activos:</b>9
                  </div>
                </div>
              </div>
              <div>
                <hr />
                <div class="stats">
                  <i class="ti-calendar"></i> Hoje
                </div>
              </div>
            </div>
          </div>
          <!---->
        </div>
      </div>
      <div class="col-md-4 col-lg-4 col-xl-3">
        <div class="card">
          <!---->
          <!---->
          <div class="card-body">
            <div>
              <div class="row">
                <div class="col-12">
                  <div class="icon-big text-center icon-danger">
                    <i class="ti-pulse"></i> SERVIÇOS MAIS REQUISITADOS
                  </div>
                </div>
                <div class="col-12">
                  <div class="numbers">
                    <b>Serviço:</b>Clinic plus
                  </div>
                </div>
                <div class="col-12">
                  <div class="numbers">
                    <b>Número serviços:</b>14
                  </div>
                </div>
              </div>
              <div>
                <hr />
                <div class="stats">
                  <i class="ti-timer"></i> Última semana
                </div>
              </div>
            </div>
          </div>
          <!---->
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  data: () => {
    return {
      breadcumb: "Fornecedor"
    };
  },
  mounted() {
    console.log("Component HOME.");
  }
};

</script>