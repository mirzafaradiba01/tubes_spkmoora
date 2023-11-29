@extends('layouts.index')
@section('content')
<section class="content">

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> Data Penilaian</h1>
                    </div>
                    <div class="col-sm-6"></div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <button class="btn btn-sm btn-success my-2" onclick="tambahData()" data-toggle="modal"
                    data-target="#data_penilaian">Tambah Data</button>
                <table class="table table-bordered table-striped" id="data_penilaian">
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
<div class="modal fade" id="modal_penilaian" style="display: none;" aria-hidden="true">
    <form method="post" action="{{ url('datapenilaian') }}" role="form" class="form-horizontal" id="form_penilaian">
        @csrf
        <div class="modal-dialog modal-">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Penilaian</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
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

@endsection
@push('js')
    <script>
        function updateData(th){
            $('#modal_penilaian').modal('show');
            $('#modal_penilaian .modal-title').html('Edit Data Penilaian');
            $('form_penilaian').attr('action', '{{ url('datapenilaian') }}' + '/' + $(th).data(
               'id' 
            ));
            $('#form_penilaian').append(
                '<input type="hidden" name="_method" value="PUT">');
            $('#modal_penilaian #nama').val($(th).data('nama'));
        }



        $(document).ready(function(){
            var dataPenilaian = $('#data_penilaian').DataTable({
                processing: true,
                serverside: true,
                stateSave: true,
                ajax: {
                    'url': '{{ url('datapenilaian/data') }}',
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
                            var btn = `<button data-url="{{ url('/datapenilaian')}}/` + data +
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
        $('#form_penilaian').submit(function(e) {
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
                            $('#form_penilaian')[0].reset();
                            dataPenilaian.ajax.reload();
                            $('#form_penilaian').attr('action', '{{ url('datapenilaian') }}');
                            $('#form_penilaian').find('input[name="_method"]').remove();
                        } else {
                            $('.form-message').html(
                                '<span class="alert alert-danger" style="width: 100%">' +
                                data.message + '</span>');
                            alert('error');
                        }

                        // Check if the modal_close property is not set
                        if (!data.modal_close) {
                            $('.form-message').html('');
                            $('#modal_penilaian').modal('hide');
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