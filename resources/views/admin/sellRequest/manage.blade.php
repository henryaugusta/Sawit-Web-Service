@extends('layouts.template')

@section('header')
    <!--Leaflet JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
@endsection

@section('script')

    <script>
        let sLat = -7.046379;
        let sLong = 107.555881;
        $(document).ready(function () {

            $('#exampleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                lat = button.data('lat') // Extract info from data-* attributes
                long = button.data('long') // Extract info from data-* attributes
                sLat = button.data('lat');
                sLong = button.data('long');

                var mymap = L.map('mapid').setView([sLat, sLong], 2
                php
                3
            )
                ;
                var popup = L.popup();
                let myMarker = L.marker([sLat, sLong]).addTo(mymap)
                    .bindPopup("Silakan Pindahkan Pin Ini Ke Lokasi Anda.").openPopup();
                myMarker.addTo(mymap);

                L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiaGVucnlhdWd1c3RhIiwiYSI6ImNra2pjaDAxcDAyYngydnF0dnppZzByZzgifQ.UKzJXFzQPNIzrri9UrALxQ', {
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    maxZoom: 18,
                    id: 'mapbox/streets-v11',
                    tileSize: 512,
                    zoomOffset: -1,
                    accessToken: 'your.mapbox.access.token'
                }).addTo(mymap);

                L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiaGVucnlhdWd1c3RhIiwiYSI6ImNra2pjaDAxcDAyYngydnF0dnppZzByZzgifQ.UKzJXFzQPNIzrri9UrALxQ', {
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    maxZoom: 18,
                    id: 'mapbox/streets-v11',
                    tileSize: 512,
                    zoomOffset: -1,
                    accessToken: 'your.mapbox.access.token'
                }).addTo(mymap);

                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('#s-coordinate').text('Latitude : ' + lat + " - Longitude : " + long)
                modal.find('.modal-title').text('Permintaan Jual Sawit')
            })

            $('#datatables').DataTable({
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        var select = $(
                            '<select class="form-control"><option value=""></option></select>'
                        )
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        column.data().unique().sort().each(function (d, j) {
                            select.append('<option value="' + d + '">' + d +
                                '</option>')
                        });
                    });
                }
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


            $("#selectuser").select2({
                width: '100%',
                maximumSelectionLength: 1,
                placeholder: {
                    id: 'null', // the value of the option
                    text: 'Ketik Nama User Untuk Mencari'
                }
            });

            $('form').ajaxForm(function () {
                alert("Uploaded SuccessFully");
            });

        });

    </script>
@endsection

@section('main')



    <div class="container">
        <div class="panel-header">
            <div class="page-inner border-bottom pb-0 mb-3">
                <div class="d-flex align-items-left flex-column">
                    <h4 class="card-title">Request Penjualan Masuk</h4>
                    <div class="nav-scroller d-flex">
                        <div class="nav nav-line nav-color-info d-flex align-items-center justify-contents-center">
                            <a class="nav-link active" href="#">Manage Pengguna</a>
                        </div>
                        <div class="d-flex d-md-inline ml-md-auto py-2 py-md-0">

                            <a href="#" class="btn btn-info btn-border btn-round" data-toggle="modal"
                               data-target="#addUser"> <span class="btn-label"> <i
                                        class="fa fa-plus"></i></span> Tambah Permintaan Jual
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-inner">
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-chart-pie text-warning"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Total Request</p>
                                        <h4 class="card-title">99</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-coins text-success"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Request Selesai</p>
                                        <h4 class="card-title">99</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-error text-danger"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Order Dibatalkan</p>
                                        <h4 class="card-title">99</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-twitter text-primary"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Customer</p>
                                        <h4 class="card-title">99</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
        @include('layouts.error')
        </div>


        <div class=" col-md-12 card border-0 shadow rounded">
            <div class="card-body">
                <h4 class="card-title">Daftar Request Jual Saya</h4>
                <table id="datatables" class="table table-responsive">
                    <thead class="thead-inverse">
                    <tr>
                        <th>No</th>
                        <th>Estimasi Berat</th>
                        <th>Status</th>
                        <th>Alamat Lengkap</th>
                        <th>Kontak</th>
                        <th>Pinpoin</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($sellRequest as $item)
                        @php
                            $statusDB = $item->status;
                            $status="";
                        @endphp

                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->est_weight}}Kg</td>
                            <td>
                                @if($statusDB ==0)
                                    <span class="badge badge-warning">Menunggu Diproses</span>
                                @endif
                                @if($statusDB ==1)
                                    <span class="badge badge-primary">{{$status}}</span>
                                @endif
                                @if($statusDB ==2)
                                    <span class="badge badge-primary">{{$status}}</span>
                                @endif
                                @if($statusDB ==2)
                                    <span class="badge badge-primary">{{$status}}</span>
                                @endif
                                @if($statusDB ==5)
                                    <span class="badge badge-warning">{{Dibatalkan}}</span>
                                @endif
                            </td>
                            <td>{{$item->address}}</td>
                            <td>{{$item->contact}}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal" data-lat="{{$item->lat}}"
                                        data-long="{{$item->long}}" data-whatever="{{$item->long}}">Lihat Pin Poin
                                </button>
                            </td>

                        </tr>
                    @empty
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Anda Belum Memiliki Permintaan Jual</strong>
                        </div>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-xl" id="exampleModal"
         tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="s-coordinate">Latitude : </p>
                    <div id="mapid" style="width: 100%; height: 400px;"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        //message with toastr
        @if(session()-> has('success'))
        toastr.success('{{ session('success') }}', 'BERHASIL!');
        @elseif(session()-> has('error'))
        toastr.error('{{ session('error') }}', 'GAGAL!');
        @endif
    </script>

@endsection
