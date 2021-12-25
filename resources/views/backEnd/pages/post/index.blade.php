@extends('layouts.backEnd')
@section('backendContent')
{{-- {{ dd($posts) }} --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Post List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('frontEnd.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Post </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-end pb-1">
                <a href="{{ route('post.create') }}" class="btn btn-primary">Post Create</a>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card-body p-0">
                        @if (session('error'))
                            <div class="alert alert-warning">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Tag</th>
                                    <th>Author</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($posts) > 0)
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td>
                                                {{ $post->id }}
                                            </td>
                                            <td>
                                                <div style="height: auto;max-width: 80px;">
                                                    <img src="{{ asset('storage/images/' . $post->image) }}"
                                                        class="img-fluid" alt="">
                                                </div>
                                            </td>
                                            <td>{{ $post->title }}</td>

                                            <td>
                                                {{ $post->category->name }}
                                            </td>
                                            <td>
                                               @foreach ($post->tags as $tag)
                                                    <span class="badge badge-primary">{{ $tag->name }}</span>
                                               @endforeach
                                            </td>
                                            <td>
                                                {{ $post->user->name }}
                                            </td>

                                            <td>
                                                <a href="{{ route('post.show', ['post' => $post->id]) }}"
                                                    class="btn btn-secondary">Viiew </a>
                                                <a href="{{ route('post.edit', ['post' => $post->id]) }}"
                                                    class="btn btn-warning">Edit </a>
                                                <form class="d-inline-block"
                                                    action="{{ route('post.destroy', ['post' => $post->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                                {{-- <button class="btn btn-secondary">View</button>
                                            <button class="btn btn-warning">Edit</button> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">
                                            <h1 class="text-center">No post found</h1>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
