@extends('layouts.backEnd')
@section('backendContent')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Tag List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('frontEnd.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Tag </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-end pb-1">
                <a href="{{ route('tag.create') }}" class="btn btn-primary">Tag Create</a>
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
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Post Count</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($tags) > 0)

                                    @foreach ($tags as $tag)
                                        <tr>
                                            <td>{{ $tag->id }}</td>

                                            <td>
                                                {{ $tag->name }}
                                            </td>
                                            <td><span class="">{{ $tag->slug }}</span></td>
                                            <td><span class="">10</span></td>
                                            <td>
                                                <a href="{{ route('tag.show', ['tag' => $tag->id]) }}"
                                                    class="btn btn-secondary">Viiew </a>
                                                <a href="{{ route('tag.edit', ['tag' => $tag->id]) }}"
                                                    class="btn btn-secondary">Edit </a>
                                                <form class="d-inline-block"
                                                    action="{{ route('tag.destroy', ['tag' => $tag->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">
                                            <h1 class="text-center">No tags found</h1>
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
