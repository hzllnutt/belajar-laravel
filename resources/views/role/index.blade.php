@extends('app')
@section('content')
    <div class="table-responsive"></div>
    <div align="right" class="mb-2">
        <a href="{{route('role.create')}}" class="btn btn-primary btn-sm">Create</a>
    </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $index => $value)
                        <tr>
                            <td>{{ $index += 1 }}</td>
                            <td>{{ $value->name }}</td>
                            <td>
                        <a href="{{ route('role.edit', $value->id) }}" class="btn btn-success btn-sm">Edit</a>
                        <form action="{{ route('role.destroy', $value->id) }}" method="post" class="d-inline">
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