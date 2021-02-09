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
                    <a href="#">Kendaraan</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Registrasi</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container">

        <form action="{{url('news/store')}}" method="POST" enctype="multipart/form-data">
            <div class="container-fluid">
                @include('layouts.error')

                <div class="main-content-container container-fluid px-4">
                    <div class="page-header row no-gutters mb-4">
                        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                            <span class="text-uppercase page-subtitle">Registrasi Kendaraan Baru</span>
                            <h3 class="page-title">Armada Perusahaan</h3>
                        </div>
                    </div>

                    <!-- End Page Header -->
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <!-- Add New Post Form -->
                            <div class="card card-small mb-3">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Merk Kendaraan</label>
                                        <input id="inputTitle" type="text"
                                               class="form-control @error('merk') is-invalid @enderror" name="merk"
                                               value="{{ old('merk') }}" placeholder="Merk Kendaraan">
                                        <!-- error message untuk title -->
                                        @error('merk')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Nomor Polisi/Plat Nomor</label>
                                        <input id="nopol" type="text"
                                               class="form-control @error('nopol') is-invalid @enderror" name="nopol"
                                               value="{{ old('nopol') }}" placeholder="Nomor Polisi">
                                        <!-- error message untuk title -->
                                        @error('nopol')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">No Mesin</label>
                                        <input id="nomor_mesin" type="text"
                                               class="form-control @error('nomor_mesin') is-invalid @enderror" name="nomor_mesin"
                                               value="{{ old('nomor_mesin') }}" placeholder="No Mesin">
                                        <!-- error message untuk title -->
                                        @error('nomor_mesin')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="container row">
                                        <div class="form-group col-md-6 col-12">
                                            <label class="font-weight-bold">Kapasitas Maximum</label>
                                            <input id="max_capacity" type="number" min="0"
                                                   class="form-control @error('max_capacity') is-invalid @enderror" name="max_capacity"
                                                   value="{{ old('max_capacity') }}" placeholder="Kapasitas Maximum">
                                            <!-- error message untuk title -->
                                            @error('max_capacity')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6 col-12">
                                            <label class="font-weight-bold">Berat Maximum</label>
                                            <input id="max_weight" type="number" min="0"
                                                   class="form-control @error('max_weight') is-invalid @enderror" name="max_weight"
                                                   value="{{ old('max_weight') }}" placeholder="Berat Maximum">
                                            <!-- error message untuk title -->
                                            @error('max_weight')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / Add New Blog Form -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card border-0 shadow rounded">
                                        <div class="card-body">
                                            @csrf


                                            <div class="form-group fallback">
                                                <label class="font-weight-bold">GAMBARxxx</label>
                                                <input id="upload_file" type="file"
                                                       class="form-control @error('image') is-invalid @enderror"
                                                       required name="upload_file[]"
                                                       onchange="previewImage();"
                                                       multiple>

                                                <!-- error message untuk title -->
                                                @error('image')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div id="image_preview" class="row mt-4"></div>

                                            <script>
                                                const clearPreview = (elementID) => {
                                                    let div = document.getElementById(elementID);
                                                    while (div.firstChild) {
                                                        div.removeChild(div.firstChild);
                                                    }
                                                    document.getElementById("upload_file").innerHTML = "";
                                                }

                                                const previewImage = () => {
                                                    let total_file = document.getElementById("upload_file").files.length;
                                                    clearPreview('image_preview');
                                                    for (var i = 0; i < total_file; i++) {
                                                        $('#image_preview').append(
                                                            "<a href='" + URL.createObjectURL(event.target.files[i]) + "' class='col-6 col-md-3 mb-4'>"
                                                            + "<img width='200px' height='100px' src='" + URL.createObjectURL(event.target.files[i]) + "' class='img-fluid  avatar-img rounded'></a>");
                                                    }
                                                }
                                            </script>

                                            <div class="form-group">
                                                <label class="font-weight-bold">Konten Berita</label>
                                                <textarea
                                                    required
                                                    class="form-control ckeditor @error('contentz') is-invalid @enderror"
                                                    name="contentz" rows="15"
                                                    placeholder="Masukkan Konten Berita">{{ old('content') }}</textarea>

                                                <!-- error message untuk content -->
                                                @error('contentz')
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
                                            <img src="{{ asset('/photo/profile')."/". Auth::user()->profile_url }}"
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
                                    <h6 class="m-0">Petunjuk</h6>
                                </div>
                                <div class='card-body p-0'>
                                    <div class="container">
                                        Test
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



@endsection

@section('script')
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

                $('#image_preview').magnificPopup({
                    delegate: 'a',
                    type: 'image',
                    removalDelay: 300,
                    gallery: {
                        enabled: true,
                    },
                    mainClass: 'mfp-with-zoom',
                    zoom: {
                        enabled: true,
                        duration: 300,
                        easing: 'ease-in-out',
                        opener: function (openerElement) {
                            return openerElement.is('img') ? openerElement : openerElement.find('img');
                        }
                    }
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


