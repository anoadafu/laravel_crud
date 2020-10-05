@extends('layouts.app')

@section('title') {{ config('app.name', 'Laravel') }} - Search Results @endsection

@section('content')
<div class="container">

<h2 class="pb-4">You searched for title: {{ $search_query }}</h2>
<div class="row justify-content-start pb-4">
    {{-- {{$images->links()}} --}}
    {{$paginator->links('layouts/search_pagination', ['search_query' => $search_query])}}
</div>
    <div class="row justify-content-start pb-4">
        @foreach($paginator as $image)
            <div class="col-md-4 pb-4">
                <div class="card">
                    <img class="card-img-top image-height" src="{{ $image->thumb_url() }}" alt="Image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $image->getTitle() }}</h5>
                        <p class="card-text text-muted">{{ $image->getCategory() }}</p>
                        <p class="card-text">{{ Str::words($image->getDescription(), $words = 15, $end='...') }}</p>
                        <div class="row">
                            <a href="/images/{{ $image->getId() }}" class="btn btn-secondary m-1">View</a>
                            <a href="/images/{{ $image->getId() }}/edit" class="btn btn-primary m-1">Edit</a>
                            <form method="POST" action="/images/{{ $image->getId() }}">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger m-1">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    {{-- <div class="row justify-content-center pb-4">
        <div class="col-md-4">
            <a href="/images/create" class="btn btn-primary btn-block">
                Add Photo
            </a>
        </div>
    </div> --}}
</div>
@endsection
