@extends('layouts.app')
@section('content')
        <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" value ="{{ $category->name }}" name="name" class="form-control"
                            id="name" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="dec" class="form-label">Description</label>
                        <div class="form-floating">
                            <textarea name ="dec"class="form-control" id="dec">{{ $category->dec }}</textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
@endsection


