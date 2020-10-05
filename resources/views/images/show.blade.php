@extends('layouts.app')

@section('title') {{ $image->getTitle() }} - Show @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center pb-4">
        <img src="{{ $image->url() }}" alt="{{ $image->getTitle() }}" class="w-100">
    </div>
    <div class="col">
        <h1>Title: {{ $image->getTitle() }}</h1>
        <small class="text-muted">Category: {{ $image->getCategory() }}</small>
        <p>Description: {{ $image->getDescription() }}</p>
    </div>
    <div class="row">
        <a href="/images/{{ $image->getId() }}/edit" class="btn btn-primary m-1">Edit</a>
        <form method="POST" action="/images/{{ $image->getId() }}">
            @method('delete')
            @csrf
            <button class="btn btn-danger m-1">Delete</button>
        </form>
    </div>
</div>
    
</div>
@endsection
