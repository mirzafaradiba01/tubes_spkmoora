@extends('layouts.index')

@section('content')
    <section class="content">

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Alternatif & Skor</h1>
                        </div>
                        <div class="col-sm-6"></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <button class="btn btn-sm btn-success my-2" onclick="tambahData()" data-toggle="modal"
                        data-target="#modal_alternatif">Tambah Data</button>
                    <table class="table table-bordered table-striped" id="data_alternatif">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
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
    <div class="modal fade" id="modal_alternatif" style="display: none;" aria-hidden="true">
        <form method="post" action="{{ url('alternatif') }}" role="form" class="form-horizontal" id="form_alternatif">
            @csrf
            <div class="modal-dialog modal-">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Alternatif</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row form-message"></div>
                        <div class="form-group required row mb-2">
                            <!-- Ganti ID input menjadi 'nama' -->
                            <label class="col-sm-2 control-label col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <!-- Ganti ID input menjadi 'nama' -->
                                <input type="text" class="form-control form-control-sm" id="nama" name="nama"
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
                    <h5 class="modal-title" id="confirmModalLabel">Hapus Alternatif</h5>
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
            $('#modal_alternatif').modal('show');
            $('#modal_alternatif .modal-title').html('Tambah Data Alternatif');
            $('#form_alternatif').attr('action', '{{ url('alternatif') }}'); // Ganti URL sesuai dengan operasi tambah
            $('#form_alternatif').find('input[name="_method"]').remove(); // Hapus _method jika ada
            $('#modal_alternatif #nama').val(''); // Kosongkan nilai pada input sesuai dengan kebutuhan
        }

        function updateData(th) {
            $('#modal_alternatif').modal('show');
            $('#modal_alternatif .modal-title').html('Edit Data Alternatif');
            $('#form_alternatif').attr('action', '{{ url('alternatif') }}' + '/' + $(th).data(
                'id')); // Ganti URL sesuai dengan operasi edit
            $('#form_alternatif').append(
                '<input type="hidden" name="_method" value="PUT">'); // Tambahkan _method sebagai PUT
            $('#modal_alternatif #nama').val($(th).data('nama')); // Isi nilai pada input sesuai dengan kebutuhan
        }

        function deleteData(element) {
            $('#confirmModal').modal('show');

            $('#confirmDelete').off().on('click', function() {
                $.ajax({
                    url: '{{ url('alternatif/delete') }}' + '/' + element,
                    method: 'POST',
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
            var dataAlternatif = $('#data_alternatif').DataTable({
                processing: true,
                serverside: true,
                stateSave: true,
                ajax: {
                    'url': '{{ url('alternatif/data') }}',
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
                        data: 'nama',
                        name: 'nama',
                        sortable: false,
                        searchable: true
                    },
                    {
                        data: 'id',
                        name: 'id',
                        sortable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            var btn = `<button data-url="{{ url('/alternatif')}}/` + data +
                                `" class="btn btn-xs btn-warning mr-2 ml-2" onclick="updateData(this)" data-id="` +
                                row.id + `" data-nama="` + row.nama +
                                `"><i class="fa fa-edit"></i>Edit</button>` +
                                `<button class="btn btn-xs btn-danger" onclick="deleteData(` +
                                data + `)"><i class="fa fa-trash mr-2 ml-2"></i>Hapus</button>`;
                            return btn;
                        }
                    },
                ]
            });

            $('#form_alternatif').submit(function(e) {
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
                            $('#form_alternatif')[0].reset();
                            dataAlternatif.ajax.reload();
                            $('#form_alternatif').attr('action', '{{ url('alternatif') }}');
                            $('#form_alternatif').find('input[name="_method"]').remove();
                        } else {
                            $('.form-message').html(
                                '<span class="alert alert-danger" style="width: 100%">' +
                                data.message + '</span>');
                            alert('error');
                        }

                        // Check if the modal_close property is not set
                        if (!data.modal_close) {
                            $('.form-message').html('');
                            $('#modal_alternatif').modal('hide');
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
