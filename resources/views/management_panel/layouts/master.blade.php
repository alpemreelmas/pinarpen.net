<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title','Yönetici Paneli')</title>


    <!-- Custom fonts for this template-->
    <link href="{{asset('management_panel_assets/')}}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('management_panel_assets/')}}/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('management_panel_assets/')}}/vendor/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">

</head>
<body id="page-top" style="position: relative;">
    <!-- Page Wrapper -->
    <div id="wrapper" style="z-index: 100;">
        @include('management_panel.layouts.sidebar')

        <!-- End of Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content ">
            @include('management_panel.layouts.menu')

                <!-- Begin Page Content -->
                <div class="container-fluid pt-4">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
                        <a href="{{url('/')}}" target="_blank"
                           class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-globe fa-sm text-white-50"></i> Siteye git</a>
                    </div>
                    @yield('content')
                    <footer class="sticky-footer bg-white">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Copyright &copy; Blog site admin dashboard {{date('Y')}}</span>
                            </div>
                        </div>
                    </footer>
                </div>


            </div>
            <!-- End of Content Wrapper -->


        </div>
        <!-- End of Page Wrapper -->


    </div>

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
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="#">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('management_panel_assets/')}}/vendor/jquery/jquery.min.js"></script>
    <script src="//cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
    <script src="{{asset('management_panel_assets/')}}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('management_panel_assets/')}}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('management_panel_assets/')}}/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="{{asset('management_panel_assets/')}}/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('management_panel_assets/')}}/js/demo/chart-area-demo.js"></script>
    <script src="{{asset('management_panel_assets/')}}/js/demo/chart-pie-demo.js"></script>
    <!-- Page level plugins -->
    <script src="{{asset('management_panel_assets/')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('management_panel_assets/')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('management_panel_assets/')}}/js/demo/datatables-demo.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>

    @yield("js")
</body>

</html>

