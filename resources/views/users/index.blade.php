@extends('layouts.app')

@section('content')
<div class="container">
<h1>Registered Users:</h1>
    <div class="row justify-content-start pb-4">
        
        <table class="table table-bordered">
            <thead>
              <tr>
                {{-- <th scope="col">#</th> --}}
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">E-mail</th>
                <th scope="col">E-mail verified</th>
                <th scope="col">Create at</th>
                <th scope="col">Block</th>
              </tr>
            </thead>
            @foreach($users as $user)
                <tbody>
                <tr @if(auth()->user()->id == $user->id) class="table-success" @elseif($user->trashed())class="table-danger" @endif>
                    {{-- <th scope="row">{{ $loop->index }}</th> --}}
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>@if(!is_null($user->email_verified_at)) Yes @else No @endif</td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        @if(auth()->user()->id == $user->id)
                            It's your account
                        @elseif($user->trashed())
                            <form method="POST" action="/admin/users/{{ $user->id }}/restore">
                                @csrf
                                <button class="btn btn-primary">Restore</button>
                            </form>
                        @else
                            <form method="POST" action="/admin/users/{{ $user->id }}">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
                </tbody>
            @endforeach
          </table>
    </div>
    <div class="row justify-content-center pb-4">
        {{$users->links()}}
    </div>
</div>
@endsection
