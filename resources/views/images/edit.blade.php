@extends('layouts.app')

@section('title') {{ $image->getTitle() }} - Edit @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center pb-4">
        <img src="{{ $image->url() }}" alt="{{ $image->getTitle() }}" class="w-100">
    </div>
    <div class="row justify-content-center pb-4">
        <div class="col-6">
    <form method="POST" action="/images/{{ $image->getId() }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" placeholder="Title" name="title" value="{{ $image->getTitle() }}" required>
            <small id="titleHelp" class="form-text text-muted">Up to 60 characters</small>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" class="form-control" id="category" placeholder="Category" name="category" value="{{ $image->getCategory() }}" required>
            <small id="categoryHelp" class="form-text text-muted">Up to 25 characters</small>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" placeholder="Description" name="description" required>{{ $image->getDescription() }}</textarea>
            <small id="descriptionHelp" class="form-text text-muted">Up to 280 characters</small>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div></div>
</div>
@endsection