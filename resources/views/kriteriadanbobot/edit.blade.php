@extends('layouts.index')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Kriteria</h1>
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
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Ups!</strong> Ada beberapa masalah dengan masukan Anda.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <form action="{{url('kriteriabobot/'.$kriteriadanbobot->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="kode_kriteria">Kode</label>
                                    <div class="input-group">
                                        <input id="kode_kriteria" type="text" class="form-control" placeholder="Contoh: C1" name="kode_kriteria" value="{{ $kriteriadanbobot->kode_kriteria }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kriteria">Tipe</label>
                                    <select class="form-control" id="jenis_kriteria" name="jenis_kriteria">
                                        <option value="benefit" {{ $kriteriadanbobot->jenis_kriteria == "benefit" ? 'selected' : '' }}>Benefit</option>
                                        <option value="cost" {{ $kriteriadanbobot->jenis_kriteria == "cost" ? 'selected' : '' }}>Cost</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="bobot">Bobot</label>
                                    <div class="input-group">
                                        <input id="bobot" type="text" class="form-control" placeholder="Contoh: 0.15" name="bobot" value="{{ $kriteriadanbobot->bobot }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kriteria">Deskripsi</label>
                                    <div class="input-group">
                                        <input id="kriteria" type="text" class="form-control" placeholder="Contoh: Absensi" name="kriteria" value="{{ $kriteriadanbobot->kriteria }}" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
