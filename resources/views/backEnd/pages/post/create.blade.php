@extends('layouts.backEnd')
@section('backendContent')
{{-- {{ dd($allTags) }} --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Post Create</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('frontEnd.home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('post.index') }}">Post list</a> </li>
                        <li class="breadcrumb-item active">Create post </li>
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
                        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Post Tite</label>
                                    <input type="text" name="title" class="form-control" id="exampleInputEmail1"
                                        placeholder="Enter post title" value="{{ old('title') }}">
                                    <div>
                                        @error('title')
                                            <div class="alert-default-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Post Category</label>
                                    <select class="form-control" name="category_id" id="">
                                         <option value=""> Select </option>
                                        @foreach($allCategories as $category)
                                            <option {{ old('category_id') == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div>
                                        @error('category_id')
                                            <div class="alert-default-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="postImage">Post Image</label>
                                    <input type="file" name="image" class="form-control" id="postImage"
                                       >
                                    <div>
                                        @error('image')
                                            <div class="alert-default-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="postDescription">Description</label>
                                    <textarea name="description" class="form-control" id="postDescription"
                                        placeholder="Enter description" rows="10">{{ old('description') }}</textarea>

                                     <div>
                                        @error('description')
                                            <div class="alert-default-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
