@extends('layouts.index')

@section('content')
    <section class="content">

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Kriteria & Bobot</h1>
                        </div>
                        <div class="col-sm-6"></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <button class="btn btn-sm btn-success my-2" onclick="tambahData()" data-toggle="modal"
                        data-target="#modal_kriteria">Tambah Data</button>
                    <table class="table table-bordered table-striped" id="data_kriteria">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Tipe</th>
                                <th>Bobot</th>
                                <th>Deskripsi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

    </section>

    <!-- Bagian Form pada file index -->
    <div class="modal fade" id="modal_kriteria" style="display: none;" aria-hidden="true">
        <form method="post" action="{{ url('kriteriadanbobot') }}" role="form" class="form-horizontal" id="form_kriteria">
            @csrf
            <div class="modal-dialog modal-">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Kriteria dan Bobot</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row form-message"></div>
                        <div class="form-group required row mb-2">
                            <label class="col-sm-2 control-label col-form-label">Kode</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control form-control-sm" id="kode_kriteria" name="kode_kriteria"
                                    value="" />
                            </div>
                        </div>
                        <div class="form-group required row mb-2">
                            <label class="col-sm-2 control-label col-form-label">Tipe</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control form-control-sm" id="jenis_kriteria" name="jenis_kriteria"
                                    value="" />
                            </div>
                        </div>
                        <div class="form-group required row mb-2">
                            <label class="col-sm-2 control-label col-form-label">Bobot</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control form-control-sm" id="bobot" name="bobot"
                                    value="" />
                            </div>
                        </div>
                        <div class="form-group required row mb-2">
                            <label class="col-sm-2 control-label col-form-label">Deskripsi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control form-control-sm" id="kriteria" name="kriteria"
                                    value="" />
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Hapus Kriteria dan Bobot</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Yakin Ingin Hapus Data Ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function tambahData() {
            $('#modal_kriteria').modal('show');
            $('#modal_kriteria .modal-title').html('Tambah Data Kriteria dan Bobot');
            $('#form_kriteria').attr('action', '{{ url('kriteriadanbobot') }}'); // Ganti URL sesuai dengan operasi tambah
            $('#form_kriteria').find('input[name="_method"]').remove(); // Hapus _method jika ada
            $('#modal_kriteria #kode_kriteria').val('');
            $('#modal_kriteria #jenis_kriteria').val('');
            $('#modal_kriteria #bobot').val('');
            $('#modal_kriteria #kriteria').val('');
        }

        function updateData(th) {
            $('#modal_kriteria').modal('show');
            $('#modal_kriteria .modal-title').html('Edit Data Kriteria dan Bobot');
            $('#form_kriteria').attr('action', '{{ url('kriteriadanbobot') }}' + '/' + $(th).data(
                'id')); // Ganti URL sesuai dengan operasi edit
            $('#form_kriteria').append(
                '<input type="hidden" name="_method" value="PUT">'); // Tambahkan _method sebagai PUT
            $('#modal_kriteria #kode_kriteria').val($(th).data('kode_kriteria'));
            $('#modal_kriteria #jenis_kriteria').val($(th).data('jenis_kriteria'));
            $('#modal_kriteria #bobot').val($(th).data('bobot'));
            $('#modal_kriteria #kriteria').val($(th).data('kriteria'));
        }

        function deleteData(element) {
            $('#confirmModal').modal('show');

            $('#confirmDelete').off().on('click', function() {
                $.ajax({
                    url: '{{ url('kriteriadanbobot/delete') }}' + '/' + element,
                    method: 'GET',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        alert(data.message);
                        location.reload();
                    },
                    error: function() {
                        alert('Error occurred while deleting data.');
                    }
                });
            });
        }

        $(document).ready(function() {
            var dataAlternatif = $('#data_kriteria').DataTable({
                processing: true,
                serverside: true,
                stateSave: true,
                ajax: {
                    'url': '{{ url('kriteriadanbobot/data') }}',
                    'dataType': 'json',
                    'type': 'POST',
                },
                columns: [{
                        data: 'nomor',
                        name: 'nomor',
                        sortable: false,
                        searchable: false
                    },
                    {
                        data: 'kode_kriteria',
                        name: 'kode_kriteria',
                        sortable: false,
                        searchable: true
                    },
                    {
                        data: 'jenis_kriteria',
                        name: 'jenis_kriteria',
                        sortable: false,
                        searchable: true
                    },
                    {
                        data: 'bobot',
                        name: 'bobot',
                        sortable: false,
                        searchable: true
                    },
                    {
                        data: 'kriteria',
                        name: 'kriteria',
                        sortable: false,
                        searchable: true
                    }
                    {
                        data: 'id',
                        name: 'id',
                        sortable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            var btn = `<button data-url="{{ url('/kriteriadanbobot')}}/` + data +
                                `" class="btn btn-xs btn-warning mr-2 ml-2" onclick="updateData(this)" data-id="` +
                                row.id + `" data-kode_kriteria="` + row.kode_kriteria + `" data-jenis_kriteria="` + row.jenis_kriteria + `" data-bobot="` + row.bobot + `" data-kriteria="` + row.kriteria
                                `"><i class="fa fa-edit"></i>Edit</button>` +
                                `<button class="btn btn-xs btn-danger" onclick="deleteData(` +
                                data + `)"><i class="fa fa-trash mr-2 ml-2"></i>Hapus</button>`;
                            return btn;
                        }
                    },
                ]
            });

            $('#form_kriteria').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(data) {
                        $('.form-message').html('');

                        // Continue with handling JSON response
                        if (data.status) {
                            $('.form-message').html(
                                '<span class="alert alert-success" style="width: 100%">' +
                                data.message + '</span>');
                            $('#form_kriteria')[0].reset();
                            dataAlternatif.ajax.reload();
                            $('#form_kriteria').attr('action', '{{ url('alternatif') }}');
                            $('#form_kriteria').find('input[name="_method"]').remove();
                        } else {
                            $('.form-message').html(
                                '<span class="alert alert-danger" style="width: 100%">' +
                                data.message + '</span>');
                            alert('error');
                        }

                        // Check if the modal_close property is not set
                        if (!data.modal_close) {
                            $('.form-message').html('');
                            $('#modal_kriteria').modal('hide');
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error('AJAX Error: ' + textStatus, errorThrown);
                        // Handle error appropriately
                    }
                });
            });
        });
    </script>
@endpush
