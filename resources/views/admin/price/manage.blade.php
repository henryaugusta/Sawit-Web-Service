@extends('layouts.template')

@section('head')
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
@endsection

@section('script')
    <!-- Toastr -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#datatables').DataTable({});

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


        });

    </script>
@endsection

@section('main')

    <div class="container">
        <div class="panel-header">
            <div class="page-inner border-bottom pb-0 mb-3">
                <div class="d-flex align-items-left flex-column">
                    <h4 class="card-title">Ubah Harga Penjualan Sawit</h4>
                    <div class="nav-scroller d-flex">
                        <div class="nav nav-line nav-color-info d-flex align-items-center justify-contents-center">
                            <a class="nav-link active" href="#">Manage Harga Sawit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.error')

        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3">
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
                                        <p class="card-category">Harga <br> Aktif</p>
                                        <h4 class="card-title">{{$latestPrice}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
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
                                        <p class="card-category">Margin <br> Aktif</p>
                                        <h4 class="card-title">{{$latestMargin*100}}%</h4>
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
                                    <div class="icon-big text-center bubble-shadow-small">
                                        <i class="flaticon-share-1"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ml-3 ml-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Simulasi Jika <br> Pelanggan Menjual 1500 Kg</p>
                                        <h4 class="card-title">{{$latestSimulation}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-2 shadow rounded col-md-12 col-12">
                <div class="card-body">
                    <h4 class="card-title">Simulasi</h4>
                    <label for="">Estimasi Berat Total Sawit : </label>
                    <input type="text" placeholder="Masukkan Berat Sawit"
                           class="form-control" name="" id="priceSim" aria-describedby="helpId">
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


            <div class="card border-0 shadow rounded">
                <div class="card-body">
                    <h4 class="card-title">Manage Harga</h4>
                    <a href="#" class="btn btn-info btn-border btn-round m-3" data-toggle="modal"
                       data-target="#addUser"> <span class="btn-label"> <i
                                class="fa fa-plus"></i></span> Input Harga Baru
                    </a>
                    <div class="table-responsive">

                        <table id="datatables" class="table ">
                            <thead class="thead-inverse">
                            <tr>
                                <th>No</th>
                                <th>Harga CPO</th>
                                <th>Margin</th>
                                <th>Dibuat Pada Tanggal</th>
                                <th>Edit</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($data as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>Rp. {{$item->price}} ,-</td>
                                    <td>{{$item->margin*100}}%</td>
                                    <td>{{$item->created_at}}</td>
                                    <td>
                                        <div class="form-button-action">
                                            <form action="{{url('price/delete')}}" method="post"
                                                  onsubmit="return confirm('Anda Yakin Ingin Menghapus Harga Yang Dipilih ?');">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="id" value="{{$item->id}}">
                                                <input type="hidden" name="redirectTo" value="admin/price/manage">
                                                <button
                                                    type="submit" data-toggle="tooltip" title=""
                                                    class="btn btn-link btn-danger btn-lg"
                                                    data-original-title="Hapus Harga">
                                                    <i class="fa  fa-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong>Belum Ada Data Harga</strong>
                                </div>
                            @endforelse
                            </tbody>
                        </table>
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


        <!-- Modal Add Request Sell-->
        <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Harga Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form method="post" action="{{url('admin/price/store')}}">
                            @method('POST')
                            @csrf
                            <input type="hidden" name="redirectTo" value="/admin/price/manage">
                            <div class="form-group">
                                <label for="">Harga Sawit</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                       name="price" id="" aria-describedby="helpId" placeholder="Harga Sawit">
                                <small id="helpId" class="form-text text-muted">Harga Jual Sawit Mentah per
                                    Kg</small>
                            </div>

                            <div class="form-group">
                                <label for="">Margin Penjualan</label>
                                <input type="number" step=".01"
                                       class="form-control @error('margin') is-invalid @enderror"
                                       name="margin" id="" aria-describedby="helpId" placeholder="Margin Jual">
                                <small id="helpId" class="form-text text-muted">Margin Penjualan Dalam
                                    Persen</small>
                            </div>

                            <button type="submit" class="btn btn-primary">Tambahkan Harga</button>
                        </form>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>

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
    </div>
@endsection
