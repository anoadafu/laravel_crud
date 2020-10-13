@extends('layouts.app')

@section('content')
<div class="container">
<h1>All Categories:</h1>
    <div class="row justify-content-start mb-2">
        
        <table class="table table-bordered">
            <thead>
              <tr>
                {{-- <th scope="col">#</th> --}}
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Create at</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            @foreach($categories as $category)
                <tbody>
                <tr>
                    {{-- <th scope="row">{{ $loop->index }}</th> --}}
                    <td>{{ $category->id }}</td>
                    <td>
                        <form id="form-{{ $category->id }}" method="POST" action="/admin/categories/{{ $category->id }}">
                            @csrf
                            @method('PATCH')
                            <input type="text" name="title" value="{{ $category->title }}"/>
                            
                       </form>
                    </td>
                    <td>{{ $category->created_at }}</td>
                    <td>
                        <div class="row">
                            <input class="btn btn-primary mx-2" type="submit" form="form-{{ $category->id }}" value="Edit"/>
                            <form method="POST" action="/admin/categories/{{ $category->id }}">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                </tbody>
            @endforeach
          </table>
    </div>
    <div class="row justify-content-center mb-2">
        {{$categories->links()}}
    </div>
    <div class="row justify-content-start mb-2">
        <div class="col-md-4">
            <form method="POST" action="/admin/categories">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" id="title" placeholder="Title" name="title" required>
                    <small id="titleHelp" class="form-text text-muted">Up to 25 characters</small>
                </div>
                <button type="submit" class="btn btn-primary">Add New Category</button>
            </form>
        </div>
    </div>
</div>
@endsection
