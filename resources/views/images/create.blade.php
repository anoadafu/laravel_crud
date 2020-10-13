@extends('layouts.app')

@section('content')
<div class="container">
    <div class="bd-content">
    <form method="POST" action="/images" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image" required>
        </div>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" placeholder="Title" name="title" required>
            <small id="titleHelp" class="form-text text-muted">Up to 60 characters</small>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control" id="category_id" placeholder="Category" name="category_id" required>
                <option selected disabled>Choose category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" placeholder="Description" name="description" required></textarea>
            <small id="descriptionHelp" class="form-text text-muted">Up to 255 characters</small>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</div>
@endsection
