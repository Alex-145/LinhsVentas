
<div class="container">
    <h1>Edit Brand</h1>
    <form action="{{ route('brands.update', $brand->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Brand Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $brand->name }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Brand</button>
    </form>
</div>
