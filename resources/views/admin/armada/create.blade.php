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

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="container-fluid">

                <div class="main-content-container container-fluid px-4">
                    <div class="page-header row no-gutters mb-4">
                        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                            <span class="text-uppercase page-subtitle">Blog Posts</span>
                            <h3 class="page-title">Add New Post</h3>
                        </div>
                    </div>

                    <!-- End Page Header -->
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <!-- Add New Post Form -->
                            <div class="card card-small mb-3">
                                <div class="card-body">
                                    <div class="form-group">

                                        <label class="font-weight-bold">JUDUL</label>
                                        <input id="inputTitle" type="text"
                                               class="form-control @error('title') is-invalid @enderror" name="title"
                                               value="{{ old('title') }}" placeholder="Masukkan Judul Berita">

                                        <!-- error message untuk title -->
                                        @error('title')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- / Add New Blog Form -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card border-0 shadow rounded">
                                        <div class="card-body">
                                            @csrf
                                            <div class="form-group">
                                                <label class="font-weight-bold">GAMBAR</label>
                                                <input id="input-image" type="file" onchange="previewPhoto()"
                                                       class="form-control @error('image') is-invalid @enderror"
                                                       name="image">

                                                <!-- error message untuk title -->
                                                @error('image')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label class="font-weight-bold">Isi Blog</label>
                                                <textarea
                                                    class="form-control ckeditor @error('content') is-invalid @enderror"
                                                    name="content" rows="5"
                                                    placeholder="Masukkan Konten Blog">{{ old('content') }}</textarea>

                                                <!-- error message untuk content -->
                                                @error('content')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>


                                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                                            <button type="reset" class="btn btn-md btn-warning">RESET</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- Side Bar --}}
                        <div class="col-lg-4 col-md-12">
                            {{-- Card Preview --}}
                            <div class="card card-post card-round">
                                <img class="card-img-top" id="imgPreview"
                                     src="https://images.bisnis-cdn.com/posts/2020/01/20/1191916/antarafoto-harga-tbs-kelapa-sawit-mulai-membaik-071219-syf-3-1.jpg"
                                     alt="Card image cap">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="avatar">
                                            <img src="{{ Storage::url('public/profile/') . Auth::user()->profile_url }}"
                                                 alt="..." class="avatar-img rounded-circle">
                                        </div>
                                        <div class="info-post ml-2">
                                            <p class="username">{{ Auth::user()->name }}</p>
                                            <p class="date text-muted">20 Jan 18</p>
                                        </div>
                                    </div>
                                    <div class="separator-solid"></div>
                                    <h3 class="card-title" id="previewName">
                                        <a href="#">
                                            Judul Berita Anda Ditampilkan Disini
                                        </a>
                                    </h3>
                                    <p class="card-text">Some quick example text to build on the card title and make up
                                        the bulk
                                        of the card's content.</p>
                                    <a href="#" class="btn btn-primary btn-rounded btn-sm">Read More</a>
                                </div>
                            </div>

                            <!-- Post Overview -->
                            <div class='card card-small mb-3 d-none'>
                                <div class="card-header border-bottom">
                                    <h6 class="m-0">Preview</h6>
                                </div>
                                <div class='card-body'>
                                    <p class="card-text">Ketik tag dan enter untuk memasukkan tag blog</p>
                                    <div class="form-group">
                                        <input type="text" id="tagsinput" class="form-control" value="Blog"
                                               data-role="tagsinput">
                                    </div>
                                </div>
                            </div>
                            <!-- / Post Overview -->
                            <!-- Post Overview -->
                            <div class='card card-small mb-3'>
                                <div class="card-header border-bottom">
                                    <h6 class="m-0">Categories</h6>
                                </div>
                                <div class='card-body p-0'>
                                    <div class="container">


                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item px-3 pb-2 row">
                                                <div class="custom-control custom-checkbox mb-1 col-12">
                                                    <input type="checkbox" name="category[]" value="others"
                                                           class="custom-control-input" id="category1" checked>
                                                    <label class="custom-control-label"
                                                           for="category1">Lain-lain</label>
                                                </div>
                                                <div class="custom-control custom-checkbox mb-1 1 col-12">
                                                    <input type="checkbox" name="category[]" value="design"
                                                           class="custom-control-input" id="category2">
                                                    <label class="custom-control-label" for="category2">Design</label>
                                                </div>
                                                <div class="custom-control custom-checkbox mb-1 1 col-12">
                                                    <input type="checkbox" name="category[]" value="3d"
                                                           class="custom-control-input" id="category3">
                                                    <label class="custom-control-label" for="category3">3D
                                                        Modelling</label>
                                                </div>
                                                <div class="custom-control custom-checkbox mb-1">
                                                    <input type="checkbox" name="category[]" value="office"
                                                           class="custom-control-input" id="category4">
                                                    <label class="custom-control-label" for="category4">Office</label>
                                                </div>
                                                <div class="custom-control custom-checkbox mb-1">
                                                    <input type="checkbox" name="category[]" value="multiplatform"
                                                           class="custom-control-input" id="category5">
                                                    <label class="custom-control-label" for="category5">Multiplatform
                                                        Programming</label>
                                                </div>
                                                <div class="custom-control custom-checkbox mb-1">
                                                    <input type="checkbox" name="category[]" value="front_end"
                                                           class="custom-control-input" id="category6">
                                                    <label class="custom-control-label" for="category6">Front-End
                                                        App</label>
                                                </div>
                                                <div class="custom-control custom-checkbox mb-1">
                                                    <input type="checkbox" name="category[]" value="back_end"
                                                           class="custom-control-input" id="category7">
                                                    <label class="custom-control-label" for="category7">Back-end
                                                        App</label>
                                                </div>
                                                <div class="custom-control custom-checkbox mb-1">
                                                    <input type="checkbox" name="category[]" value="fullstack"
                                                           class="custom-control-input" id="category8">
                                                    <label class="custom-control-label"
                                                           for="category8">Fullstack</label>
                                                </div>
                                                <div class="custom-control custom-checkbox mb-1">
                                                    <input type="checkbox" name="category[]" value="mobile"
                                                           class="custom-control-input" id="category9">
                                                    <label class="custom-control-label" for="category9">Mobile</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- / Post Overview -->
                        </div>
                    </div>
                </div>
            </div>
        </form>
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


