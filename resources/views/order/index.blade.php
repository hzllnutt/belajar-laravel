@extends('app')
@section('content')
    <div class="table-responsive"></div>
    <div align="right" class="mb-2">
        <a href="{{route('product.create')}}" class="btn btn-primary btn-sm">Create</a>
    </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Category Name</th>
                    <th>Price</th>
                    <th>Photo</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $value)
                        <tr>
                            <td>{{ $index += 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                <img src="{{ asset('storage/' . $value->photo) }}" alt="" width="40" height="40" style="object-fit: cover">
                               
                               
                               <div class="fw-semibold">
                                {{ $value->name}}
                                 </div>
                               </div>
                            </td>
                            <td>{{ $value->category->name }}</td>
                            <td>Rp. {{ number_format ($value->price)}}</td>
                            <td>{{ $value->photo}}</td>
                            <td>{{ $value->description}}</td>
                            <td>
                        <a href="{{ route('product.edit', $value->id) }}" class="btn btn-success btn-sm">Edit</a>
                        <form action="{{ route('product.destroy', $value->id) }}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit"
                                onclick="return confirm('No no ya?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection