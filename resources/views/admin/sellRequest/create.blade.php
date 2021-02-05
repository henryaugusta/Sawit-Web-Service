@extends('layouts.template')

@section('header')
    <!--Leaflet JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
@endsection

@section('script')
    <script>
        $(document).ready(function () {

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

            $.calculatePrice = function () {
                let estWeight = $.trim($("#priceSim").val());
                let calWeight = estWeight * {{$latestMargin}};
                let sellWeight = estWeight - calWeight;

                let sellPrice = {{$latestPrice}} *
                sellWeight;
                sellPrice = new Intl.NumberFormat('de-DE', {style: 'currency', currency: 'IDR'}).format(sellPrice);

                $("#nettWeight").text(sellWeight);
                $("#sellPrice").text(sellPrice);

                console.log(sellWeight);
            };

            $("#priceSim").keyup(function () {
                $.calculatePrice();
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
    <form action="{{url('admin/sell-request/store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="panel-header">
            <div class="page-inner border-bottom pb-0 mb-3">
                <div class="d-flex align-items-left flex-column">
                    <h4 class="card-title">Request Penjualan Masuk</h4>
                    <div class="nav-scroller d-flex">
                        <div class="nav nav-line nav-color-info d-flex align-items-center justify-contents-center">
                            <a class="nav-link active" href="#">Request Penjualan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-inner">
            @if ($errors->any())

                <div class="alert alert-primary alert-dismissible fade show mx-2 my-2" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    @foreach ($errors->all() as $error)
                        <script>
                            toastr.error('{{ session('success') }}', '{{ session('error ') }}');
                        </script>
                        <li>{{ $error }}</li>
                    @endforeach
                </div>

            @endif
            <div>
                @if(session() -> has('success'))
                    <div class="alert alert-primary alert-dismissible fade show mx-2 my-2" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <strong>{{Session::get( 'success' )}}</strong>
                    </div>

                @elseif(session() -> has('error'))

                    <div class="alert alert-primary alert-dismissible fade show mx-2 my-2" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <strong>{{Session::get( 'error' )}}</strong>
                    </div>

                @endif
            </div>

            <div class=" container row">
                <div class="col-sm-6 col-md-6">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="flaticon-graph"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ml-3 ml-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Harga <br> Saat Ini</p>
                                        <h4 class="card-title">{{$latestPrice}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="flaticon-graph"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ml-3 ml-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Margin <br> Saat Ini</p>
                                        <h4 class="card-title">{{$latestMargin*100}}%</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Grafik Harga</div>
                                <div class="card-tools">
                                    <a href="#" class="btn btn-info btn-border btn-round btn-sm mr-2">
												<span class="btn-label">
													<i class="fa fa-pencil"></i>
												</span>
                                        Export
                                    </a>
                                    <a href="#" class="btn btn-info btn-border btn-round btn-sm">
												<span class="btn-label">
													<i class="fa fa-print"></i>
												</span>
                                        Print
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="min-height: 375px">
                                <canvas id="statisticsChart"></canvas>
                            </div>
                            <div id="myChartLegend"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow rounded">
                <div class="card-body">
                    <h4 class="card-title">Info Pelanggan</h4>
                    @csrf
                    <input type="hidden" name="redirectTo" value="admin/sell-request/manage">
                    <div class="form-group">
                        <label for="">Pembeli</label>
                        <div class="select2-input">
                            <select id="selectuser" name="user" class="form-control" multiple="multiple">
                                @forelse ($user as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Kontak Darurat</label>
                        <input type="text" placeholder="Kontak Tambahan" required
                               class="form-control" name="additional_contact" id="" aria-describedby="helpId">
                        <small id="helpId" class="form-text text-muted">Kontak Alternatif Pelanggan</small>
                    </div>

                    <div class="fallback">
                        <label for="">Pilih Gambar Yang Produk</label>
                        <input id="upload_file" name="upload_file[]" type="file"
                               onchange="previewImage();"
                               multiple/>
                    </div>


                    <div id="image_preview" class="row mt-4">
                    </div>


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
                </div>
            </div>

            <div class="card border-2 shadow rounded col-md-12 col-12">
                <div class="card-body">
                    <h4 class="card-title">Masukkan Perkiraan Berat Sawit</h4>
                    <label for="">Estimasi Berat Total Sawit : </label>
                    <input type="text" placeholder="Masukkan Berat Sawit"
                           class="form-control" name="est_weight" required id="priceSim"
                           aria-describedby="helpId">
                    <small id="helpId" class="form-text text-muted">Masukkan Perkiraan Berat
                        Sawit</small>
                    <ul>
                        <li><strong>Harga Aktif : Rp. {{$latestPrice}} </strong></li>
                        <li><strong>Margin : {{$latestMargin*100}} %</strong></li>
                        <li><strong>Berat Bersih : </strong> <span id="nettWeight"> </span></li>
                        <li><strong>Harga Jual : <span id="sellPrice"> </span></strong></li>
                    </ul>
                </div>

            </div>

            <div class="card border-2 shadow rounded col-md-12 col-12">
                <div class="card-header">
                    <div class="card-head-row">
                        <h4 class="card-title">Lokasi Penjemputan</h4>
                    </div>
                </div>
                <div class="card-body">
                    <button type="button" onclick="locateMe()" class="btn btn-primary mb-3">Arahkan Ke Lokasi
                        Anda
                    </button>
                    <p>Letakan Pin Poin pada lokasi penjemputan anda</p>
                    <div id="mapid" style="width: 100%; height: 400px;"></div>
                    <script>
                        var mymap = L.map('mapid').setView([-7.046379, 107.555881], 13);
                        mymap.locate({setView: true, maxZoom: 26});
                        var popup = L.popup();
                        let myMarker = L.marker([-7.046379, 107.555881]).addTo(mymap)
                            .bindPopup("Silakan Pindahkan Pin Ini Ke Lokasi Anda.").openPopup();
                        myMarker.addTo(mymap);

                        var sendLat = 0;
                        var sendLong = 0;

                        let locateMe = () => {
                            mymap.locate({setView: true, maxZoom: 25});
                            var lat = mymap.latitude;
                            var lng = mymap.longitude;
                            var newLatLng = new L.LatLng(lat, lng);
                            myMarker.setLatLng(newLatLng);
                        }


                        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiaGVucnlhdWd1c3RhIiwiYSI6ImNra2pjaDAxcDAyYngydnF0dnppZzByZzgifQ.UKzJXFzQPNIzrri9UrALxQ', {
                            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                            maxZoom: 18,
                            id: 'mapbox/streets-v11',
                            tileSize: 512,
                            zoomOffset: -1,
                            accessToken: 'your.mapbox.access.token'
                        }).addTo(mymap);

                        function onMapClick(e) {
                            let lat = e.latlng.lat;
                            let lon = e.latlng.lng;
                            if (myMarker !== undefined) {
                                mymap.removeLayer(myMarker);
                            }

                            document.getElementById("sendLat").value = (lat.toFixed(5));
                            document.getElementById("sendLong").value = (lon.toFixed(5));
                            //Add a marker to show where you clicked.
                            myMarker = L.marker([lat, lon]).addTo(mymap)
                                .bindPopup("Driver Kami Akan Menjemput Ke Lokasi Ini.").openPopup();
                        }

                        mymap.on('click', onMapClick);
                    </script>

                    <div class="row">
                        <div class="form-group col-md-6 col-12">
                            <label for="">Latitude</label>
                            <input type="text" required onkeydown="return false;"
                                   style="caret-color: transparent !important;"
                                   class="form-control" name="longitude" id="sendLat" aria-describedby="helpId"
                                   placeholder="Silakan Pin Poin di Map">
                        </div>

                        <div class="form-group col-md-6 col-12">
                            <label for="">Latitude</label>
                            <input type="text" required onkeydown="return false;"
                                   style="caret-color: transparent !important;"
                                   class="form-control" name="latitude" id="sendLong" aria-describedby="helpId"
                                   placeholder="Silakan Pin Poin di Map">
                        </div>

                        <div class="form-group col-md-12 col-12">
                            <label for="">Alamat Lengkap : </label>
                            <textarea class="form-control" required
                                      placeholder="Masukkan Alamat Lengkap, Petunjuk , dll terkait lokasi penjemputan"
                                      name="full_address" id="" cols="30" rows="4"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Request</button>
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

        <!-- Chart JS -->
        <script src="{{ asset('main_asset/examples') }}/assets/js/plugin/chart.js/chart.min.js"></script>
        <script>

            "use strict";
            var ctx = document.getElementById('statisticsChart').getContext('2d');

            var statisticsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [
                        @forelse($data as $item)
                            "{{date('d-m-Y', strtotime($item->created_at))}}",
                        @empty
                        @endforelse
                    ],
                    datasets: [{
                        label: "Harga Sawit",
                        borderColor: '#f3545d',
                        pointBackgroundColor: 'rgba(243, 84, 93, 0.6)',
                        pointRadius: 0,
                        backgroundColor: 'rgba(243, 84, 93, 0.4)',
                        legendColor: '#f3545d',
                        fill: false,
                        borderWidth: 2,
                        data: [
                            @forelse($data as $item)
                                "{{$item->price}}",
                            @empty
                            @endforelse
                        ]
                    }, {
                        label: "Margin",
                        borderColor: '#fdaf4b',
                        pointBackgroundColor: 'rgba(253, 175, 75, 0.6)',
                        pointRadius: 0,
                        backgroundColor: 'rgba(253, 175, 75, 0.4)',
                        legendColor: '#fdaf4b',
                        fill: true,
                        borderWidth: 2,
                        data: [
                            @forelse($data as $item)
                                "{{$item->margin*100}}",
                            @empty
                            @endforelse
                        ]
                    },]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    tooltips: {
                        bodySpacing: 4,
                        mode: "nearest",
                        intersect: 0,
                        position: "nearest",
                        xPadding: 10,
                        yPadding: 10,
                        caretPadding: 10
                    },
                    layout: {
                        padding: {left: 5, right: 5, top: 15, bottom: 15}
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                fontStyle: "500",
                                beginAtZero: false,
                                maxTicksLimit: 5,
                                padding: 10
                            },
                            gridLines: {
                                drawTicks: false,
                                display: false
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                zeroLineColor: "transparent"
                            },
                            ticks: {
                                padding: 10,
                                fontStyle: "500"
                            }
                        }]
                    },
                    legendCallback: function (chart) {
                        var text = [];
                        text.push('<ul class="' + chart.id + '-legend html-legend">');
                        for (var i = 0; i < chart.data.datasets.length; i++) {
                            text.push('<li><span style="background-color:' + chart.data.datasets[i].legendColor + '"></span>');
                            if (chart.data.datasets[i].label) {
                                text.push(chart.data.datasets[i].label);
                            }
                            text.push('</li>');
                        }
                        text.push('</ul>');
                        return text.join('');
                    }
                }
            });
        </script>
    </form>
@endsection
