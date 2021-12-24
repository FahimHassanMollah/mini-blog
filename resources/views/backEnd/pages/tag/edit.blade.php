@extends('layouts.backEnd')
@section('backendContent')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Tag Edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('frontEnd.home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('tag.index') }}">Tag list</a> </li>
                        <li class="breadcrumb-item active">Edit tag </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-8 mx-auto">
                    <div class="card ">
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
                        <form action="{{ route('tag.update',['tag'=>$tag->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tag Name</label>
                                    <input type="text" name="name" value="{{ $tag->name }}" class="form-control" id="exampleInputEmail1"
                                        placeholder="Enter tag name">
                                    <div>
                                        @error('name')
                                            <div class="alert-default-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Description</label>
                                    {{-- <input type="password" class="form-control" id="exampleInputPassword1"
                                        placeholder="Password"> --}}
                                    <textarea name="description" class="form-control" id=""
                                        placeholder="Enter description" rows="10">{{ $tag->description }}</textarea>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
