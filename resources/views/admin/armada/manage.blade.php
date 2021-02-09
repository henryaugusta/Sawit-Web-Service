@extends('layouts.template')

@section('header')
    <script src="{{ asset('library/ckeditor/ckeditor.js') }}"></script>
    <style>
        #previewCover {
            object-fit: cover;
            height: 200px;
            width: 100%;
        }

    </style>
@endsection

@section('main')
    <div class="page-inner">
        <!-- Page Header -->
        <div class="page-header">
            <h4 class="page-title">Dashboard</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="#">
                        <i class="flaticon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Pages</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Starter Page</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container">

        <div class="container-fluid">
            @include('layouts.error')
            <div class="main-content-container container-fluid px-4">
                <div class="page-header row no-gutters mb-4">
                    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                        <span class="text-uppercase page-subtitle">Manage Armada Perusahaan</span>
                        <h3 class="page-title">Armada Perusahaan</h3>
                    </div>
                </div>

{{--                <div class="row">--}}
{{--                    @forelse($news as $item )--}}
{{--                        <p>Testingg </p>--}}
{{--                    @empty--}}

{{--                    @endforelse--}}
{{--                    <div class="col-lg-4 col-md-12">--}}
{{--                        <div class="card card-post card-round">--}}
{{--                            <img class="card-img-top" id="imgPreview"--}}
{{--                                 src="https://images.bisnis-cdn.com/posts/2020/01/20/1191916/antarafoto-harga-tbs-kelapa-sawit-mulai-membaik-071219-syf-3-1.jpg"--}}
{{--                                 alt="Card image cap">--}}
{{--                            <div class="card-body">--}}
{{--                                <div class="d-flex">--}}
{{--                                    <div class="avatar">--}}
{{--                                        <img src="{{ Storage::url('public/profile/') . Auth::user()->profile_url }}"--}}
{{--                                             alt="..." class="avatar-img rounded-circle">--}}
{{--                                    </div>--}}
{{--                                    <div class="info-post ml-2">--}}
{{--                                        <p class="username">{{ Auth::user()->name }}</p>--}}
{{--                                        <p class="date text-muted">20 Jan 18</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="separator-solid"></div>--}}
{{--                                <h3 class="card-title" id="previewName">--}}
{{--                                    <a href="#">--}}
{{--                                        Judul Berita Anda Ditampilkan Disini--}}
{{--                                    </a>--}}
{{--                                </h3>--}}
{{--                                <p class="card-text">Some quick example text to build on the card title and make up--}}
{{--                                    the bulk--}}
{{--                                    of the card's content.</p>--}}
{{--                                <a href="#" class="btn btn-primary btn-rounded btn-sm">Read More</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="col-lg-4 col-md-12">--}}
{{--                        <div class="card card-post card-round">--}}
{{--                            <img class="card-img-top" id="imgPreview"--}}
{{--                                 src="https://images.bisnis-cdn.com/posts/2020/01/20/1191916/antarafoto-harga-tbs-kelapa-sawit-mulai-membaik-071219-syf-3-1.jpg"--}}
{{--                                 alt="Card image cap">--}}
{{--                            <div class="card-body">--}}
{{--                                <div class="d-flex">--}}
{{--                                    <div class="avatar">--}}
{{--                                        <img src="{{ Storage::url('public/profile/') . Auth::user()->profile_url }}"--}}
{{--                                             alt="..." class="avatar-img rounded-circle">--}}
{{--                                    </div>--}}
{{--                                    <div class="info-post ml-2">--}}
{{--                                        <p class="username">{{ Auth::user()->name }}</p>--}}
{{--                                        <p class="date text-muted">20 Jan 18</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="separator-solid"></div>--}}
{{--                                <h3 class="card-title" id="previewName">--}}
{{--                                    <a href="#">--}}
{{--                                        Judul Berita Anda Ditampilkan Disini--}}
{{--                                    </a>--}}
{{--                                </h3>--}}
{{--                                <p class="card-text">Some quick example text to build on the card title and make up--}}
{{--                                    the bulk--}}
{{--                                    of the card's content.</p>--}}
{{--                                <a href="#" class="btn btn-primary btn-rounded btn-sm">Read More</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}


            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="modalEdit"
         tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLavel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="title"></p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            {{-- JS-SECTION-B --}}
            $('#tagsinput').tagsinput({
                tagClass: 'badge-info'
            });

            $('#modalEdit').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                title = button.data('title') // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('#title').text(title)
                modal.find('.modal-title').text('Permintaan Jual Sawit')
            })
        });

        window.onload = function () {
            CKEDITOR.replace('content', {
                filebrowserImageBrowseUrl: '/filemanager?type=Images',
                filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=',
                filebrowserBrowseUrl: '/filemanager?type=Files',
                filebrowserUploadUrl: '/filemanager/upload?type=Files&_token='
            })

            // jQuery and everything else is loaded
            var el = document.getElementById('input-image');
            el.onchange = function () {
                var fileReader = new FileReader();
                fileReader.readAsDataURL(document.getElementById("input-image").files[0])
                fileReader.onload = function (oFREvent) {
                    document.getElementById("imgPreview").src = oFREvent.target.result;
                };
            }


        }
    </script>


