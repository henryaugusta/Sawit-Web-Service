@extends('layouts.template')

@section('header')
    <script src="{{ asset('library/ckeditor/ckeditor.js') }}"></script>
    <style>
        #previewCover {
            object-fit: cover;
            height: 200px;
            width: 100%;
        }

        .text_prev {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3; /* number of lines to show */
            -webkit-box-orient: vertical;
        }

        .imgNews {
            border-radius: 20px !important;
            object-fit: cover;
            height: 200px !important;
            width: 100%;
        }

        .newsContainer {
            border-radius: 20px !important;
            box-shadow: 0 0 25px #3d2173a1 !important;
            transition: all ease 1s;
        }

        .newsContainer:hover {
            transform: scale(0.95) translateY(10px);
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
                        <span class="text-uppercase page-subtitle">Manage News Feed</span>
                        <h3 class="page-title">News Feed</h3>
                    </div>
                </div>

                <div class="row">
                    @forelse($news as $item )
                        <div class="col-lg-4 col-md-12">
                            <div class="card card-post card-round newsContainer">
                                <img class="card-img-top imgNews" id="imgPreview"
                                     src="{{ asset('/photo/news')."/".$item->pict_url }}"
                                     alt="Card image cap">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="avatar">
                                            <img src="{{ asset('/photo/profile')."/".$item->user_photo }}"
                                                 alt="..." class="avatar-img rounded-circle">
                                        </div>
                                        <div class="info-post ml-2">
                                            <p class="username">{{ $item->user_name }}</p>
                                            <p class="date text-muted">{{$item->created_at}}</p>
                                        </div>
                                    </div>
                                    <div class="separator-solid"></div>
                                    <h3 class="card-title" id="previewName">
                                        <a href="#">
                                            {{$item->title}}
                                        </a>
                                    </h3>
                                    <div class="text_prev mb-3 card-text text_prev">
                                        {!! $item->content !!}
                                    </div>
                                    <div class="row">
                                        <a href="{{url('news/')."/".$item->id}}"
                                           class="btn btn-primary btn-rounded btn-sm">Read
                                            More</a>
                                        <form action="{{route('news.delete',$item->id)}}" method="post">
                                            @method('post')
                                            @csrf
                                            <input type="hidden" name="redirectTo" value="admin/news/index">
                                            <button
                                                class="btn btn-danger btn-rounded btn-sm">Hapus
                                            </button>
                                        </form>
                                        <a href="{{url('news/')."/".$item->id}}"
                                           class="btn btn-warning btn-rounded btn-sm">Edit</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-primary  fade show container-fluid" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <strong>News Feed Belum Tersedia</strong><br><br>
                            <a href="{{url('admin/news/create')}}">
                            <button type="button" class="btn btn-outline-primary">Buat News Feed</button>
                            </a>
                        </div>
                    @endforelse

                </div>


            </div>
        </div>
    </div>

    <script>
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


            $(document).ready(function () {
                {{-- JS-SECTION-B --}}
                $('#tagsinput').tagsinput({
                    tagClass: 'badge-info'
                });


                $.myfunction = function () {
                    $("#previewName").text($("#inputTitle").val());
                    var title = $.trim($("#inputTitle").val())
                    if (title == "") {
                        $("#previewName").text("Judul Berita Anda Akan Ditampilkan Disini")
                    }
                };

                $("#inputTitle").keyup(function () {
                    $.myfunction();
                });

            });
        }
    </script>






@endsection


