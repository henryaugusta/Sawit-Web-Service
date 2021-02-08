@extends('layouts.template')

@section('header')
    <script src="{{ asset('library/ckeditor/ckeditor.js') }}"></script>
    <style>
        #imgPreviewz {
            object-fit: cover;
            height: 300px;
            width: 100%;
            border-radius: 20px;
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
                                    <div id="content_db{{$item->id}}" class="text_prev mb-3 card-text text_prev">
                                        {!! $item->content !!}
                                    </div>
                                    <div class="d-none"
                                         id="image_src{{$item->id}}">{{asset('/photo/news')."/".$item->pict_url }}</div>
                                    <div class="row">
                                        <a href="{{url('news/')."/".$item->id}}"
                                           class="btn btn-primary btn-rounded btn-sm">Read
                                            More</a>
                                        <form action="{{route('news.delete',$item->id)}}" method="post"
                                              onsubmit="return confirm('Anda Yakin Ingin Menghapus Berita Ini ??');">
                                            @method('post')
                                            @csrf
                                            <input type="hidden" name="redirectTo" value="admin/news/index">
                                            <button
                                                class="btn btn-danger btn-rounded btn-sm">Hapus
                                            </button>
                                            <button onclick="modalAct({{$item->id}})" type="button"
                                                    class="btn btn-warning btn-rounded btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#modalEdit"
                                                    data-id="{{$item->id}}"
                                                    data-title="{{$item->title}}">Edit
                                            </button>
                                        </form>

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

    <form action="{{url('news/update')}}" method="post"  enctype="multipart/form-data">
        @method('POST')
        @csrf


        <input hidden id="update_idx" name="update_idx" value="">
        <input hidden id="redirectTo" name="redirectTo" value="admin/news/index">

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
                        <img class="mx-auto d-block" id="imgPreviewz"
                             src="https://images.bisnis-cdn.com/posts/2020/01/20/1191916/antarafoto-harga-tbs-kelapa-sawit-mulai-membaik-071219-syf-3-1.jpg"
                             alt="Card image cap">
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

                        <div class="form-group">
                            <label class="font-weight-bold">GAMBAR </label>
                            <input id="input-image" type="file" onchange="previewPhoto()"
                                   class="form-control @error('image') is-invalid @enderror"
                                   name="image" >
                            <small>(Upload baru untuk mengganti gambar)</small>
                            @error('image')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <textarea
                                id="ta_modal"
                                class="form-control @error('contentz') is-invalid @enderror"
                                name="update_content" rows="10"
                                placeholder="Masukkan Konten Berita">
                                {{ old('content') }}</textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>

                </div>
            </div>
        </div>
    </form>

@endsection

@section('script')
    <script>
        let modalAct = (id) => {
            let text_area = document.getElementById('ta_modal');
            let title = document.getElementById('modalEditLavel');
            let contentz = document.getElementById('content_db' + id).innerText;
            let srcz = document.getElementById('image_src' + id).innerText;

            let modal_image = document.getElementById('imgPreviewz');

            document.getElementById("input-image").value = "";
            document.getElementById("update_idx").value = `${id}`;

            modal_image.src = srcz;
            title.innerText = "Edit Feed News"
            text_area.value = contentz;
        }

        $(document).ready(function () {
            {{-- JS-SECTION-B --}}
            $('#tagsinput').tagsinput({
                tagClass: 'badge-info'
            });


            $('#modalEdit').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var title = button.data('title') // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('#title').text(title)
                modal.find('#inputTitle').val(title)


            })
        });

        window.onload = function () {
            // jQuery and everything else is loaded
            var el = document.getElementById('input-image');
            el.onchange = function () {
                var fileReader = new FileReader();
                fileReader.readAsDataURL(document.getElementById("input-image").files[0])
                fileReader.onload = function (oFREvent) {
                    document.getElementById("imgPreviewz").src = oFREvent.target.result;
                };
            }


        }
    </script>
@endsection


