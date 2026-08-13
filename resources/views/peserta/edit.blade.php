@extends('app')
@section('content')
    <form action="{{ route('update.peserta', $peserta->id)}}" method="post">
        @csrf
        @method('PUT')
        {{-- @dd($peserta) --}}
        <div class="mb-3">
            <label for="" class="form-label">Nama</label>
            <input type="text" class="form-control" name="nama" value="{{ $peserta->name}}">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Umur</label>
            <input type="number" class="form-control" name="umur" value="{{ $peserta->age}}">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ $peserta->email}}">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Alamat</label>
            <textarea name="address" id="" cols="30" rows="5" class="form-control">{{ $peserta->address}}</textarea>
        </div>
        <div class="mb-3">
        <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
@endsection
