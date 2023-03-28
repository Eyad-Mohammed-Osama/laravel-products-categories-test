@extends('admin.layout.template')

@section('content')
    <table class="table table-striped">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Name</th>
                <th>Number of children</th>
                <th>Number of parents</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $loop->index }}</td>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->children()->count() }}</td>
                    <td>{{ $category->parents()->count() }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="table-light">
            <tr>
                <td>
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">Add new category</a>
                </td>
                <td colspan="4"></td>
            </tr>
        </tfoot>
    </table>

    <div class="container d-flex align-items-center justify-content-center">
        {{ $categories->onEachSide(5)->links() }}
    </div>
@endsection
