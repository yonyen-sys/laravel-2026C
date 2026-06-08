@extends('layouts.app')

@section('title')
    <title>Create Product</title>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>

            <div class="col-md-6">
                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-control" id="name"
                            value="{{ $product->name }}">
                    </div>

                    <!-- Price -->
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" name="price" class="form-control" id="price" step="0.01"
                            value="{{ $product->price }}">
                    </div>

                    <!-- Quantity -->
                    <div class="mb-3">
                        <label for="qty" class="form-label">Quantity</label>
                        <input type="number" name="qty" class="form-control" id="qty"
                            value="{{ $product->qty }}">
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" id="category_id" class="form-select">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                </form>
            </div>

            <div class="col-md-3"></div>
        </div>
    </div>
@endsection
