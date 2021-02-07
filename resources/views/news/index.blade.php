<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>Atlantis Bootstrap 4 Admin Dashboard</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport'/>
    <link rel="icon" href="{{ asset('main_asset/examples') }}/assets/img/icon.ico" type="image/x-icon"/>

    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css">

    <!-- Toastr  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
          integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
          crossorigin="anonymous"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
            integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
            crossorigin="anonymous"></script>


    <!-- Fonts and icons -->
    <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands", "simple-line-icons"
                ],
                urls: ['{{ asset('main_asset/examples') }}/assets/css/fonts.min.css'
                ]
            },
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>

@yield('header')

<!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('main_asset/examples') }}/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('main_asset/examples') }}/assets/css/atlantis.css">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    {{--
    <link rel="stylesheet" href="../assets/css/demo.css"> --}}
</head>

<body>
<div class="wrapper fullheight-side sidebar_minimize">
    <div class="main-panel full-height">
        @yield('main')

        <div class="page-inner">
            <!-- Page Header -->
            <div class="page-header">
                <h4 class="page-title">News Feed</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{url('/home')}}">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">News Feed</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        @if($news != null)
                            {{$news->title}}
                        @endif
                    </li>
                </ul>
            </div>
            <hr>
            @if($news != null)
                <div class="page-header row no-gutters mb-4">
                    <div class="col-12 col-sm-12 text-center text-sm-left mb-0">
                        <span class="text-uppercase page-subtitle">News Posts</span>
                        <h3 class="page-title">
                            {{$news->title}} </h3>
                    </div>
                </div>
            @endif
            <div class="card card-post card-round">

                @if($news != null)
                    <img class="card-img-top" id="imgPreview"
                         src="{{ asset('/photo/news')."/".$news->pict_url }}"
                         alt="Card image cap">
                    <div class="card-body">
                        <h3 class="page-title">{{$news->title}} </h3>
                        {!! $news->content !!}
                        <p>Ditulis Oleh : {{$news->user_name}} </p>
                        <p>Pada Tanggal : {{$news->created_at}} </p>
                    </div>
                @endif
            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="http://www.themekita.com">
                                ThemeKita
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Help
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Licenses
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright ml-auto">
                    2018, made with <i class="fa fa-heart heart text-danger"></i> by <a
                        href="http://www.themekita.com">ThemeKita</a>
                </div>
            </div>
        </footer>
    </div>


    <!--   Core JS Files   -->
    <script src="{{ asset('main_asset/examples') }}/assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="{{ asset('main_asset/examples') }}/assets/js/core/popper.min.js"></script>
    <script src="{{ asset('main_asset/examples') }}/assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script
        src="{{ asset('main_asset/examples') }}/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js">
    </script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>


    <!-- Chart JS -->
    <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/datatables/datatables.min.js"></script>


    <!-- Select2 -->
    <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/select2/select2.full.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

{{--    <!-- Bootstrap Toggle -->--}}
{{--    <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>--}}

{{--    <!-- Moment JS -->--}}
{{--    <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/moment/moment.min.js"></script>--}}

<!-- jQuery Vector Maps -->
    <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/jqvmap/jquery.vmap.min.js"></script>
    <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

    <!-- Google Maps Plugin -->
{{--    <script src="../assets/js/plugin/gmaps/gmaps.js"></script>--}}

{{--    <!-- Dropzone -->--}}
{{--    <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/dropzone/dropzone.min.js"></script>--}}

{{--    <!-- Fullcalendar -->--}}
{{--    <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/fullcalendar/fullcalendar.min.js"></script>--}}

{{--    <!-- DateTimePicker -->--}}
{{--    <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/datepicker/bootstrap-datetimepicker.min.js">--}}
{{--    </script>--}}

<!-- Bootstrap Tagsinput -->
    <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js">
    </script>

    <!-- Bootstrap Wizard -->
    <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/bootstrap-wizard/bootstrapwizard.js"></script>

    <!-- jQuery Validation -->
    <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/jquery.validate/jquery.validate.min.js"></script>

{{--    <!-- Summernote -->--}}
{{--    <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/summernote/summernote-bs4.min.js"></script>--}}


<!-- Magnific Popup -->
    <script
        src="{{ asset('main_asset/examples') }}/assets/js/plugin/jquery.magnific-popup/jquery.magnific-popup.min.js">
    </script>

    <!-- Atlantis JS -->
    <script src="{{ asset('main_asset/examples') }}/assets/js/atlantis.min.js"></script>

    <!-- Atlantis DEMO methods, don't include it in your project! -->
{{-- <script src="{{ asset('main_asset/examples') }}/assets/js/setting-demo.js">
</script> --}}
{{-- <script src="{{ asset('main_asset/examples') }}/assets/js/demo.js"></script>
--}}
{{-- <script src="{{ asset('main_asset/examples') }}/assets/js/demo.js"></script>
--}}


@yield('script')

</body>

</html>
