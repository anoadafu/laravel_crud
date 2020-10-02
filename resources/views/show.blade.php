@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center pb-4">
        <img src="{{ $image->url() }}" alt="{{ $image->title }}" class="w-100">
    </div>
    <div class="col">
        <h1>Title: {{ $image->title }}</h1>
        <small class="text-muted">Category: {{ $image->category }}</small>
        <p>Description: {{ $image->description }}</p>
    </div>
    <div class="row">
        <a href="/images/{{ $image->id }}/edit" class="btn btn-primary m-1">Edit</a>
        <form method="POST" action="/images/{{ $image->id }}">
            @method('delete')
            @csrf
            <button class="btn btn-danger m-1">Delete</button>
        </form>
    </div>
</div>
    
</div>
@endsection
