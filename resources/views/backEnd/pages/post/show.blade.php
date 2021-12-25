@extends('layouts.backEnd')
@section('backendContent')
    {{-- {{ dd($posts) }} --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Post Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('frontEnd.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('post.index') }}">Post list</a></li>
                        <li class="breadcrumb-item active">Post Details</li>
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
                        <table class="table table-bordered table-hover">

                            <tbody>
                                <tr>
                                    <td style="width: 20%">Title</td>
                                    <td style="width: 80%">{{ $post->title }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Image</td>
                                    <td style="width: 80%">
                                        <div style="height: auto;max-width: 150px;">
                                            <img src="{{ asset('storage/images/' . $post->image) }}"
                                                class="img-fluid" alt="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Category</td>
                                    <td style="width: 80%">
                                        {{ $post->category->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Tags</td>
                                    <td style="width: 80%">
                                        @foreach ($post->tags as $tag)
                                            <span class="badge badge-primary">{{ $tag->name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">User</td>
                                    <td style="width: 80%">
                                       {{ $post->user->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Description</td>
                                    <td style="width: 80%">
                                       {!! $post->description !!}
                                    </td>
                                </tr>



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
