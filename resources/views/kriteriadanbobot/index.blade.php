@extends('layouts.index')
@section('content')
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
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ $message }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            <a href="{{ route('kriteriabobot.create') }}" class='btn btn-primary'>
                                <span class='fa fa-plus'></span> Tambah Kriteria
                            </a>
                            <br>
                            <table id="mytable" class="display nowrap table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Kriteria</th>
                                        <th>Tipe</th>
                                        <th>Bobot</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kriteriadanbobot as $c)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $c->kode_kriteria }}</td>
                                        <td>{{ $c->jenis_kriteria }}</td>
                                        <td>{{ $c->bobot }}</td>
                                        <td>{{ $c->kriteria }}</td>
                                        <td>
                                            <span data-toggle="tooltip" data-placement="bottom" title="Edit Data">
                                                <a href="{{ url('kriteriabobot/'.$c->id.'/edit') }}" class="btn btn-primary">
                                                    <span class="fa fa-edit"></span>
                                                </a>                                                
                                            </span>
                                            <span data-toggle="tooltip" data-placement="bottom" title="Hapus Data">
                                                <form action="{{ url('kriteriabobot/'.$c->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <span class="fa fa-trash-alt"></span>
                                                    </button>
                                                </form>
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
        $('#mytable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@endsection