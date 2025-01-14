
<div class="container">
    <h1>Brands</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($brands as $brand)
            <tr>
                <td>{{ $brand->id }}</td>
                <td>{{ $brand->name }}</td>
                <td>
                    <a href="{{ route('brands.show', $brand->id) }}" class="btn btn-info">View</a>
                    <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mb-3">
    <a href="{{ route('brands.create') }}" class="btn btn-success">New Brand</a>
</div>
