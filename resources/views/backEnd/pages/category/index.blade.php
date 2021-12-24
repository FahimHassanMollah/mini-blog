@extends('layouts.backEnd')
@section('backendContent')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Category List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('frontEnd.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Category </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-end pb-1">
                <a href="{{ route('category.create') }}" class="btn btn-primary">Category Create</a>
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
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>

                                        <td>
                                            {{ $category->name }}
                                        </td>
                                        <td><span class="">{{ $category->slug }}</span></td>
                                        <td><span class="">10</span></td>
                                        <td>
                                            <a href="{{ route('category.show', ['category' => $category->id]) }}"
                                                class="btn btn-secondary">Viiew </a>
                                            <a href="{{ route('category.edit', ['category' => $category->id]) }}"
                                                class="btn btn-secondary">Edit </a>
                                            <form class="d-inline-block"
                                                action="{{ route('category.destroy', ['category' => $category->id]) }}"
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
