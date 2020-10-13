@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center pb-4">
        <img src="{{ $image->url() }}" alt="{{ $image->title }}" class="w-100">
    </div>
    <div class="row justify-content-center pb-4">
        <div class="col-6">
    <form method="POST" action="/images/{{ $image->id }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" placeholder="Title" name="title" value="{{ $image->title }}" required>
            <small id="titleHelp" class="form-text text-muted">Up to 60 characters</small>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control" id="category_id" placeholder="Category" name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if($category->id === $image->category->id) selected @endif>{{ $category->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" placeholder="Description" name="description" required>{{ $image->description }}</textarea>
            <small id="descriptionHelp" class="form-text text-muted">Up to 255 characters</small>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div></div>
</div>
@endsection
