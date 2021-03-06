@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-start pb-4">
        
        @foreach($images as $image)
            <div class="col-md-4 pb-4">
                <div class="card">
                    <img class="card-img-top image-height" src="{{ $image->thumb_url() }}" alt="Image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $image->title }}</h5>
                        <p class="card-text text-muted">{{ $image->category->title }}</p>
                        <p class="card-text">{{ Str::words($image->description, $words = 15, $end='...') }}</p>
                        <div class="row">
                            <a href="/images/{{ $image->id }}" class="btn btn-secondary m-1">View</a>
                            @can('update-delete-image', $image)
                                <a href="/images/{{ $image->id }}/edit" class="btn btn-primary m-1">Edit</a>
                                <form method="POST" action="/images/{{ $image->id }}">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger m-1">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row justify-content-center pb-4">
        {{$images->links()}}
    </div>
    <div class="row justify-content-center pb-4">
        <div class="col-md-4">
            @guest
                <a class="btn btn-secondary btn-block" href="{{ route('register') }}">{{ __('Register to add Image') }}</a>
            @else
                <a href="/images/create" class="btn btn-primary btn-block">
                    Add Photo
                </a>
            @endguest
        </div>
    </div>
</div>
@endsection
