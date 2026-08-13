@extends('app')
@section('content')
    <form action="{{ route('store-peserta') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="" class="form-label">Nama</label>
            <input type="text" class="form-control" name="nama">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Umur</label>
            <input type="number" class="form-control" name="umur">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Email</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Alamat</label>
            <input type="text" class="form-control" name="address">
        </div>
        <div class="mb-3">
        <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
@endsection
