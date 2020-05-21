<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Article Management | {{ (session('menu_title') ? session('menu_title') : '') }}</title>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ get_template('plugins/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ get_template('plugins/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ get_template('plugins/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ get_template('dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ get_template('dist/css/skins/_all-skins.min.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ get_template('plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ get_template('plugins/datatables/dataTables.bootstrap.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Sweetalert -->
    <link rel="stylesheet" href="{{ get_template('plugins/sweetalert2/dist/sweetalert2.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ get_template('plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ get_template('plugins/select2/select2.bootstrap.css') }}">
    <style type="text/css">
        body{
            padding-right: 0 !important;
        }
        .ui-datepicker{z-index: 9999999 !important;}
        .swal2-popup {
            font-size: 1.5rem !important;
        }

        .swal2-icon {
            font-size: 1rem !important;
        }
    </style>
    @yield('page-css')
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="{{ route('dashboard.index') }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">
                    <b> <img src="{{ url('image/hs_logo.png') }}" class="img-responsive"></b>
                </span>
                <span class="logo-lg"><b>Article</b>Manager</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ url('image/avatar.png') }}" class="user-image" alt="User Image">
                                <span class="hidden-xs">Alexander Pierce</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="{{ url('image/avatar.png') }}" class="img-circle" alt="User Image">
                                    <p> {{ auth('admin')->user()->name }} - {{ auth('admin')->user()->role->name }} </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{{ route('users.profile', auth('admin')->user()->hashid) }}" class="btn btn-default btn-flat">Update Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
            <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{ url('image/avatar.png') }}" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                    <p>{{ auth('admin')->user()->name }}</p>
                    <p>{{ auth('admin')->user()->role->name }}</p>
                    </div>
                </div>
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="{{ activeMenu('dashboard') }}">
                        <a href="{{ route('dashboard.index') }}">
                            <i class="fa fa-tachometer"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    @can('access', $permissions1)
                    <li class="treeview {{ (activeMenu('roles') == 'active' || activeMenu('users') == 'active' ? 'active':'') }}">
                        <a href="#">
                            <i class="fa fa-users"></i> <span>User Management</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @can('access', $permissions2)
                            <li class="{{ activeMenu('roles') }}">
                                <a href="{{ route('roles.index') }}"><i class="fa fa-circle-o"></i> Roles</a>
                            </li>
                            @endcan
                            @can('access', $permissions3)
                            <li class="{{ activeMenu('users') }}">
                                <a href="{{ route('users.index') }}"><i class="fa fa-circle-o"></i> Users</a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                    @can('access', $permissions4)
                    <li class="{{ activeMenu('articles') }}">
                        <a href="{{ route('articles.index') }}">
                            <i class="fa fa-newspaper-o"></i> <span>Articles</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('page-body')
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2020 <a href="#">Article Management</a>.</strong>
            All rights reserved.
            <div class="pull-right d-none d-sm-inline-block">
                <b>Version</b> 0.0.1
            </div>
        </footer>
    </div>

<!-- jQuery -->
<script type="text/javascript" src="{{ get_template('plugins/jquery/dist/jquery.min.js') }}"></script>
<!-- jQuery UI -->
<script type="text/javascript" src="{{ get_template('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script type="text/javascript" src="{{ get_template('plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- AdminLTE App -->
<script type="text/javascript" src="{{ get_template('dist/js/adminlte.min.js') }}"></script>

<!-- OPTIONAL SCRIPTS -->
<!-- DataTables -->
<script type="text/javascript" src="{{ get_template('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ get_template('plugins/datatables/extensions/Pagination/input_old.js') }}"></script>
<script type="text/javascript" src="{{ get_template('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- Sweetalert -->
<!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser (sweetalert)-->
<script href="https://cdn.jsdelivr.net/npm/promise-polyfill@7/dist/polyfill.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
<script type="text/javascript" src="{{ get_template('plugins/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<!-- Select2 -->
<script type="text/javascript" src="{{ get_template('plugins/select2/select2.full.min.js') }}"></script>
<!-- InputMask -->
<script type="text/javascript" src="{{ get_template('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script type="text/javascript" src="{{ get_template('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script type="text/javascript" src="{{ get_template('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<!-- Datepicker -->
<script type="text/javascript" src="{{ get_template('plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ get_template('plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ get_template('plugins/fastclick/lib/fastclick.js') }}"></script>
<script type="text/javascript">
$(function () {
    $('body').on('hidden.bs.modal', function () {
        if($('.modal.in').length > 0)
        {
            $('body').addClass('modal-open');
        }
    });

    $.ajaxSetup({
       headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    });

    $.fn.dataTable.ext.errMode = 'none'; 
    $('table').on('error.dt', function(e, settings, techNote, message) {
      console.log( 'An error occurred: ', message); 
    });

    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
});
</script>
@yield('page-js')
</body>
</html>
