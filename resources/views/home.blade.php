@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    {{-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif --}}

                    {{ __('You are logged in!') }}
                    @if(Auth::user()->is_admin())
                        <br>
                        <a class="btn btn-primary m-1" href="/admin/users">Manage Users</a>
                        <a class="btn btn-primary m-1" href="/admin/categories">Manage Category</a>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <a href="/images/create" class="btn btn-primary btn-block">
                Add Photo
            </a>
        </div>
    </div>
</div>
@endsection
