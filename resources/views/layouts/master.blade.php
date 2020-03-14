<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Car Wash</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!--
  <script>
    /*window.Laravel = {
      !!json_encode([
        'csrfToken' => csrf_token(),
      ]) !!
    }; */
  </script> -->
  @if(!auth()->guest())
  <script>
    window.Laravel.userId = {
      auth::user()->id
    }
  </script>
  @endif

  <link rel="stylesheet" href="/css/app.css">
  <link rel="stylesheet" href="/css/custom.css">
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper" id="app">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href=""><i class="fas fa-bars"></i></a>
        </li>

        <dropdown-notifications :userid="{{ auth::user()->id }}" :unreads="{{ auth::user()->unreadNotifications }}"></dropdown-notifications>

      </ul>
      <!-- SEARCH FORM 
      <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
          <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>
    -->

    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo 
      <a href="index3.html" class="brand-link">
        <img src="https://adminlte.io/themes/dev/AdminLTE/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
      </a>
      -->

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="https://adminlte.io/themes/dev/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">{{auth::user()->name}}</a>
          </div>
        </div>

        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <router-link to="/home" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt text-blue"></i>
                <p>Dash</p>
              </router-link>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p>
                  Prestação Serviços
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <router-link to="/agendamento" class="nav-link">
                    <i class="nav-icon fas fa-building"></i>
                    <p>Agendamento</p>
                  </router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/pagamento" class="nav-link">
                    <i class="nav-icon fas fa-project-diagram"></i>
                    <p>Pagamentos</p>
                  </router-link>
                </li>

              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p>
                  Gestão Stock
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <router-link to="/produtos" class="nav-link">
                    <i class="nav-icon fas fa-product"></i>
                    <p>+ Produtos</p>
                  </router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/compras" class="nav-link">
                    <i class="nav-icon fas fa-project-diagram"></i>
                    <p>+ Compras</p>
                  </router-link>
                </li>

              </ul>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p>
                  Gestao Interna
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <router-link to="/servico" class="nav-link">
                    <i class="nav-icon fas fa-building"></i>
                    <p>Serviço</p>
                  </router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/produtos" class="nav-link">
                    <i class="nav-icon fas fa-project-diagram"></i>
                    <p>Produtos</p>
                  </router-link>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Entidades Externas
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <router-link to="/cliente" class="nav-link">
                    <i class="nav-icon fas fa-building"></i>
                    <p>Cliente</p>
                  </router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/fornecedor" class="nav-link">
                    <i class="nav-icon fas fa-project-diagram"></i>
                    <p>Fornecedor</p>
                  </router-link>
                </li>

              </ul>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Gestão Utilizadores
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('logout') }}" onclick="
                        event.preventDefault();
                        document.getElementById('delete-form').submit();
                ">
                <i class="logout nav-icon fa fa-power-off"></i>
                <p class="logout" id="logout">Logout</p>

              </a>
              <form method="POST" action="{{ route('logout') }}" id="delete-form" style="display:none;">
                @csrf
              </form>
            </li>
          </ul>
        </nav>
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
            </div><!-- /.col -->

            <div id="components-demo">
            </div>

          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="container">

        <main class="py-9">
          {{--  @yield('content') --}}
          <router-view></router-view>
          <vue-progress-bar></vue-progress-bar>

        </main>

      </div>

      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
        Anything you want
      </div>

      <div class="newclass">
        <p>teste yess</p>
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; Jorge Varela</a>.</strong> All rights reserved.
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="/js/app.js"></script>

</body>

</html>