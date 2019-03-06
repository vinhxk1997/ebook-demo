<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>
    <!-- Bootstrap core CSS-->
    <link href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('bower_components/startbootstrap-sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="{{ asset('bower_components/startbootstrap-sb-admin/vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('bower_components/startbootstrap-sb-admin/css/sb-admin.css') }}" rel="stylesheet">

    <!-- CKEditor -->
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>

    <!--main CSS-->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>

<body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

        <a class="navbar-brand mr-1" href="{{ route('admin') }}">eBook</a>

        <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Navbar Search -->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <input type="text" class="form-control" aria-label="Search"
                    aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Navbar -->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown no-arrow mx-2">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-language"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
                    <a class="dropdown-item" href="{!! route('change-language', ['en']) !!}">{{ trans('tran.english') }}</a>
                    <a class="dropdown-item" href="{!! route('change-language', ['vi']) !!}">{{ trans('tran.vietnamese') }}</a>
                </div>
            </li>
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <span class="badge badge-danger">8</span>
                    <i class="fas fa-bell fa-fw"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
                    <a class="dropdown-item" href="#"></a>
                    <a class="dropdown-item" href="#"></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"></a>
                </div>
            </li>
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <span class="badge badge-danger">9+</span>
                    <i class="fas fa-user-circle fa-fw"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#"></a>
                    <a class="dropdown-item" href="#"></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">{{ trans('tran.logout') }}</a>
                </div>
            </li>
        </ul>

    </nav>

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="sidebar navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>{{ trans('tran.dashboard') }}</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="{{ route('user') }}" id="pagesDropdown" role="button">
                    <i class="fas fa-fw fa-user"></i>
                    <span>{{ trans('tran.user') }}</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="{{ route('story_admin') }}" id="pagesDropdown" role="button">
                    <i class="fas fa-fw fa-book"></i>
                    <span>{{ trans('tran.story') }}</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="pagesDropdown" role="button">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>{{ trans('tran.config') }}</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="pagesDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>{{ trans('tran.comment') }}</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <a class="dropdown-item" href="#">{{ trans('tran.story_comment') }}</a>
                    <a class="dropdown-item" href="#">{{ trans('tran.review_comment') }}</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-flag"></i>
                    <span>{{ trans('tran.report') }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('categories') }}">
                    <i class="fab fa-medium-m"></i>
                    <span>{{ trans('tran.meta') }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('review') }}">
                    <i class="fas fa-tv"></i>
                    <span>{{ trans('tran.review') }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-th"></i>
                    <span>{{ trans('tran.banner') }}</span></a>
            </li>
        </ul>

        <div id="content-wrapper">

            <div class="container-fluid">

                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin') }}">{{ trans('tran.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ trans('tran.dashboard') }}</li>
                </ol>

                <!-- Page Content -->
                @yield('content')

            </div>
            <!-- /.container-fluid -->

            <!-- Sticky Footer -->
            <!-- <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright © Your Website 2018</span>
                    </div>
                </div>
            </footer> -->

        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('tran.ready_leave') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">{{ trans('tran.logout_mes') }}</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ trans('tran.cancel') }}</button>
                    <a class="btn btn-primary" href="{{ route('home') }}">{{ trans('tran.logout') }}</a>
                </div>
            </div>
        </div>
    </div>
</body>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('bower_components/startbootstrap-sb-admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('bower_components/startbootstrap-sb-admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Page level plugin JavaScript-->
    <script src="{{ asset('bower_components/startbootstrap-sb-admin/vendor/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('bower_components/startbootstrap-sb-admin/vendor/datatables/dataTables.bootstrap4.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('bower_components/startbootstrap-sb-admin/js/sb-admin.min.js') }}"></script>

    <!-- Demo scripts for this page-->
    <script src="{{ asset('bower_components/startbootstrap-sb-admin/js/demo/datatables-demo.js') }}"></script>
    
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
