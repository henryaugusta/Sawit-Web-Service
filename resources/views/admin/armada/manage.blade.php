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

                <div class="table-responsive">

                <table class="table  w-100">
                    <thead class="thead">
                        <tr>
                            <th>No</th>
                            <th>Merk</th>
                            <th>Nopol</th>
                            <th>Nomor Mesin</th>
                            <th>Kapasitas</th>
                            <th>Berat Maximum</th>
                            <th>Tanggal Input</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row"></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td scope="row"></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                </table>
            </div>




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

        $(function() {
            $('#dataTable').DataTable({
                serverSide: false,
                dom: 'lrtipB',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                ],

                "ajax": {
                    url: "{{ url('/ticket/fetchAll') }}",
                    type: "GET",
                    dataSrc: "ticket",
                    beforeSend: function() {
                        $('#loader').show();
                    },
                    complete: function() {
                        $('#loader').hide();
                    },
                },
                "columns": [{
                        data: 'id'
                    },
                    {
                        data: 'nid'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'faculty'
                    },
                    {
                        data: 'class'
                    },
                    {
                        render: function(datum, type, row) {
                            switch (row.account_type) {
                                case "1":
                                    return "Mentor"
                                    break;
                                case "2":
                                    return "Mentee"
                                    break;
                                case "3":
                                    return "Dosen"
                                    break;
                                case "Pengurus":
                                    return "Dosen"
                                    break;
                                default:
                                    return "Unknown Account Type"
                                    break;
                            }

                        }
                    },
                    {
                        render: function(datum, type, row) {
                            switch (row.status) {
                                case "0": //Dalam Antrian
                                    return "<span class='badge badge-info'>Status : Dalam Antrian</span>"
                                    break;
                                case "1": //Selesai
                                    return "<span class='badge badge-success'>Status : Selesai</span>"
                                    break;
                                case "2": //Gagal
                                    return "<span class='badge badge-danger'>Status : Gagal</span>"
                                    break;
                                case "3": //Diproses
                                    return "<span class='badge badge-warning'>Status : Diproses</span>"
                                    break;
                                default:
                                    return "Unknown Account Type"
                                    break;
                            }
                        }
                    },
                    {
                        data: 'ticket_type'
                    },
                    {
                        render: function(datum, type, row) {
                            let html =
                                "<button type='button' id='" + row.id +
                                "' class='btn btn-primary btn-xs edit_data' data-toggle='modal' data-target='#ajaxModel'>Lihat Detail </button>";
                            return html;
                        }
                    },
                ]
            });
        });

    </script>


